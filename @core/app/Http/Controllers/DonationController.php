<?php

namespace App\Http\Controllers;

use App\Donation;
use App\DonationLogs;
use App\EventAttendance;
use App\EventPaymentLogs;
use App\Language;
use App\Mail\BasicMail;
use App\Mail\DonationMessage;
use App\Mail\PaymentSuccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class DonationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function all_donation(){
        $all_donations = Donation::all()->groupBy('lang');
        return view('backend.donations.all-donations')->with(['all_donations' => $all_donations]);
    }
    public function new_donation(){
        $all_languages = Language::all();
        return view('backend.donations.new-donation')->with(['all_languages' => $all_languages]);
    }
    public function store_donation(Request $request){
        $this->validate($request,[
            'title' => 'required|string',
            'slug' => 'nullable|string',
            'lang' => 'required|string',
            'donation_content' => 'required|string',
            'amount' => 'required|string',
            'status' => 'required|string',
            'image' => 'nullable|string',
            'meta_tags' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ]);

        Donation::create([
            'title' => $request->title,
            'slug' => !empty($request->slug) ? $request->slug : Str::slug($request->title),
            'lang' => $request->lang,
            'donation_content' => $request->donation_content,
            'amount' => $request->amount,
            'status' => $request->status,
            'image' => $request->image,
            'meta_tags' => $request->meta_tags,
            'meta_description' => $request->meta_description,
        ]);

        return redirect()->back()->with(['msg' => __('New Donation Added'),'type' => 'success']);
    }

    public function edit_donation($id){
        $all_languages = Language::all();
        $donation = Donation::find($id);
        return view('backend.donations.edit-donations')->with(['all_languages' => $all_languages,'donation' => $donation]);
    }

    public function update_donation(Request $request){
        $this->validate($request,[
            'title' => 'required|string',
            'slug' => 'nullable|string',
            'lang' => 'required|string',
            'donation_content' => 'required|string',
            'amount' => 'required|string',
            'status' => 'required|string',
            'image' => 'nullable|string',
            'meta_tags' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ]);

        Donation::find($request->donation_id)->update([
            'title' => $request->title,
            'slug' => !empty($request->slug) ? $request->slug : Str::slug($request->title),
            'lang' => $request->lang,
            'donation_content' => $request->donation_content,
            'amount' => $request->amount,
            'status' => $request->status,
            'image' => $request->image,
            'meta_tags' => $request->meta_tags,
            'meta_description' => $request->meta_description,
        ]);

        return redirect()->back()->with(['msg' => __('Donation Update...'),'type' => 'success']);
    }

    public function delete_donation(Request $request,$id){
        Donation::find($id)->delete();
        return redirect()->back()->with(['msg' => __('Donation Deleted...'),'type' => 'danger']);
    }

    public function clone_donation(Request $request){
        $donation_details = Donation::find($request->item_id);
        Donation::create([
            'title' => $donation_details->title,
            'slug' => !empty($donation_details->slug) ? $donation_details->slug : Str::slug($donation_details->title),
            'lang' => $donation_details->lang,
            'donation_content' => $donation_details->donation_content,
            'amount' => $donation_details->amount,
            'status' => 'draft',
            'image' => $donation_details->image,
            'meta_tags' => $donation_details->meta_tags,
            'meta_description' => $donation_details->meta_description,
        ]);

        return redirect()->back()->with(['msg' => __('Donation Cloned...'),'type' => 'success']);
    }

    public function page_settings(){
        $all_languages = Language::all();
        return view('backend.donations.donation-page-settings')->with(['all_languages' => $all_languages]);
    }

    public function update_page_settings(Request $request){
        $this->validate($request,[
            'donor_page_post_items' => 'nullable|string'
        ]);
        update_static_option('donor_page_post_items',$request->donor_page_post_items);

        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $this->validate($request,[
                'donation_button_'.$lang->slug.'_text' => 'nullable|string',
                'donation_goal_'.$lang->slug.'_text' => 'nullable|string',
                'donation_raised_'.$lang->slug.'_text' => 'nullable|string',
            ]);

            $donation_button = 'donation_button_'.$lang->slug.'_text';
            $donation_goal = 'donation_goal_'.$lang->slug.'_text';
            $donation_raised = 'donation_raised_'.$lang->slug.'_text';
            update_static_option($donation_button ,$request->$donation_button);
            update_static_option($donation_goal ,$request->$donation_goal);
            update_static_option($donation_raised ,$request->$donation_raised);
        }

        return redirect()->back()->with(['msg' => __('Settings Updated...'),'type' => 'success']);
    }

    public function single_page_settings(){
        $all_languages = Language::all();
        return view('backend.donations.donation-single-page-settings')->with(['all_languages' => $all_languages]);
    }

    public function update_single_page_settings(Request $request){
        $this->validate($request,[
           'donation_notify_mail' => 'required|email',
           'donation_custom_amount' => 'required|string',
           'donation_default_amount' => 'required|string'
        ]);
        update_static_option('donation_notify_mail',$request->donation_notify_mail);
        update_static_option('donation_custom_amount',$request->donation_custom_amount);
        update_static_option('donation_default_amount',$request->donation_default_amount);
        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $this->validate($request,[
                'donation_single_'.$lang->slug.'_form_title' => 'nullable|string',
                'donation_single_'.$lang->slug.'_form_button_text' => 'nullable|string',
                'donation_single_'.$lang->slug.'_recent_donation_text' => 'nullable|string',
            ]);
            $all_fields = [
                'donation_single_'.$lang->slug.'_form_title',
                'donation_single_'.$lang->slug.'_form_button_text',
                'donation_single_'.$lang->slug.'_recent_donation_text'
            ];
            foreach ($all_fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        return redirect()->back()->with(['msg' => __('Settings Updated...'),'type' => 'success']);
    }

    public function payment_success_page_settings(){
        $all_languages = Language::all();
        return view('backend.donations.donation-payment-success-page')->with(['all_languages' => $all_languages]);
    }

    public function update_payment_success_page_settings(Request $request){
        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $this->validate($request,[
                'donation_success_page_'.$lang->slug.'_title' => 'nullable|string',
                'donation_success_page_'.$lang->slug.'_subtitle' => 'nullable|string',
                'donation_success_page_'.$lang->slug.'_description' => 'nullable|string',
            ]);
            $all_fields = [
                'donation_success_page_'.$lang->slug.'_title',
                'donation_success_page_'.$lang->slug.'_subtitle',
                'donation_success_page_'.$lang->slug.'_description',
            ];
            foreach ($all_fields as $field){
                update_static_option($field,$request->$field);
            }
        }
        return redirect()->back()->with(['msg' => __('Settings Update Success'),'type' => 'success']);
    }

    public function payment_cancel_page_settings(){
        $all_languages = Language::all();
        return view('backend.donations.donation-payment-cancel-page')->with(['all_languages' => $all_languages]);
    }

    public function update_payment_cancel_page_settings(Request $request){
        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $this->validate($request,[
                'donation_cancel_page_'.$lang->slug.'_title' => 'nullable|string',
                'donation_cancel_page_'.$lang->slug.'_subtitle' => 'nullable|string',
                'donation_cancel_page_'.$lang->slug.'_description' => 'nullable|string',
            ]);
            $all_fields = [
                'donation_cancel_page_'.$lang->slug.'_title',
                'donation_cancel_page_'.$lang->slug.'_subtitle',
                'donation_cancel_page_'.$lang->slug.'_description',
            ];
            foreach ($all_fields as $field){
                update_static_option($field,$request->$field);
            }
        }
        return redirect()->back()->with(['msg' => __('Settings Update Success'),'type' => 'success']);
    }
    public function event_payment_logs(){
        $all_donation_logs = DonationLogs::all();
        return view('backend.donations.donation-payment-logs-all')->with(['all_donation_logs' => $all_donation_logs]);
    }

    public function delete_event_payment_logs(Request $request,$id){
        DonationLogs::find($id)->delete();
        return redirect()->back()->with(['msg' => __('Donation Payment Log Deleted..'),'type' => 'danger']);
    }

    public function approve_event_payment(Request $request,$id){

        $payment_logs = DonationLogs::find($id);
        $payment_logs->status = 'complete';
        $payment_logs->save();

        //update donation raised amount
        $event_details = Donation::find($payment_logs->donation_id);
        $event_details->raised = (int) $event_details->raised + (int) $payment_logs->amount;
        $event_details->save();

        $site_title = get_static_option('site_'.get_default_language().'_title');
        $customer_subject = __('Your donation payment success for').' '.$site_title;
        $admin_subject = __('You have a new donation payment from').' '.$site_title;
        $donation_notify_mail = get_static_option('donation_notify_mail');
        $admin_mail = !empty($donation_notify_mail) ? $donation_notify_mail : get_static_option('site_global_email');

        Mail::to($admin_mail)->send(new DonationMessage($payment_logs,$admin_subject,'owner'));
        Mail::to($payment_logs->email)->send(new DonationMessage($payment_logs,$customer_subject,'customer'));

        return redirect()->back()->with(['msg' => __('Manual Payment Accept Success'),'type' => 'success']);
    }

    public function bulk_action(Request $request){
        $all = Donation::find($request->ids);
        foreach($all as $item){
            $item->delete();
        }
        return response()->json(['status' => 'ok']);
    }

    public function donation_payment_logs_bulk_action(Request $request){
        $all = DonationLogs::find($request->ids);
        foreach($all as $item){
            $item->delete();
        }
        return response()->json(['status' => 'ok']);
    }

    public function donation_report(Request $request){
        $order_data = '';
        $query = DonationLogs::query();
        if (!empty($request->start_date)){
            $query->whereDate('created_at','>=',$request->start_date);
        }
        if (!empty($request->end_date)){
            $query->whereDate('created_at','<=',$request->end_date);
        }
        if (!empty($request->payment_status)){
            $query->where(['status' => $request->payment_status ]);
        }
        $error_msg = __('select start & end date to generate event payment report');
        if (!empty($request->start_date) && !empty($request->end_date)){
            $query->orderBy('id','DESC');
            $order_data =  $query->paginate($request->items);
            $error_msg = '';
        }

        return view('backend.donations.donation-report')->with([
            'order_data' => $order_data,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'items' => $request->items,
            'payment_status' => $request->payment_status,
            'error_msg' => $error_msg
        ]);
    }

    //
    public function donation_reminder(Request $request){
        $order_details = DonationLogs::find($request->id);
        $data['subject'] = __('your donation is still in pending at').' '. get_static_option('site_'.get_default_language().'_title');
        $data['message'] = __('hello').' '.$order_details->name .'<br>';
        $data['message'] .= __('your event booking').' #'.$order_details->id.' ';
        $data['message'] .= __('is still in pending, to complete your donation go to');
        $data['message'] .= ' <a href="'.route('user.home').'">'.__('your dashboard').'</a>';

        //send mail while order status change
        Mail::to($order_details->email)->send(new BasicMail($data));

        return redirect()->back()->with(['msg' => __('Reminder Mail Send Success'),'type' => 'success']);
    }
}
