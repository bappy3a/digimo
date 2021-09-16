<?php

namespace App\Http\Controllers\Frontend;

use App\Appointment;
use App\AppointmentBooking;
use App\AppointmentBookingTime;
use App\Http\Controllers\Controller;
use App\Mail\BasicMail;
use App\Mail\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use KingFlamez\Rave\Facades\Rave as Flutterwave;

class AppointmentBookingController extends Controller
{
    public $success_route = 'frontend.appointment.payment.success';
    public $cancel_route = 'frontend.appointment.payment.cancel';

    public function booking(Request $request){
        $this->validate($request,[
           'name' => 'required|string|max:191',
           'booking_date' => 'required|string|max:191',
           'appointment_id' => 'required|string|max:191',
           'booking_time_id' => 'required|string|max:191',
           'email' => 'required|email|max:191',
        ],[
            'name.required' => __('name is required'),
            'email.required' => __('email is required'),
            'booking_date.required' => __('select date'),
            'booking_time_id.required' => __('select time'),
        ]);
        if (!get_static_option('disable_guest_mode_for_appointment_module') && !auth()->guard('web')->check()){
            return back()->with(['type' => 'warning','msg' => __('login to place an order')]);
        }
        $appointment = Appointment::findOrFail($request->appointment_id);
        $max_appointment = AppointmentBooking::where(['appointment_id' => $appointment->id, 'booking_date' => date('d-m-y')])->count();

        if ( $max_appointment >= $appointment->max_appointment){
            $data['type'] = 'danger';
            $data['msg'] = __('no more appointment is not available for today');
            return back()->with($data);
        }

        if (empty($request->booking_id)){
            //check custom field validation
            $validated_data = $this->get_filtered_data_from_request(get_static_option('appointment_booking_page_form_fields'),$request);
            $all_attachment = $validated_data['all_attachment'];
            $all_field_serialize_data = $validated_data['field_data'];
            unset($all_field_serialize_data['captcha_token']);
            unset($all_field_serialize_data['transaction_id']);
            $booking_time = AppointmentBookingTime::find($all_field_serialize_data['booking_time_id']);
            $all_field_serialize_data['booking_time'] = $booking_time ? $booking_time->time : __('no time slot selected');
            unset($all_field_serialize_data['booking_time_id']);
            if (empty($request->selected_payment_gateway )){
                unset($all_field_serialize_data['payment_gateway']);
            }

            //save content to database
            $new_appointment =  AppointmentBooking::create([
                'custom_fields' => $all_field_serialize_data,
                'all_attachment' => $all_attachment,
                'email' =>  $request->email,
                'name' => $request->name,
                'total' => $appointment->price,
                'appointment_id' => $appointment->id,
                'user_id' => auth()->guard('web')->check() ? auth()->guard('web')->user()->id : null,
                'payment_gateway' => $request->selected_payment_gateway ?? '',
                'payment_track' => Str::random(10) . Str::random(10),
                'transaction_id' => null,
                'payment_status' => !empty($appointment->price) ? 'pending' : '',
                'booking_date' => $request->booking_date,
                'booking_time_id' => $request->booking_time_id,
                'status' => 'pending',
            ]);
        }else{
            $new_appointment  = AppointmentBooking::findOrFail($request->booking_id);
        }



        // check is payment able
        if (!empty($appointment->price)){
        //check gateway type
        $selected_payment_gateway = $new_appointment->payment_gateway;

        // if manual then check transaction id validation
        if ($selected_payment_gateway === 'manual_payment'){
            $this->validate($request,[
                'transaction_id' => 'required|string'
            ],[
                'transaction_id.required' => __('transaction id is required')
            ]);
            AppointmentBooking::findOrFail($new_appointment->id)->update([
                'transaction_id' =>  $request->transaction_id
            ]);
        }

        //send to new method for payment process
            $payment_process = $selected_payment_gateway.'_process';
            $returned_value = $this->$payment_process($new_appointment->id);
            switch ($selected_payment_gateway){
                case ('paypal'):
                    return  redirect()->away($returned_value);
                    break;
                case ('stripe'):
                    $stripe_data['order_id'] = $new_appointment->id;
                    $stripe_data['route'] = route('frontend.appointment.stripe.ipn');
                    return view('payment.stripe')->with('stripe_data' ,$stripe_data);
                    break;
                default:
                    return $returned_value; //mollie, manual payment, razorpay,fluttewave,paystack
                    break;
            }

        }else{
            /* send mail to admin and customer */
            $this->send_mail($new_appointment->id);
        }

        $data['type'] = 'danger';
        $data['msg'] = __('something went wrong, try again');
        return back()->with($data);
    }



    public function manual_payment_process($booking_id){
        $this->send_mail($booking_id);
        return back()->with(['msg' => 'Booking success, we will contact you soon.','type' => 'success']);
    }
    /**
     * process paypal payment
     * @since 2.0.4
     * */
    public function paypal_process($booking_id){
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
        $booking_details = AppointmentBooking::findOrFail($booking_id);
        $redirect_url =  paypal_gateway()->charge_customer([
            'amount' => $booking_details->total,
            'description' => __('Payment For Appointment Booking Order Id:'). ' #'.$booking_details->id.' '.__('Payer Name: ').' '.$booking_details->name.' '.__('Payer Email:').' '.$booking_details->email,
            'item_name' => __('Payment For Appointment Booking Order Id:').' #'.$booking_details->id,
            'ipn_url' => route('frontend.appointment.paypal.ipn'),
            'cancel_url' => route($this->cancel_route,$booking_details->id),
            'payment_track' => $booking_details->payment_track,
        ]);
        session()->put('booking_id',$booking_details->id);
        return $redirect_url;

    }

    public function paypal_ipn(Request $request)
    {
        $booking_id = session()->get('booking_id');
        session()->forget('booking_id');
        if (empty($booking_id)){
            return abort(404);
        }
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
            'cancel_url' => route($this->cancel_route,$booking_id),
            'success_url' => route($this->success_route,$booking_id)
        ]);

        if (isset($payment_data['status']) && $payment_data['status'] === 'complete'){
            $this->update_database($booking_id, $payment_data['transaction_id']);
            $this->send_mail($booking_id);
            $order_id = random_int(123456,999999) . $booking_id . random_int(123456,999999) ;
            return redirect()->route($this->success_route,$order_id);
        }

        return redirect()->route($this->cancel_route,$booking_id);
    }

    /**
     * process mollie payment
     * @since 2.0.4
     * */
    public function mollie_process($booking_id){
        /**
         * @required param list
         * amount
         * description
         * redirect_url
         * order_id
         * track
         * */
        $booking_details = AppointmentBooking::findOrFail($booking_id);
        $return_url =  mollie_gateway()->charge_customer([
            'amount' =>$booking_details->total,
            'description' => __('Payment For Appointment Booking Order Id:'). ' #'.$booking_details->id.' '.__('Payer Name: ').' '.$booking_details->name.' '.__('Payer Email:').' '.$booking_details->email,
            'web_hook' => route('frontend.appointment.mollie.webhook'),
            'order_id' => $booking_details->id,
            'track' => $booking_details->payment_track,
        ]);
        return $return_url;
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
            $booking_details = AppointmentBooking::findOrFail($payment_data['order_id']);
            $this->update_database($booking_details->id, $payment_data['transaction_id']);
            $this->send_mail($booking_details->id);
            $order_id = random_int(123456,999999) . $booking_details->id. random_int(123456,999999) ;
            return redirect()->route($this->success_route,$order_id);
        }
        abort(404);
    }

    /**
     * process paytm payment
     * @since 2.0.4
     * */
    public function paytm_process($booking_id){
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


        $booking_details = AppointmentBooking::findOrFail($booking_id);
        $redirect_url =  paytm_gateway()->charge_customer([
            'order_id' => $booking_details->payment_track,
            'email' => $booking_details->email,
            'name' => $booking_details->name,
            'amount' => $booking_details->total,
            'callback_url' => route('frontend.appointment.paytm.ipn')
        ]);
        return $redirect_url;
    }

    public function paytm_ipn(Request $request){
        $order_id = $request['ORDERID'];
        $booking_details = AppointmentBooking::where( 'payment_track', $order_id )->first();
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
            $this->update_database($booking_details->id, $payment_data['transaction_id']);
            $this->send_mail($booking_details->id);
            $order_id = random_int(123456,999999) . $booking_details->id . random_int(123456,999999);
            return redirect()->route($this->success_route,$order_id);
        }
        return redirect()->route($this->cancel_route,$booking_details->id);

    }

    /**
     * process stripe payment
     * @since 2.0.4
     * */
    public function stripe_process($booking_id){}

    public function stripe_ipn(Request $request)
    {
        $booking_details = AppointmentBooking::findOrFail($request->order_id);

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
            'product_name' => __('Payment For Appointment Booking Id:'). ' #'.$booking_details->id,
            'amount' => $booking_details->total,
            'description' => __('Payment For Appointment Booking Id:'). ' #'.$booking_details->id.' '.__('Payer Name: ').' '.$booking_details->name.' '.__('Payer Email:').' '.$booking_details->email,
            'ipn_url' => route('frontend.appointment.stripe.success'),
            'order_id' => $booking_details->id,
            'cancel_url' => route($this->cancel_route,$booking_details->id)
        ]);
        return response()->json(['id' => $stripe_session['id']]);
    }

    public function stripe_success(Request $request){
        /**
         * @require params
         * */
        $booking_id = session()->get('stripe_order_id');
        session()->forget('stripe_order_id');

        $payment_data = stripe_gateway()->ipn_response();
        if (isset($payment_data['status']) && $payment_data['status'] === 'complete'){
            $this->update_database($booking_id, $payment_data['transaction_id']);
            $this->send_mail($booking_id);
            $order_id = random_int(123456,999999) . $booking_id .random_int(123456,999999);
            return redirect()->route($this->success_route,$order_id);
        }
        return redirect()->route($this->cancel_route,$booking_id);

    }

    /**
     * process razorpay payment
     * @since 2.0.4
     * */
    public function razorpay_process($booking_id){
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
        $booking_details = AppointmentBooking::findOrFail($booking_id);
        $redirect_url = razorpay_gateway()->charge_customer([
            'price' => $booking_details->total,
            'title' => __('Payment For Appointment Booking Id:'). ' #'.$booking_details->id,
            'description' => __('Payment For Appointment Booking Id:'). ' #'.$booking_details->id.' '.__('Payer Name: ').' '.$booking_details->name.' '.__('Payer Email:').' '.$booking_details->email,
            'route' => route('frontend.appointment.razorpay.ipn'),
            'order_id' => $booking_details->id
        ]);
        return $redirect_url;
    }

    public function razorpay_ipn(Request $request){

        $booking_details = AppointmentBooking::where('id',$request->order_id)->first();
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
            $this->update_database($booking_details->id, $payment_data['transaction_id']);
            $this->send_mail($booking_details->id);
            $order_id = random_int(123456,999999) . $booking_details->id. random_int(123456,999999);
            return redirect()->route($this->success_route,$order_id);
        }
        return redirect()->route($this->callAction(),$booking_details->id);
    }


    /**
     * process flutterwave payment
     * @since 2.0.4
     * */
    public function flutterwave_process($booking_id){
        /**
         * @required params
         * name
         * email
         * ipn_route
         * amount
         * description
         * order_id
         * track
         * callback
         *
         * */
        $booking_details = AppointmentBooking::findOrFail($booking_id);


        $view_file =  flutterwaverave_gateway()->charge_customer([
            'name' => $booking_details->name,
            'email' => $booking_details->email,
            'order_id' => $booking_details->id,
            'amount' => $booking_details->total,
            'track' => $booking_details->payment_track,
            'description' =>  __('Payment For Appointment Booking Id:'). ' #'.$booking_details->id.' '.__('Payer Name: ').' '.$booking_details->name.' '.__('Payer Email:').' '.$booking_details->email,
            'callback' => route('frontend.appointment.flutterwave.callback'),
        ]);
        return $view_file;
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
            $booking_details = AppointmentBooking::where( 'payment_track', $payment_data['track'] )->first();
            $this->update_database($booking_details->id, $payment_data['transaction_id']);
            $this->send_mail($booking_details->id);
            $order_id = random_int(123456,999999) . $booking_details->id. random_int(123456,999999);
            return redirect()->route($this->success_route,$order_id);
        }
        abort(404);
    }

    /**
     * process paystack payment
     * @since 2.0.4
     * */
    public function paystack_process($booking_id){
        /**
         * @required param list
         * 'amount'
         * 'package_name'
         * 'name'
         * 'email'
         * 'order_id'
         * 'track'
         * */
        $booking_details = AppointmentBooking::findOrFail($booking_id);
        $view_file = paystack_gateway()->charge_customer([
            'amount' => $booking_details->total,
            'package_name' => __('Payment For Appointment Booking Id:'). ' #'.$booking_details->id,
            'name' => $booking_details->name,
            'email' => $booking_details->email,
            'order_id' => $booking_details->id,
            'track' => $booking_details->payment_track,
            'type' => 'appointment',
            'route' => route('frontend.paystack.pay'),
        ]);
        return $view_file;
    }


    /**
     * send mail to customer and admin about new appointment booking
     * @since 2.0.4
     * */
    public function send_mail($appointment_booking_id)
    {
        $new_appointment_booking = AppointmentBooking::findOrFail($appointment_booking_id);
        $all_custom_fields = $new_appointment_booking->custom_fields;
        unset($all_custom_fields['appointment_id']);
        $all_custom_fields['booking_id'] = '#'.$new_appointment_booking->id;
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
            __('you appointment is submitted')
        ));
    }

    private function update_database($booking_id, $transaction_id)
    {
        AppointmentBooking::findOrFail($booking_id)->update([
            'transaction_id' =>  $transaction_id,
            'payment_status' => 'complete',
            'status' => 'confirm'
        ]);
    }


    public function get_filtered_data_from_request($option_value,$request){

        $all_attachment = [];
        $all_quote_form_fields = (array) json_decode($option_value);
        $all_field_type = isset($all_quote_form_fields['field_type']) ? (array) $all_quote_form_fields['field_type'] : [];
        $all_field_name = isset($all_quote_form_fields['field_name']) ? $all_quote_form_fields['field_name'] : [];
        $all_field_required = isset($all_quote_form_fields['field_required'])  ? (object) $all_quote_form_fields['field_required'] : [];
        $all_field_mimes_type = isset($all_quote_form_fields['mimes_type']) ? (object) $all_quote_form_fields['mimes_type'] : [];

        //get field details from, form request
        $all_field_serialize_data = $request->all();
        unset($all_field_serialize_data['_token']);
        if (isset($all_field_serialize_data['captcha_token'])){
            unset($all_field_serialize_data['captcha_token']);
        }


        if (!empty($all_field_name)){
            foreach ($all_field_name as $index => $field){
                $is_required = !empty($all_field_required) && property_exists($all_field_required,$index) ? $all_field_required->$index : '';
                $mime_type = !empty($all_field_mimes_type) && property_exists($all_field_mimes_type,$index) ? $all_field_mimes_type->$index : '';
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
                    $attachment_name = 'attachment-'.Str::random(32).'-'. $field .'.'. $file_extenstion;
                    $filed_instance->move('assets/uploads/attachment/applicant', $attachment_name);
                    $all_attachment[$field] = 'assets/uploads/attachment/applicant/' . $attachment_name;
                }
            }
        }
        return [
            'all_attachment' => $all_attachment,
            'field_data' => $all_field_serialize_data
        ];
    }
}
