<?php

namespace App\Http\Controllers;

use App\Helpers\LanguageHelper;
use App\Helpers\NexelitHelpers;
use App\Language;
use App\Mail\BasicMail;
use App\Mail\OrderReply;
use App\Mail\PaymentSuccess;
use App\Mail\PlaceOrder;
use App\Mail\QuoteReply;
use App\Order;
use App\PaymentLogs;
use App\PricePlan;
use App\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderManageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function all_orders(){
        $all_orders = Order::all();
        return view('backend.package-order-manage.order-manage-all')->with(['all_orders' => $all_orders]);
    }

    public function pending_orders(){
        $all_orders = Order::where('status','pending')->get();
        return view('backend.package-order-manage.order-manage-pending')->with(['all_orders' => $all_orders]);
    }

    public function completed_orders(){
        $all_orders = Order::where('status','completed')->get();
        return view('backend.package-order-manage.order-manage-completed')->with(['all_orders' => $all_orders]);
    }
    public function in_progress_orders(){
        $all_orders = Order::where('status','in_progress')->get();
        return view('backend.package-order-manage.order-manage-in-progress')->with(['all_orders' => $all_orders]);
    }

    public function change_status(Request $request){
        $this->validate($request,[
            'order_status' => 'required|string|max:191',
            'order_id' => 'required|string|max:191'
        ]);

        $order_details = Order::find($request->order_id);
        $order_details->status = $request->order_status;
        $order_details->save();
        $payment_log = PaymentLogs::where('order_id',$order_details->id)->first();

        if(!empty($payment_log)){
            $data['subject'] = __('your order status has been changed');
            $data['message'] = __('hello').' '.$payment_log->name .'<br>';
            $data['message'] .= __('your order').' #'.$order_details->id.' ';
            $data['message'] .= __('status has been changed to').' '.str_replace('_',' ',$request->order_status).'.';

            //send mail while order status change
            Mail::to($payment_log->email)->send(new BasicMail($data));
        }

        return redirect()->back()->with(['msg' => __('Order Status Update Success...'),'type' => 'success']);
    }
    public function order_reminder(Request $request){
        $order_details = Order::find($request->id);
        $payment_log = PaymentLogs::where('order_id',$order_details->id)->first();

        //send order reminder mail
        $data['subject'] = __('your order is still in pending at').' '. get_static_option('site_'.get_default_language().'_title');
        $data['message'] = __('hello').' '.$payment_log->name .'<br>';
        $data['message'] .= __('your order').' #'.$order_details->id.' ';
        $data['message'] .= __('is still in pending, to complete your order go to');
        $data['message'] .= ' <a href="'.route('user.home').'">'.__('your dashboard').'</a>';

        //send mail while order status change
        Mail::to($payment_log->email)->send(new BasicMail($data));

        return redirect()->back()->with(['msg' => __('Order Reminder Mail Send Success...'),'type' => 'success']);
    }
    public function order_delete(Request $request,$id){
        Order::find($id)->delete();
        return redirect()->back()->with(['msg' => __('Order Deleted Success...'),'type' => 'danger']);
    }


    public function send_mail(Request $request){
        $this->validate($request,[
            'email' => 'required|string|max:191',
            'name' => 'required|string|max:191',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);
        $subject = str_replace('{site}',get_static_option('site_'.get_default_language().'_title'),$request->subject);
        $data = [
            'name' => $request->name,
            'message' => $request->message,
        ];
        Mail::to($request->email)->send(new OrderReply($data,$subject));
        return redirect()->back()->with(['msg' => __('Order Reply Mail Send Success...'),'type' => 'success']);
    }

    public function all_payment_logs(){
        $paymeng_logs = PaymentLogs::all();
        return view('backend.payment-logs.payment-logs-all')->with(['payment_logs' => $paymeng_logs]);
    }

    public function payment_logs_delete(Request $request,$id){
        PaymentLogs::find($id)->delete();
        return redirect()->back()->with(['msg' => __('Payment Log Delete Success...'),'type' => 'danger']);
    }

    public function payment_logs_approve(Request $request,$id){
        $payment_logs = PaymentLogs::find($id);
        $payment_logs->status = 'complete';
        $payment_logs->save();

        Order::where('id',$payment_logs->order_id)->update(['payment_status' => 'complete']);

        $order_details = Order::find($payment_logs->order_id);
        $package_details = PricePlan::where('id',$order_details->package_id)->first();
        $payment_details = PaymentLogs::where('order_id',$payment_logs->order_id)->first();
        $all_fields = unserialize($order_details->custom_fields,['class' => false]);
        unset($all_fields['package']);

        $all_attachment = unserialize($order_details->attachment,['class' => false]);
        $order_page_form_mail =  get_static_option('order_page_form_mail');
        $order_mail = $order_page_form_mail ? $order_page_form_mail : get_static_option('site_global_email');

        $subject = __('your order has been placed');
        $message = __('your order has been placed.').' #'.$payment_logs->order_id;
        $message .= ' '.__('at').' '.date_format($order_details->created_at,'d F Y H:m:s');
        $message .= ' '.__('via').' '.str_replace('_',' ',$payment_details->package_gateway);
        Mail::to($payment_details->email)->send(new PlaceOrder([
            'data' => $order_details,
            'subject' => $subject,
            'message' => $message,
            'package' => $package_details,
            'attachment_list' => $all_attachment,
            'payment_log' => $payment_details
        ]));

        return redirect()->back()->with(['msg' => __('Manual Payment Accept Success'),'type' => 'success']);
    }

    public function order_success_payment(){
        $all_languages = Language::all();
        return view('backend.package-order-manage.order-success-page')->with(['all_languages' => $all_languages]);
    }

    public function update_order_success_payment(Request $request){

        $all_language = Language::all();
        foreach ($all_language as $lang) {
            $this->validate($request, [
                'site_order_success_page_' . $lang->slug . '_title' => 'nullable',
                'site_order_success_page_' . $lang->slug . '_description' => 'nullable',
            ]);
            $title = 'site_order_success_page_' . $lang->slug . '_title';
            $description = 'site_order_success_page_' . $lang->slug . '_description';

            update_static_option($title, $request->$title);
            update_static_option($description, $request->$description);
        }
        return redirect()->back()->with(['msg' => __('Order Success Page Update Success...'),'type' => 'success']);
    }

    public function order_cancel_payment(){
        $all_languages = Language::all();
        return view('backend.package-order-manage.order-cancel-page')->with(['all_languages' => $all_languages]);
    }

    public function update_order_cancel_payment(Request $request){

        $all_language = Language::all();
        foreach ($all_language as $lang) {
            $this->validate($request, [
                'site_order_cancel_page_' . $lang->slug . '_title' => 'nullable',
                'site_order_cancel_page_' . $lang->slug . '_subtitle' => 'nullable',
                'site_order_cancel_page_' . $lang->slug . '_description' => 'nullable',
            ]);
            $title = 'site_order_cancel_page_' . $lang->slug . '_title';
            $subtitle = 'site_order_cancel_page_' . $lang->slug . '_subtitle';
            $description = 'site_order_cancel_page_' . $lang->slug . '_description';

            update_static_option($title, $request->$title);
            update_static_option($subtitle, $request->$subtitle);
            update_static_option($description, $request->$description);
        }
        return redirect()->back()->with(['msg' => __('Order Cancel Page Update Success...'),'type' => 'success']);
    }

    public function bulk_action(Request $request){
        $all = Order::find($request->ids);
        foreach($all as $item){
            $item->delete();
        }
        return response()->json(['status' => 'ok']);
    }

    public function payment_log_bulk_action(Request $request){
        $all = PaymentLogs::find($request->ids);
        foreach($all as $item){
            $item->delete();
        }
        return response()->json(['status' => 'ok']);
    }

    public function order_report(Request  $request){

        $order_data = '';
        $query = Order::query();
        if (!empty($request->start_date)){
            $query->whereDate('created_at','>=',$request->start_date);
        }
        if (!empty($request->end_date)){
            $query->whereDate('created_at','<=',$request->end_date);
        }
        if (!empty($request->order_status)){
            $query->where(['status' => $request->order_status ]);
        }
        if (!empty($request->payment_status)){
            $query->where(['payment_status' => $request->payment_status ]);
        }
        $error_msg = __('select start & end date to generate order report');
        if (!empty($request->start_date) && !empty($request->end_date)){
            $query->orderBy('id','DESC');
            $order_data =  $query->paginate($request->items);
            $error_msg = '';
        }

        return view('backend.package-order-manage.order-report')->with([
            'order_data' => $order_data,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'items' => $request->items,
            'order_status' => $request->order_status,
            'payment_status' => $request->payment_status,
            'error_msg' => $error_msg
        ]);
    }

    public function payment_report(Request  $request){

        $order_data = '';
        $query = PaymentLogs::query();
        if (!empty($request->start_date)){
            $query->whereDate('created_at','>=',$request->start_date);
        }
        if (!empty($request->end_date)){
            $query->whereDate('created_at','<=',$request->end_date);
        }
        if (!empty($request->payment_status)){
            $query->where(['status' => $request->payment_status ]);
        }
        $error_msg = __('select start & end date to generate payment report');
        if (!empty($request->start_date) && !empty($request->end_date)){
            $query->orderBy('id','DESC');
            $order_data =  $query->paginate($request->items);
            $error_msg = '';
        }

        return view('backend.payment-logs.payment-report')->with([
            'order_data' => $order_data,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'items' => $request->items,
            'payment_status' => $request->payment_status,
            'error_msg' => $error_msg
        ]);
    }

    public function settings(){
        return view('backend.package-order-manage.settings')->with(['all_languages' => LanguageHelper::all_languages()]);
    }
    public function update_settings(Request $request){
        $this->validate($request,[
           'disable_guest_mode_for_package_module' => 'nullable|string'
        ]);
        $fields_list = [
            'disable_guest_mode_for_package_module'
        ];
        foreach ($fields_list as $field){
            update_static_option($field,$request->$field);
        }

        return back()->with(NexelitHelpers::settings_update());
    }

}
