<?php

namespace App\Http\Controllers;

use Anand\LaravelPaytmWallet\Facades\PaytmWallet;
use App\Donation;
use App\DonationLogs;
use App\EventAttendance;
use App\EventPaymentLogs;
use App\Events;
use App\Http\Traits\PaytmTrait;
use App\Mail\ContactMessage;
use App\Mail\PaymentSuccess;
use App\Order;
use App\PaymentLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use KingFlamez\Rave\Facades\Rave;
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
use Razorpay\Api\Api;
use Stripe\Charge;
use Mollie\Laravel\Facades\Mollie;
use Stripe\Stripe;
use Unicodeveloper\Paystack\Facades\Paystack;
use function App\Http\Traits\getChecksumFromArray;

class EventPaymentLogsController extends Controller
{
    private const CANCEL_ROUTE = 'frontend.event.payment.cancel';
    private const SUCCESS_ROUTE = 'frontend.event.payment.success';

    public function booking_payment_form(Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'attendance_id' => 'required|string'
        ],
        [
            'name.required' => __('Name field is required'),
            'email.required' => __('Email field is required')
        ]);

        if (!get_static_option('disable_guest_mode_for_event_module') && !auth()->guard('web')->check()){
            return back()->with(['type' => 'warning','msg' => __('login to place an order')]);
        }

        $event_details = EventAttendance::find($request->attendance_id);
        $event_info = Events::find($event_details->event_id);
        $event_payment_details = EventPaymentLogs::where('attendance_id',$request->attendance_id)->first();

        if (!empty($event_info->cost) && $event_info->cost > 0){
            $this->validate($request,[
                'payment_gateway' => 'required|string'
            ],[
                'payment_gateway.required' => __('Select A Payment Method')
            ]);
        }

        if (empty($event_payment_details)){
            $payment_log_id = EventPaymentLogs::create([
                'email' =>  $request->email,
                'name' =>  $request->name,
                'event_name' =>  $event_details->event_name,
                'event_cost' =>  ($event_details->event_cost * $event_details->quantity),
                'package_gateway' =>  $request->payment_gateway,
                'attendance_id' =>  $request->attendance_id,
                'status' =>  'pending',
                'track' =>  Str::random(10). Str::random(10),
            ])->id;
            $event_payment_details = EventPaymentLogs::find($payment_log_id);
        }
        //have to work on below code
        if ($request->payment_gateway === 'paypal'){

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
                'amount' => $event_details->event_cost * $event_details->quantity,
                'description' =>'Payment For Event Order Id: #'.$event_details->id.' Event Name: '.$event_details->event_name.' Payer Name: '.$event_details->name.' Payer Email:'.$event_details->email,
                'item_name' => 'Payment For Event Order Id: #'.$event_details->id,
                'ipn_url' => route('frontend.event.paypal.ipn'),
                'cancel_url' => route(self::CANCEL_ROUTE,$event_details->id),
                'payment_track' => $event_details->track,
            ]);

            session()->put('attendance_id',$event_details->id);
            return redirect()->away($redirect_url);

        }elseif ($request->payment_gateway === 'paytm'){

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
                'order_id' => $event_details->id,
                'email' => $event_payment_details->email,
                'name' => $event_payment_details->name,
                'amount' => $event_details->event_cost * $event_details->quantity,
                'callback_url' => route('frontend.event.paytm.ipn')
            ]);
            return $redirect_url;

        }elseif ($request->payment_gateway === 'manual_payment'){
            //fire event
            event(new Events\AttendanceBooking([
                'attendance_id' => $request->attendance_id,
                'transaction_id' => $request->trasaction_id
            ]));

            $order_id = Str::random(6).$event_payment_details->attendance_id.Str::random(6);
            return redirect()->route(self::SUCCESS_ROUTE,$order_id);

        }elseif ($request->payment_gateway === 'stripe'){

            $stripe_data['order_id'] = $event_details->id;
            $stripe_data['route'] = route('frontend.event.stripe.charge');
            return view('payment.stripe')->with('stripe_data' ,$stripe_data);
        }
        elseif ($request->payment_gateway === 'razorpay'){
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
                'price' => $event_details->event_cost * $event_details->quantity,
                'title' => $event_details->event_name,
                'description' => 'Payment For Event Attendance Id: #'.$event_details->id.' Payer Name: '.$event_payment_details->name.' Payer Email:'.$event_payment_details->email,
                'route' => route('frontend.event.razorpay.ipn'),
                'order_id' => $event_details->id
            ]);
            return $redirect_url;

        }
        elseif ($request->payment_gateway == 'paystack'){


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
                'amount' => $event_details->event_cost * $event_details->quantity,
                'package_name' => $event_details->event_name,
                'name' => $event_payment_details->name,
                'email' => $event_payment_details->email,
                'order_id' => $event_details->id,
                'track' => $event_payment_details->track,
                'type' => 'event',
                'route' => route('frontend.paystack.pay'),
            ]);

            return $view_file;

        }
        elseif ($request->payment_gateway == 'mollie'){
            /**
             * @required param list
             * amount
             * description
             * redirect_url
             * order_id
             * track
             * */
            $return_url =  mollie_gateway()->charge_customer([
                'amount' => $event_details->event_cost * $event_details->quantity,
                'description' =>'Payment For Event Attendance  Id: #'.$event_details->id.' Payer Name: '.$event_payment_details->name.' Payer Email:'.$event_payment_details->email,
                'web_hook' => route('frontend.event.mollie.webhook'),
                'order_id' => $event_details->id,
                'track' => $event_details->track,
            ]);
            return $return_url;

        }elseif ($request->payment_gateway == 'flutterwave'){
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
                'name' => $event_payment_details->name,
                'email' => $event_payment_details->email,
                'order_id' => $event_details->id,
                'amount' => $event_details->event_cost * $event_details->quantity,
                'track' => $event_payment_details->track,
                'description' =>  'Payment For Event Attendance Id: #'.$event_details->id.' Payer Name: '.$event_payment_details->name.' Payer Email:'.$event_payment_details->email,
                'callback' => route('frontend.event.flutterwave.callback'),
            ]);
            return $view_file;

        }


        return redirect()->route('homepage');
    }

    /**
     * Obtain Rave callback information
     * @return \Illuminate\Http\RedirectResponse
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
            $event_payment_log = EventPaymentLogs::where( 'track', $payment_data['track'] )->first();
            event(new Events\AttendanceBooking([
                'attendance_id' => $event_payment_log->attendance_id,
                'transaction_id' => $payment_data['transaction_id']
            ]));
            $order_id = Str::random(6) . $event_payment_log->attendance_id . Str::random(6);
            return redirect()->route(self::SUCCESS_ROUTE,$order_id);
        }
        abort(404);
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
            event(new Events\AttendanceBooking([
                'attendance_id' => $payment_data['order_id'],
                'transaction_id' => $payment_data['transaction_id']
            ]));
            $order_id = Str::random(6) . $payment_data['order_id']. Str::random(6);
            return redirect()->route(self::SUCCESS_ROUTE,$order_id);
        }
        abort(404);
    }

    public function paypal_ipn(Request $request)
    {
        $attendance_id = session()->get('attendance_id');
        session()->forget('attendance_id');
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
            'cancel_url' => route(self::CANCEL_ROUTE,$attendance_id),
            'success_url' => route(self::SUCCESS_ROUTE,Str::random(6).$attendance_id.Str::random(6))
        ]);
        if (isset($payment_data['status']) && $payment_data['status'] === 'complete'){
            event(new Events\AttendanceBooking([
                'attendance_id' => $attendance_id,
                'transaction_id' => $payment_data['transaction_id']
            ]));

            $order_id = Str::random(6) . $attendance_id . Str::random(6);
            return redirect()->route(self::SUCCESS_ROUTE,$order_id);
        }
        return redirect()->route(self::CANCEL_ROUTE,$attendance_id);

    }

    public function paytm_ipn(Request $request){
        $attendance_id = $request['ORDERID'];
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
            event(new Events\AttendanceBooking([
                'attendance_id' => $attendance_id,
                'transaction_id' => $payment_data['transaction_id']
            ]));
            $order_id = Str::random(6) . $attendance_id . Str::random(6);
            return redirect()->route(self::SUCCESS_ROUTE,$order_id);
        }
        return redirect()->route(self::CANCEL_ROUTE,$attendance_id);
    }

    public function stripe_charge(Request $request){
        $attendance_details = EventAttendance::findOrFail($request->order_id);
        $event_payment_details = EventPaymentLogs::where('attendance_id',$request->order_id)->first();
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
            'product_name' => $attendance_details->event_name,
            'amount' => $attendance_details->event_cost * $attendance_details->quantity,
            'description' => 'Payment From '. get_static_option('site_'.get_default_language().'_title').' Payer Name: '.$event_payment_details->name.', Payer Email: '.$event_payment_details->email,
            'ipn_url' => route('frontend.event.stripe.ipn'),
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
        $event_attandence_id = session()->get('stripe_order_id');
        session()->forget('stripe_order_id');

        $payment_data = stripe_gateway()->ipn_response();
        if (isset($payment_data['status']) && $payment_data['status'] === 'complete'){
            event(new Events\AttendanceBooking([
                'attendance_id' => $event_attandence_id,
                'transaction_id' => $payment_data['transaction_id']
            ]));
            $order_id = Str::random(6) . $event_attandence_id . Str::random(6);
            return redirect()->route('frontend.event.payment.success',$order_id);
        }
        return redirect()->route('frontend.event.payment.cancel',$event_attandence_id);
    }


    public function razorpay_ipn(Request $request){

        $attendace_id = $request->order_id;
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
            event(new Events\AttendanceBooking([
                'attendance_id' => $attendace_id,
                'transaction_id' => $payment_data['transaction_id']
            ]));
            $order_id = Str::random(6) . $attendace_id. Str::random(6);
            return redirect()->route(self::SUCCESS_ROUTE,$order_id);
        }
        return redirect()->route(self::CANCEL_ROUTE,$attendace_id);

    }

    public function paystack_pay(){
        return Paystack::getAuthorizationUrl()->redirectNow();
    }

}
