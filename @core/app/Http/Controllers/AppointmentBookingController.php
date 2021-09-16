<?php

namespace App\Http\Controllers;

use App\AppointmentBooking;
use App\AppointmentBookingTime;
use App\Mail\BasicMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AppointmentBookingController extends Controller
{
    public $base_path = 'backend.appointment.';
    public function booking_all(){
        $all_booking = AppointmentBooking::orderBy('id','desc')->get();
        $all_booking_time = AppointmentBookingTime::where('status','publish')->get();
        return view($this->base_path.'appointment-booking-all')->with(['all_booking' => $all_booking,'all_booking_time' => $all_booking_time]);
    }

    public function bulk_action(Request $request){
        $all = AppointmentBooking::find($request->ids);
        foreach($all as $item){
            $item->delete();
        }
        return response()->json(['status' => 'ok']);
    }
    public function booking_delete($id){
        AppointmentBooking::findOrFail($id)->delete();
        return back()->with([
           'msg' => __('Delete Success'),
            'type' => 'danger'
        ]);
    }

    public function approve_payment($id){
        AppointmentBooking::findOrFail($id)->update([
           'payment_status' => 'complete',
           'status' => 'confirm'
        ]);

        $booking_details = AppointmentBooking::findOrFail($id);
        //send mail to customer to notify his payment is approve, send mail using basic template
        $message = __('Hello').' '.$booking_details->name.'<br>';
        $message .= __('your payment has been approved for booking id').' #'.$booking_details->id.' '.__('paid via').' '.str_replace('_',' ',$booking_details->payment_gateway).' ';
        $message .= __('at').' '.date('D,d F Y h:i:s',strtotime($booking_details->created_at));
        $subject = __('Your payment has been approved at').' '.get_static_option('site_'.get_default_language().'_title');
        Mail::to($booking_details->email)->send(new BasicMail(['subject' => $subject,'message' => $message]));

        return back()->with([
            'msg' => __('Payment Approved'),
            'type' => 'success'
        ]);
    }

    public function reminder_mail(Request $request){

        $booking_details = AppointmentBooking::findOrFail($request->id);
        //send mail to customer to notify his payment is approve, send mail using basic template
        $message = __('Hello').' '.$booking_details->name.'<br>';
        $message .= __('you have a pending booking id').' #'.$booking_details->id.' '.__('at').' '.get_static_option('site_'.get_default_language().'_title').' ';
        $message .= ' '.'<div class="btn-wrap"><a href="'.route('user.home').'" class="anchor-btn">'.__('more info').'</a></div>';
        $subject = __('We are waiting for you').' '.$booking_details->name;
        Mail::to($booking_details->email)->send(new BasicMail(['subject' => $subject,'message' => $message]));

        return back()->with([
            'msg' => __('Reminder mail send'),
            'type' => 'success'
        ]);
    }

    public function booking_view($id){
        $booking_details = AppointmentBooking::findOrFail($id);
        return view($this->base_path.'appointment-booking-view')->with(['booking_details' => $booking_details]);
    }

    public function booking_update(Request $request){
        $booking_details = AppointmentBooking::findOrFail($request->id);
        $booking_details->booking_time_id ='';
        $booking_details->booking_date = $request->booking_time_id;
        $booking_details->save();
        $new_booking_time = AppointmentBookingTime::findOrFail($request->booking_time_id);
        //send mail to customer to notify his payment is approve, send mail using basic template
        $message = __('Hello').' '.$booking_details->name.'<br>';
        $message .= __('your booking date and time updated, id').' #'.$booking_details->id.' ,'.__('new date').' '.$request->booking_date.' '.__(', Time').' '.$new_booking_time->time ?? __('not set');
        $subject = __('Your booking date and time updated');
        Mail::to($booking_details->email)->send(new BasicMail(['subject' => $subject,'message' => $message]));

        return back()->with([
            'msg' => __('Booking date and time updated'),
            'type' => 'success'
        ]);
    }

}
