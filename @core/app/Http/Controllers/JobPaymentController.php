<?php

namespace App\Http\Controllers;

use App\Events\JobApplication;
use App\Http\Traits\PaytmTrait;
use App\JobApplicant;
use App\Jobs;
use App\Mail\BasicMail;
use App\Mail\ContactMessage;
use App\Order;
use App\PaymentLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use KingFlamez\Rave\Facades\Rave;
use Mollie\Laravel\Facades\Mollie;
use Razorpay\Api\Api;
use Stripe\Charge;
use Stripe\Stripe;
use function App\Http\Traits\getChecksumFromArray;

class JobPaymentController extends Controller
{
    private const CANCEL_ROUTE = 'frontend.job.payment.cancel';
    private const SUCCESS_ROUTE = 'frontend.job.payment.success';

    public function store_jobs_applicant_data(Request $request)
    {
        $jobs_details = Jobs::find($request->job_id);
        $this->validate($request,[
            'email' => 'required|email',
            'name' => 'required|string',
            'job_id' => 'required',
        ],[
            'email.required' => __('email is required'),
            'email.email' => __('enter valid email'),
            'name.required' => __('name is required'),
            'job_id.required' => __('must apply to any job'),
        ]);
        if (!empty($jobs_details->application_fee_status) && $jobs_details->application_fee > 0){
            $this->validate($request,[
                'selected_payment_gateway' => 'required|string'
            ],
                ['selected_payment_gateway.required' => __('You must have to select a payment gateway')]);
        }

        if (!empty($jobs_details->application_fee_status) && $jobs_details->application_fee > 0 && $request->selected_payment_gateway == 'manual_payment'){
            $this->validate($request,[
                'transaction_id' => 'required|string'
            ],
           ['transaction_id.required' => __('You must have to provide your transaction id')]);
        }

        $job_applicant_id = JobApplicant::create([
            'jobs_id' => $request->job_id,
            'payment_gateway' => $request->selected_payment_gateway,
            'email' => $request->email,
            'name' => $request->name,
            'application_fee' => $request->application_fee,
            'track' => Str::random(30),
            'payment_status' => 'pending',
        ])->id;

        $all_attachment = [];
        $all_quote_form_fields = (array) json_decode(get_static_option('apply_job_page_form_fields'));
        $all_field_type = isset($all_quote_form_fields['field_type']) ? $all_quote_form_fields['field_type'] : [];
        $all_field_name = isset($all_quote_form_fields['field_name']) ? $all_quote_form_fields['field_name'] : [];
        $all_field_required = isset($all_quote_form_fields['field_required']) ? $all_quote_form_fields['field_required'] : [];
        $all_field_required = (object) $all_field_required;
        $all_field_mimes_type = isset($all_quote_form_fields['mimes_type']) ? $all_quote_form_fields['mimes_type'] : [];
        $all_field_mimes_type = (object) $all_field_mimes_type;

        //get field details from, form request
        $all_field_serialize_data = $request->all();
        unset($all_field_serialize_data['_token'],$all_field_serialize_data['job_id'],$all_field_serialize_data['name'],$all_field_serialize_data['email'],$all_field_serialize_data['selected_payment_gateway']);

        if (!empty($all_field_name)){
            foreach ($all_field_name as $index => $field){
                $is_required = property_exists($all_field_required,$index) ? $all_field_required->$index : '';
                $mime_type = property_exists($all_field_mimes_type,$index) ? $all_field_mimes_type->$index : '';
                $field_type = isset($all_field_type[$index]) ? $all_field_type[$index] : '';
                if (!empty($field_type) && $field_type == 'file'){
                    unset($all_field_serialize_data[$field]);
                }
                $validation_rules = !empty($is_required) ? 'required|': '';
                $validation_rules .= !empty($mime_type) ? $mime_type : '';

                //validate field
                $this->validate($request,[
                    $field => $validation_rules
                ]);

                if ($field_type == 'file' && $request->hasFile($field)) {
                    $filed_instance = $request->file($field);
                    $file_extenstion = $filed_instance->getClientOriginalExtension();
                    $attachment_name = 'attachment-'.$job_applicant_id.'-'. $field .'.'. $file_extenstion;
                    $filed_instance->move('assets/uploads/attachment/applicant', $attachment_name);
                    $all_attachment[$field] = 'assets/uploads/attachment/applicant/' . $attachment_name;
                }
            }
        }


        //update database
         JobApplicant::where('id',$job_applicant_id)->update([
            'form_content' => serialize($all_field_serialize_data),
            'attachment' => serialize($all_attachment)
        ]);
        $job_applicant_details = JobApplicant::where('id',$job_applicant_id)->first();

        //check it application fee applicable or not
        if (!empty($jobs_details->application_fee_status) && $jobs_details->application_fee > 0){
            //have to redirect  to payment gateway route


            if($job_applicant_details->payment_gateway === 'paypal'){

                /**
                 * @required param list
                 * $args['amount']
                 * $args['description']
                 * $args['item_name']
                 * $args['ipn_url']
                 * $args['cancel_url']
                 * $args['payment_track']
                 * return redirect url for paypal
                 * */
                $redirect_url =  paypal_gateway()->charge_customer([
                    'amount' => $job_applicant_details->application_fee,
                    'description' => __('Payment For Job Application Id:'). '#'.$job_applicant_details->id.' '.__('Job Title:').' '.$jobs_details->title.' '.__('Applicant Name:').' '.$job_applicant_details->name.' '.__('Applicant Email:').' '.$job_applicant_details->email,
                    'item_name' => __('Payment For Job Application Id:'). '#'.$job_applicant_details->id,
                    'ipn_url' => route('frontend.job.paypal.ipn'),
                    'cancel_url' => route(self::CANCEL_ROUTE,$job_applicant_details->id),
                    'payment_track' => $job_applicant_details->track,
                ]);
                session()->put('job_application_id',$job_applicant_details->id);
                return redirect()->away($redirect_url);

            }elseif ($job_applicant_details->payment_gateway === 'paytm'){
                /**
                 *
                 * charge_customer()
                 * @required params
                 * int order_id
                 * string name
                 * string email
                 * int/float amount
                 * string/url callback_url
                 * */
                $redirect_url =  paytm_gateway()->charge_customer([
                    'order_id' => $job_applicant_details->id,
                    'email' => $job_applicant_details->email,
                    'name' => $job_applicant_details->name,
                    'amount' => $job_applicant_details->application_fee,
                    'callback_url' => route('frontend.job.paytm.ipn')
                ]);
                return $redirect_url;

            }elseif ($job_applicant_details->payment_gateway === 'manual_payment'){

                event(new JobApplication([
                    'transaction_id' => $request->transaction_id,
                    'job_application_id' => $job_applicant_details->id
                ]));

                return redirect()->route(self::SUCCESS_ROUTE,random_int(666666,999999).$job_applicant_details->id.random_int(999999,999999));

            }elseif ($job_applicant_details->payment_gateway === 'stripe'){
                $stripe_data['order_id'] = $job_applicant_details->id;
                $stripe_data['route'] = route('frontend.job.stripe.charge');
                return view('payment.stripe')->with('stripe_data' ,$stripe_data);

            }elseif ($job_applicant_details->payment_gateway === 'razorpay'){

                /**
                 *
                 * @param array $args
                 * @paral list
                 * price
                 * title
                 * description
                 * route
                 * order_id
                 *
                 * @return @view with param
                 */
                $redirect_url = razorpay_gateway()->charge_customer([
                    'price' => $job_applicant_details->application_fee,
                    'title' => $jobs_details->title,
                    'description' => __('Payment For Job Application Id:'). '#'.$job_applicant_details->id.' '.__('Job Title:').' '.$jobs_details->title.' '.__('Applicant Name:').' '.$job_applicant_details->name.' '.__('Applicant Email:').' '.$job_applicant_details->email,
                    'route' => route('frontend.job.razorpay.ipn'),
                    'order_id' => $job_applicant_details->id
                ]);
                return $redirect_url;

            }elseif ($job_applicant_details->payment_gateway === 'paystack'){

                /**
                 * @required param list
                 * 'amount'
                 * 'package_name'
                 * 'name'
                 * 'email'
                 * 'order_id'
                 * 'track'
                 * */
                $view_file = paystack_gateway()->charge_customer([
                    'amount' => $job_applicant_details->application_fee,
                    'package_name' => $jobs_details->title,
                    'name' => $job_applicant_details->name,
                    'email' => $job_applicant_details->email,
                    'order_id' => $job_applicant_details->id,
                    'track' => $job_applicant_details->track,
                    'type' => 'job',
                    'route' => route('frontend.paystack.pay'),
                ]);

                return $view_file;

            }elseif ($job_applicant_details->payment_gateway === 'mollie'){


                /**
                 * @required param list
                 * amount
                 * description
                 * redirect_url
                 * order_id
                 * track
                 * */
                $return_url =  mollie_gateway()->charge_customer([
                    'amount' => $job_applicant_details->application_fee,
                    'description' => __('Payment For Job Application Id:'). '#'.$job_applicant_details->id.' '.__('Job Title:').' '.$jobs_details->title.' '.__('Applicant Name:').' '.$job_applicant_details->name.' '.__('Applicant Email:').' '.$job_applicant_details->email,
                    'web_hook' => route('frontend.job.mollie.webhook'),
                    'order_id' => $job_applicant_details->id,
                    'track' => $job_applicant_details->track,
                ]);
                return $return_url;

            }elseif ($job_applicant_details->payment_gateway === 'flutterwave'){


                /**
                 * @required params
                 * name
                 * email
                 * ipn_route
                 * amount
                 * description
                 * order_id
                 * track
                 *
                 * */
                $view_file =  flutterwaverave_gateway()->charge_customer([
                    'name' => $job_applicant_details->name,
                    'email' => $job_applicant_details->email,
                    'order_id' => $jobs_details->id,
                    'amount' => $job_applicant_details->application_fee,
                    'track' => $job_applicant_details->track,
                    'description' =>  __('Payment For Job Application Id:'). '#'.$job_applicant_details->id.' '.__('Job Title:').' '.$jobs_details->title.' '.__('Applicant Name:').' '.$job_applicant_details->name.' '.__('Applicant Email:').' '.$job_applicant_details->email,
                    'callback' => route('frontend.job.flutterwave.callback'),
                ]);
                return $view_file;
            }

            return redirect()->route('homepage');

        }else{
            $succ_msg = get_static_option('apply_job_' . get_user_lang() . '_success_message');
            $success_message = !empty($succ_msg) ? $succ_msg : __('Your Application Is Submitted Successfully!!');
             event(new JobApplication([
                'transaction_id' => '',
                'job_application_id' => $job_applicant_details->id
            ]));
            return redirect()->back()->with(['msg' => $success_message, 'type' => 'success']);
        }
    }

    /**
     * Obtain Rave callback information
     * @return void
     */
    public function flutterwave_callback(Request $request)
    {

        /**
         *
         * @param array $args
         * @required param list
         * request
         *
         * @return array
         */
        $payment_data = flutterwaverave_gateway()->ipn_response([
            'request' => $request
        ]);

        if (isset($payment_data['status']) && $payment_data['status'] === 'complete'){
            $job_applicant = JobApplicant::where( 'track', $payment_data['track'] )->first();
            event(new JobApplication([
                'transaction_id' => $payment_data['transaction_id'],
                'job_application_id' => $job_applicant->id
            ]));
            $order_id = Str::random(6) . $job_applicant->id . Str::random(6);
            return redirect()->route(self::SUCCESS_ROUTE,$order_id);
        }
        abort(404);
    }


    public function paypal_ipn(Request $request)
    {
        $job_application_id = session()->get('job_application_id');
        session()->forget('job_application_id');
        /**
         * @required param list
         * $args['request']
         * $args['cancel_url']
         * $args['success_url']
         *
         * return @void
         * */
        $payment_data = paypal_gateway()->ipn_response([
            'request' => $request,
            'cancel_url' => route(self::CANCEL_ROUTE,$job_application_id),
            'success_url' => route(self::SUCCESS_ROUTE,$job_application_id)
        ]);

        if (isset($payment_data['status']) && $payment_data['status'] === 'complete'){
            //register and fire event
            event(new JobApplication([
                'transaction_id' => $payment_data['transaction_id'],
                'job_application_id' => $job_application_id
            ]));

            $order_id = Str::random(6) . $job_application_id . Str::random(6);
            return redirect()->route(self::SUCCESS_ROUTE,$order_id);
        }
    }

    public function paytm_ipn(Request $request){

        $job_application_id = $request['ORDERID'];
        /**
         *
         * ipn_response()
         *
         * @return array
         * @param
         * transaction_id
         * status
         * */
        $payment_data = paytm_gateway()->ipn_response();
        if (isset($payment_data['status']) && $payment_data['status'] === 'complete'){
            event(new JobApplication([
                'transaction_id' => $payment_data['transaction_id'],
                'job_application_id' => $job_application_id
            ]));

            $order_id = Str::random(6) . $job_application_id . Str::random(6);
            return redirect()->route(self::SUCCESS_ROUTE,$order_id);
        }
        return redirect()->route(self::CANCEL_ROUTE,$job_application_id);
    }

    public function stripe_charge(Request $request){
        $job_applicant_details = JobApplicant::findOrFail($request->order_id);
        $job_details = Jobs::findOrFail($job_applicant_details->jobs_id);
        /**
         * @require params
         *
         * product_name
         * amount
         * description
         * ipn_url
         * cancel_url
         * order_id
         *
         * */

        $stripe_session =  stripe_gateway()->charge_customer([
            'product_name' => $job_details->title,
            'amount' => $job_applicant_details->application_fee,
            'description' => __('Payment For Job Application Id:'). '#'.$job_applicant_details->id.' '.__('Job Title:').' '.$job_details->title.' '.__('Applicant Name:').' '.$job_applicant_details->name.' '.__('Applicant Email:').' '.$job_applicant_details->email,
            'ipn_url' => route('frontend.job.stripe.ipn'),
            'order_id' => $request->order_id,
            'cancel_url' => route(self::CANCEL_ROUTE,$request->order_id)
        ]);
        return response()->json(['id' => $stripe_session['id']]);
    }

    public function stripe_ipn(Request $request)
    {

        /**
         * @require params
         * */
        $job_applicant_id = session()->get('stripe_order_id');
        session()->forget('stripe_order_id');

        $payment_data = stripe_gateway()->ipn_response();
        if (isset($payment_data['status']) && $payment_data['status'] === 'complete'){
            event(new JobApplication([
                'transaction_id' => $payment_data['transaction_id'],
                'job_application_id' => $job_applicant_id
            ]));
            $order_id = Str::random(6) . $job_applicant_id . Str::random(6);
            return redirect()->route(self::SUCCESS_ROUTE,$order_id);
        }
        return redirect()->route(self::CANCEL_ROUTE,$job_applicant_id);
    }

    public function razorpay_ipn(Request $request){

        $job_applicant_id = $request->order_id;
        /**
         *
         * @param array $args
         * require param list
         * request
         * @return array|string[]
         *
         */
        $payment_data = razorpay_gateway()->ipn_response(['request' => $request]);
        if (isset($payment_data['status']) && $payment_data['status'] === 'complete'){
            event(new JobApplication([
                'transaction_id' => $payment_data['transaction_id'],
                'job_application_id' => $job_applicant_id
            ]));
            $order_id = Str::random(6) . $job_applicant_id. Str::random(6);
            return redirect()->route(self::SUCCESS_ROUTE,$order_id);
        }
        return redirect()->route(self::CANCEL_ROUTE,$job_applicant_id);
    }

    public function mollie_webhook(){

        /**
         *
         * @param array $args
         * require param list
         * request
         * @return array|string[]
         *
         */
        $payment_data = mollie_gateway()->ipn_response();
        if (isset($payment_data['status']) && $payment_data['status'] === 'complete'){
            event(new JobApplication([
                'transaction_id' => $payment_data['transaction_id'],
                'job_application_id' =>$payment_data['order_id']
            ]));
            $order_id = Str::random(6) . $payment_data['order_id']. Str::random(6);
            return redirect()->route(self::SUCCESS_ROUTE,$order_id);
        }
        abort(404);
    }

}
