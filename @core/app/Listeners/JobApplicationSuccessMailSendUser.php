<?php

namespace App\Listeners;

use App\Events\JobApplication;
use App\JobApplicant;
use App\Jobs;
use App\Mail\BasicMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class JobApplicationSuccessMailSendUser
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

        //send mail to user
        $applicant_message = '<p>'.__('Hello').', '.$job_applicant_details->name.'<br> '.__('You job application submitted successfully.');
        $applicant_message .= ' #'.$job_applicant_details->id;
        $applicant_message .= ' '.__('Applied to job post').' "'.$jobs_details->title.'"';
        $applicant_message .= ' '.__('applied at').' '.date_format($job_applicant_details->created_at,'d M y h:i:s') ;
        //check for payment details
        if (!empty($jobs_details->application_fee_status) && $jobs_details->application_fee > 0){
            $applicant_message .= ' '.__('paid via').' '.str_replace('_',' ',$job_applicant_details->payment_gateway);
            $applicant_message .= ' '.__('Transaction Id').' '.$job_applicant_details->transaction_id;
        }
        $applicant_message .='</p>';
        //send mail to applicant
        Mail::to($job_applicant_details->email)->send(new BasicMail([
            'subject' => __('Your job application submitted successfully'),
            'message' => $applicant_message,
        ]));
    }
}
