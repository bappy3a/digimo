<?php

namespace App\Listeners;

use App\DonationLogs;
use App\Events\DonationSuccess;
use App\Mail\DonationMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class DonationSuccessMailSend
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  DonationSuccess  $event
     * @return void
     */
    public function handle(DonationSuccess $event)
    {
        if (empty($event->data) && !isset($event->data['transaction_id']) && !isset($event->data['donation_log_id'])){return;}

        $donation_details = DonationLogs::findOrfail($event->data['donation_log_id']);

        $site_title = get_static_option('site_'.get_default_language().'_title');

        $customer_subject = __('Your donation payment success for').' '.$site_title;
        $admin_subject = __('You have a new donation payment from').' '.$site_title;

        $donation_notify_mail = get_static_option('donation_notify_mail');

        $admin_mail =  $donation_notify_mail ?? get_static_option('site_global_email');

        Mail::to($admin_mail)->send(new DonationMessage($donation_details,$admin_subject,'owner'));
        Mail::to($donation_details->email)->send(new DonationMessage($donation_details,$customer_subject,'customer'));
    }
}
