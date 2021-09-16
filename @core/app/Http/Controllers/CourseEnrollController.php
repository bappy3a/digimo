<?php

namespace App\Http\Controllers;

use App\CourseEnroll;
use App\Helpers\NexelitHelpers;
use App\Mail\BasicMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CourseEnrollController extends Controller
{
    public function all(){
        $all_enroll = CourseEnroll::all();
        return view('backend.courses.enroll-all')->with(['all_enroll' => $all_enroll]);
    }

    public function delete($id){
        CourseEnroll::findOrFail($id)->delete();
        return back()->with(NexelitHelpers::item_delete());
    }

    public function reminder(Request $request){
        $enroll_details = CourseEnroll::findOrFail($request->id);
        //send mail to customer to notify his payment is approve, send mail using basic template
        $message = __('Hello').' '.$enroll_details->name.'<br>';
        $message .= __('you have a pending Course Enroll id').' #'.$enroll_details->id.' '.__('at').' '.get_static_option('site_'.get_default_language().'_title').' ';
        $message .= ' '.'<div class="btn-wrap"><a href="'.route('user.home').'" class="anchor-btn">'.__('more info').'</a></div>';
        $subject = __('We are waiting for you').' '.$enroll_details->name;
        Mail::to($enroll_details->email)->send(new BasicMail(['subject' => $subject,'message' => $message]));

        return back()->with(NexelitHelpers::reminder_mail());
    }

    public function bulk_action(Request $request){
        CourseEnroll::whereIn('id',$request->ids)->delete();
        return response()->json(['ok']);
    }
    public function payment_approved($id){

        $enroll_details = CourseEnroll::findOrFail($id);
        $enroll_details->payment_status = 'complete';
        $enroll_details->status = 'complete';
        $enroll_details->save();

        $email = $enroll_details->email;
        //mail to admin
        $message = '<p>' . __('Hello') . ' ' . $enroll_details->name . '<br>';
        $message .= __('Your have enrolled in') .' "'.$enroll_details->course->lang->title. '" . '.__('enroll Id').' #' . $enroll_details->id . ' ';
        $message .= __('successful on') . ' ' . date_format($enroll_details->created_at, 'd F Y H:m:s'). ' ';
        $message .= __('via') . ' ' . ucwords(str_replace('_', ' ', $enroll_details->payment_gateway)). '. <br>';
        $message .= __('You have now full access to your enrolled courses'. ' ');
        $message .= __('checkout your dashboard for more info.') . '</p>';

        Mail::to($email)->send(new BasicMail([
            'subject' => __('you have successfully enrolled'),
            'message' => $message
        ]));

        return back()->with(NexelitHelpers::payment_approved());
    }

    public function view($id){
        $enroll_details = CourseEnroll::findOrFail($id);
        return view('backend.courses.course-enroll-view')->with(['enroll_details' => $enroll_details]);
    }
}
