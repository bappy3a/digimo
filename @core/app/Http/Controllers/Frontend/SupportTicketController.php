<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\NexelitHelpers;
use App\Http\Controllers\Controller;
use App\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportTicketController extends Controller
{
    const BASE_PATH = 'frontend.pages.support-ticket.';

    public function page(){
        return view(self::BASE_PATH.'support-ticket');
    }

    public function store(Request $request){
        $this->validate($request,[
           'title' => 'required|string|max:191',
           'subject' => 'required|string|max:191',
           'priority' => 'required|string|max:191',
           'description' => 'required|string',
        ],[
            'title.required' => __('title required'),
            'subject.required' =>  __('subject required'),
            'priority.required' =>  __('priority required'),
            'description.required' => __('description required'),
        ]);

        SupportTicket::create([
            'title' => $request->title,
            'via' => $request->via,
            'operating_system' => null,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'description' => $request->description,
            'subject' => $request->subject,
            'status' => 'open',
            'priority' => $request->priority,
            'user_id' => Auth::guard('web')->user()->id,
            'admin_id' => null
        ]);
        $msg = get_static_option('support_ticket_'.get_user_lang().'_success_message') ?? __('thanks for contact us, we will reply soon');
        return back()->with(NexelitHelpers::settings_update($msg));
    }
}
