<?php

namespace App\Listeners;

use App\Events\JobApplication;
use App\JobApplicant;
use App\Jobs;
use App\Mail\BasicMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class JobApplicationSuccessMailSendAdmin
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
     * @param  JobApplication  $event
     * @return void
     */
    public function handle(JobApplication $event)
    {

        $data = $event->data;
        if (!isset($data['transaction_id']) && !isset($data['job_application_id'])){return;}

        $job_applicant_details = JobApplicant::where('id',$data['job_application_id'])->first();

        $jobs_details = Jobs::where('id',$job_applicant_details->jobs_id)->first();
        $receiver_mail_address = get_static_option('job_single_page_applicant_mail') ?? get_static_option('site_global_email');
        //send mail to admin
        $admin_message = '<p>'.__('Hello').',<br> '.__('You have a new job applicant');
        $admin_message .= ' #'.$job_applicant_details->id.' '.__('Name').' '.$job_applicant_details->name;
        $admin_message .= ' '.__('Applied to job post').' "'.$jobs_details->title.'"';
        $admin_message .= ' '.__('applied at').' '.date_format($job_applicant_details->created_at,'d M y h:i:s') ;

        //check for payment details
        if (!empty($jobs_details->application_fee_status) && $jobs_details->application_fee > 0){
            $admin_message .= ' '.__('paid via').' '.str_replace('_',' ',$job_applicant_details->payment_gateway);
            $admin_message .= ' '.__('Transaction Id').' '.$job_applicant_details->transaction_id;
        }

        $admin_message .= ' '.__('check admin panel for more info.') ;
        $admin_message .='</p>';


        Mail::to($receiver_mail_address)->send(new BasicMail([
            'subject' => __('You Have A New Job Applicant'),
            'message' => $admin_message,
        ]));

    }
}
