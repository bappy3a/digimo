<?php

namespace App\Http\Controllers;

use Anand\LaravelPaytmWallet\Facades\PaytmWallet;
use App\AppointmentBooking;
use App\Course;
use App\CourseEnroll;
use App\Donation;
use App\DonationLogs;
use App\EventAttendance;
use App\EventPaymentLogs;
use App\Events;
use App\Events\JobApplication;
use App\Http\Traits\PaytmTrait;
use App\JobApplicant;
use App\Jobs;
use App\Mail\BasicMail;
use App\Mail\ContactMessage;
use App\Mail\DonationMessage;
use App\Mail\PaymentSuccess;
use App\Mail\PlaceOrder;
use App\Order;
use App\PaymentLogs;
use App\PricePlan;
use App\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use KingFlamez\Rave\Facades\Rave;
use phpDocumentor\Reflection\Types\Self_;
use Razorpay\Api\Api;
use Stripe\Charge;
use Mollie\Laravel\Facades\Mollie;
use Stripe\Stripe;
use Unicodeveloper\Paystack\Facades\Paystack;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Illuminate\Support\Facades\Session;
use function App\Http\Traits\getChecksumFromArray;

class PaymentLogController extends Controller
{

    private const SUCCESS_ROUTE = 'frontend.order.payment.success';
    private const CANCEL_ROUTE = 'frontend.order.payment.cancel';

    public function order_payment_form(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'order_id' => 'required|string',
            'payment_gateway' => 'required|string',
        ]);
        if (!get_static_option('disable_guest_mode_for_package_module') && !auth()->guard('web')->check()){
            return back()->with(['type' => 'warning','msg' => __('login to place an order')]);
        }
        $order_details = Order::find($request->order_id);
        $payment_details = PaymentLogs::where('order_id', $request->order_id)->first();
        if (empty($payment_details)) {
            $payment_log_id = PaymentLogs::create([
                'email' => $request->email,
                'name' => $request->name,
                'package_name' => $order_details->package_name,
                'package_price' => $order_details->package_price,
                'package_gateway' => $request->payment_gateway,
                'order_id' => $request->order_id,
                'status' => 'pending',
                'track' => Str::random(10) . Str::random(10),
            ])->id;
            $payment_details = PaymentLogs::find($payment_log_id);
        }


        if ($request->payment_gateway === 'paypal') {

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
                'amount' => $payment_details->package_price,
                'description' => 'Payment For Package Order Id: #' . $request->order_id . ' Package Name: ' . $payment_details->package_name . ' Payer Name: ' . $request->name . ' Payer Email:' . $request->email,
                'item_name' => 'Payment For Package Order Id: #'.$request->order_id,
                'ipn_url' => route('frontend.paypal.ipn'),
                'cancel_url' => route(self::CANCEL_ROUTE,$payment_details->id),
                'payment_track' => $payment_details->track,
            ]);

            session()->put('order_id',$request->order_id);
            return redirect()->away($redirect_url);

        } elseif ($request->payment_gateway === 'paytm') {

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
                'order_id' => $payment_details->track,
                'email' => $payment_details->email,
                'name' => $payment_details->name,
                'amount' => $payment_details->package_price,
                'callback_url' => route('frontend.paytm.ipn')
            ]);
            return $redirect_url;

        } elseif ($request->payment_gateway === 'manual_payment') {

            event(new Events\PackagesOrderSuccess([
                'order_id' =>  $request->order_id,
                'transaction_id' => $request->trasaction_id
            ]));

            $order_id = Str::random(6) . $request->order_id . Str::random(6);
            return redirect()->route('frontend.order.payment.success', $order_id);

        } elseif ($request->payment_gateway === 'stripe') {

            $stripe_data['order_id'] = $payment_details->order_id;
            $stripe_data['route'] = route('frontend.stripe.charge');
            return view('payment.stripe')->with('stripe_data', $stripe_data);

        } elseif ($request->payment_gateway === 'razorpay') {
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
                'price' => $payment_details->package_price,
                'title' => $payment_details->package_name,
                'description' => 'Payment For Package Order Id: #'.$payment_details->id.' Plan Name: '.$payment_details->package_name.' Payer Name: '.$payment_details->name.' Payer Email:'.$payment_details->email,
                'route' => route('frontend.razorpay.ipn'),
                'order_id' => $payment_details->order_id
            ]);
            return $redirect_url;

        } elseif ($request->payment_gateway === 'paystack') {
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
                'amount' => $payment_details->package_price,
                'package_name' => $payment_details->package_name,
                'name' => $payment_details->name,
                'email' => $payment_details->email,
                'order_id' => $payment_details->order_id,
                'track' => $payment_details->track,
                'type' => 'order',
                'route' => route('frontend.paystack.pay'),
            ]);
            return $view_file;

        } elseif ($request->payment_gateway === 'mollie') {

            /**
             * @required param list
             * amount
             * description
             * redirect_url
             * order_id
             * track
             * */
            $return_url =  mollie_gateway()->charge_customer([
                'amount' => $payment_details->package_price,
                'description' => 'Payment For Order Id: #' . $request->order_id . ' Package Name: ' . $payment_details->package_name . ' Payer Name: ' . $request->name . ' Payer Email:' . $request->email,
                'web_hook' => route('frontend.mollie.webhook'),
                'order_id' => $payment_details->order_id,
                'track' => $payment_details->track,
            ]);
            return $return_url;

        } elseif ($request->payment_gateway == 'flutterwave') {

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
                'name' => $payment_details->package_name,
                'email' => $payment_details->email,
                'order_id' => $payment_details->order_id,
                'amount' => $payment_details->package_price,
                'track' => $payment_details->track,
                'description' =>  'Payment For Order Id: #'.$payment_details->id.' Package Name: '.$payment_details->package_name.' Payer Name: '.$payment_details->name.' Payer Email:'.$payment_details->email,
                'callback' => route('frontend.flutterwave.callback'),
            ]);
            return $view_file;

        }


        return redirect()->route('homepage');
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
            $payment_details = PaymentLogs::where( 'track', $payment_data['track'] )->first();
            event(new Events\PackagesOrderSuccess([
                'order_id' => $payment_details->order_id,
                'transaction_id' => $payment_data['transaction_id']
            ]));
            $order_id = random_int(123456,999999) .  $payment_details->order_id. random_int(123456,999999);
            return redirect()->route(self::SUCCESS_ROUTE,$order_id);
        }
        abort(404);

    }

    public function mollie_webhook()
    {
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
            event(new Events\PackagesOrderSuccess([
                'order_id' => $payment_data['order_id'],
                'transaction_id' => $payment_data['transaction_id']
            ]));
            $order_id = Str::random(6) . $payment_data['order_id']. Str::random(6);
            return redirect()->route(self::SUCCESS_ROUTE,$order_id);
        }
        abort(404);
    }


    public function paypal_ipn(Request $request)
    {
        $order_id = session()->get('order_id');
        session()->forget('order_id');
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
            'cancel_url' => route(self::CANCEL_ROUTE,$order_id),
            'success_url' => route(self::SUCCESS_ROUTE,$order_id)
        ]);
        if (isset($payment_data['status']) && $payment_data['status'] === 'complete'){
            event(new Events\PackagesOrderSuccess([
                'order_id' => $order_id,
                'transaction_id' => $payment_data['transaction_id']
            ]));
            $order_id = Str::random(6) . $order_id . Str::random(6);
            return redirect()->route(self::SUCCESS_ROUTE,$order_id);
        }
        return redirect()->route(self::CANCEL_ROUTE,$order_id);
    }

    public function paytm_ipn(Request $request)
    {        $order_id = $request['ORDERID'];
        $payment_logs = PaymentLogs::where( 'track', $order_id )->first();
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
            event(new Events\PackagesOrderSuccess([
                'order_id' => $payment_logs->order_id,
                'transaction_id' => $payment_data['transaction_id']
            ]));
            $order_id = Str::random(6) . $payment_logs->order_id . Str::random(6);
            return redirect()->route(self::SUCCESS_ROUTE,$order_id);
        }
        return redirect()->route(self::CANCEL_ROUTE,$payment_logs->id);
    }
    public function stripe_ipn(Request $request){
        /**
         * @require params
         * */
        $order_id = session()->get('stripe_order_id');
        session()->forget('stripe_order_id');

        $payment_data = stripe_gateway()->ipn_response();
        if (isset($payment_data['status']) && $payment_data['status'] === 'complete'){
            event(new Events\PackagesOrderSuccess([
                'order_id' => $order_id,
                'transaction_id' => $payment_data['transaction_id']
            ]));
            $encoded_order_id = Str::random(6) . $order_id . Str::random(6);
            return redirect()->route(self::SUCCESS_ROUTE,$encoded_order_id);
        }
        return redirect()->route(self::CANCEL_ROUTE,$order_id);
    }

    public function stripe_charge(Request $request)
    {
        $order_details = PaymentLogs::where('order_id',$request->order_id)->first();

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
            'product_name' => $order_details->package_name,
            'amount' => $order_details->package_price,
            'description' => 'Payment From '. get_static_option('site_'.get_default_language().'_title').'. Package Order ID #'.$order_details->id .', Payer Name: '.$order_details->name.', Payer Email: '.$order_details->email,
            'ipn_url' => route('frontend.stripe.ipn'),
            'order_id' => $request->order_id,
            'cancel_url' => route(self::SUCCESS_ROUTE,$request->order_id)
        ]);
        return response()->json(['id' => $stripe_session['id']]);
    }

    public function razorpay_ipn(Request $request)
    {
        $order_id = $request->order_id;
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
            event(new Events\PackagesOrderSuccess([
                'order_id' => $order_id,
                'transaction_id' => $payment_data['transaction_id']
            ]));
            $order_enc_id = Str::random(6) . $order_id. Str::random(6);
            return redirect()->route(self::SUCCESS_ROUTE,$order_enc_id);
        }
        return redirect()->route(self::CANCEL_ROUTE,$order_id);

    }

    public function paystack_pay()
    {
        return Paystack::getAuthorizationUrl()->redirectNow();
    }

    public function paystack_callback(Request $request)
    {
        $paymentDetails = Paystack::getPaymentData();

        if ($paymentDetails['status']) {
            $meta_data = $paymentDetails['data']['metadata'];
            if ($meta_data['type'] === 'order') {
                $payment_log_details = PaymentLogs::where('track', $meta_data['track'])->first();

                event(new Events\PackagesOrderSuccess([
                    'order_id' => $payment_log_details->order_id,
                    'transaction_id' => $paymentDetails['data']['reference']
                ]));
                $order_id = Str::random(6) . $payment_log_details->order_id . Str::random(6);
                return redirect()->route('frontend.order.payment.success', $order_id);

            } elseif ($meta_data['type'] == 'event') {

                $payment_log_details = EventPaymentLogs::where('track', $meta_data['track'])->first();

                event(new Events\AttendanceBooking([
                    'attendance_id' => $payment_log_details->attendance_id,
                    'transaction_id' => $paymentDetails['data']['reference']
                ]));

                $order_id = Str::random(6) . $payment_log_details->attendance_id . Str::random(6);
                return redirect()->route('frontend.event.payment.success', $order_id);

            } elseif ($meta_data['type'] == 'donation') {

                $payment_log_details = DonationLogs::where('track', $meta_data['track'])->first();
                event(new Events\DonationSuccess([
                    'donation_log_id' => $payment_log_details->id,
                    'transaction_id' =>  $paymentDetails['data']['reference'],
                ]));

                $order_id = Str::random(6) . $payment_log_details->id . Str::random(6);
                return redirect()->route('frontend.donation.payment.success', $order_id);

            } elseif ($meta_data['type'] == 'job') {

                $job_applicant_details = JobApplicant::where('track', $meta_data['track'])->first();
                event(new JobApplication([
                    'transaction_id' => $paymentDetails['data']['reference'],
                    'job_application_id' => $job_applicant_details->id
                ]));
                $order_id = Str::random(6) . $job_applicant_details->id . Str::random(6);
                return redirect()->route('frontend.job.payment.success', $order_id);

            } elseif ($meta_data['type'] == 'product') {

                $product_order_details = ProductOrder::where('payment_track', $meta_data['track'])->first();
                event(new Events\ProductOrders([
                    'order_id' => $product_order_details->id,
                    'transaction_id' => $paymentDetails['data']['reference']
                ]));

                $order_id = Str::random(6) . $product_order_details->id . Str::random(6);
                return redirect()->route('frontend.product.payment.success', $order_id);

            } elseif ($meta_data['type'] == 'appointment') {

                $booking_details = AppointmentBooking::where('payment_track', $meta_data['track'])->first();
                AppointmentBooking::findOrFail($booking_details->id)->update([
                    'transaction_id' => $paymentDetails['data']['reference'],
                    'payment_status' => 'complete',
                    'status' => 'confirm'
                ]);

                $new_appointment_booking = AppointmentBooking::findOrFail($booking_details->id);
                $all_custom_fields = $new_appointment_booking->custom_fields;
                unset($all_custom_fields['appointment_id']);
                $all_custom_fields['booking_id'] = '#' . $new_appointment_booking->id;
                //mail to admin
                $admin_email = get_static_option('appointment_notify_mail') ?? get_static_option('site_global_email');
                Mail::to($admin_email)->send(new ContactMessage(
                    $all_custom_fields,
                    $new_appointment_booking->all_attachment,
                    __('you have new appointment booking')
                ));
                //mail to user
                Mail::to($new_appointment_booking->email)->send(new ContactMessage(
                    $all_custom_fields,
                    $new_appointment_booking->all_attachment,
                    __('you have new appointment booking')
                ));

                $order_id = random_int(123456, 999999) . $booking_details->id . random_int(123456, 999999);
                return redirect()->route('frontend.appointment.payment.success', $order_id);
            } elseif ($meta_data['type'] == 'course') {

                $enroll_details = CourseEnroll::where('payment_track', $meta_data['track'])->first();
                $enroll_details->transaction_id = $paymentDetails['data']['reference'];
                $enroll_details->payment_status = 'complete';
                $enroll_details->status = 'complete';
                $enroll_details->save();

                //increase enrolled strudent number in course table
                $course = Course::findOrFail($enroll_details->course_id);
                $course->enrolled_student = $course->enrolled_student + 1;
                $course->save();

                $enroll_details = CourseEnroll::findOrFail($enroll_details->id);

                //mail to user
                $message = '<p>' . __('Hello') . ' ' . $enroll_details->name . '<br>';
                $message .= __('Your have enrolled in') .' "'.$enroll_details->course->lang->title. '" . '.__('enroll Id').' #' . $enroll_details->id . ' ';
                $message .= __('successful on') . ' ' . date_format($enroll_details->created_at, 'd F Y H:m:s'). ' ';
                $message .= __('via') . ' ' . ucwords(str_replace('_', ' ', $enroll_details->payment_gateway)). '. <br>';
                $message .= __('You have now full access to your enrolled courses'. ' ');
                $message .= __('checkout your dashboard for more info.') . '</p>';

                Mail::to($enroll_details->email)->send(new BasicMail([
                    'subject' => __('you have successfully enrolled'),
                    'message' => $message
                ]));
                $admin_email = get_static_option('course_notify_mail') ?? get_static_option('site_global_email');
                //mail to admin
                $message = '<p>' . __('Hello') . '<br>';
                $message .= __('Your have a enrollment for course') .' "'.$enroll_details->course->lang->title. '" . '.__('enroll Id'). ' #' . $enroll_details->id . ' ';
                $message .= __('successful on') . ' ' . date_format($enroll_details->created_at, 'd F Y H:m:s'). ' ';
                $message .= __('via') . ' ' . ucwords(str_replace('_', ' ', $enroll_details->payment_gateway)). ' <br>';
                $message .= __('checkout your dashboard for more info.') . '</p>';

                Mail::to($admin_email)->send(new BasicMail([
                    'subject' => __('you have a new course enrollment'),
                    'message' => $message
                ]));
                $order_id = random_int(123456,999999) . $enroll_details->id. random_int(123456,999999);
                return redirect()->route('frontend.course.payment.success',$order_id);

            } else {
                return redirect()->route('homepage');
            }
            } else {
                return redirect()->route('homepage');
            }
        }

        public function update_database($order_id, $transaction_id)
        {
            Order::find($order_id)->update(['payment_status' => 'complete']);
            PaymentLogs::where('order_id', $order_id)->update(['transaction_id' => $transaction_id, 'status' => 'complete']);
        }

        public function send_order_mail($order_id)
        {

            $order_details = Order::find($order_id);
            $package_details = PricePlan::where('id', $order_details->package_id)->first();
            $payment_details = PaymentLogs::where('order_id', $order_id)->first();
            $all_fields = unserialize($order_details->custom_fields,['class' => false]);
            unset($all_fields['package']);

            $all_attachment = unserialize($order_details->attachment,['class' => false]);
            $order_page_form_mail = get_static_option('order_page_form_mail');
            $order_mail = $order_page_form_mail ? $order_page_form_mail : get_static_option('site_global_email');

            $subject = __('your have an package order');
            $message = __('your have an package order.') . ' #' . $order_id;
            $message .= ' ' . __('at') . ' ' . date_format($order_details->created_at, 'd F Y H:m:s');
            $message .= ' ' . __('via') . ' ' . str_replace('_', ' ', $payment_details->package_gateway);

            Mail::to($order_mail)->send(new PlaceOrder([
                'data' => $order_details,
                'subject' => $subject,
                'message' => $message,
                'package' => $package_details,
                'attachment_list' => $all_attachment,
                'payment_log' => $payment_details
            ]));

            $subject = __('your order has been placed');
            $message = __('your order has been placed.') . ' #' . $order_id;
            $message .= ' ' . __('at') . ' ' . date_format($order_details->created_at, 'd F Y H:m:s');
            $message .= ' ' . __('via') . ' ' . str_replace('_', ' ', $payment_details->package_gateway);
            Mail::to($payment_details->email)->send(new PlaceOrder([
                'data' => $order_details,
                'subject' => $subject,
                'message' => $message,
                'package' => $package_details,
                'attachment_list' => $all_attachment,
                'payment_log' => $payment_details
            ]));
        }
}
