<?php

namespace App\Listeners;

use App\EventAttendance;
use App\EventPaymentLogs;
use App\Events;
use App\Events\AttendanceBooking;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class AttendanceBookingSuccessMailSendUser
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
     * @param  AttendanceBooking  $event
     * @return void
     */
    public function handle(AttendanceBooking $event)
    {
        $data = $event->data;
        if (!isset($data['attendance_id']) && !isset($data['transaction_id'])){return;}

        $event_attendance = EventAttendance::find($data['attendance_id']);
        $event_details = Events::find($event_attendance->event_id);
        $event_payment_logs = EventPaymentLogs::where('attendance_id',$event_attendance->id)->first();

        //send mail to user
        $subject = __('your event booking order has been placed');
        $message = __('your event booking order has been placed. attendance Id').' #'.$event_attendance->id;
        $message .= ' '.__('at').' '.date_format($event_attendance->created_at,'d F Y H:m:s');
        $message .= ' '.__('via').' '.str_replace('_',' ',$event_payment_logs->package_gateway);
        Mail::to($event_payment_logs->email)->send(new \App\Mail\EventAttendance([
            'subject' => $subject,
            'message' => $message,
            'event_attendance' => $event_attendance,
            'event_details' => $event_details,
            'event_payment_logs' => $event_payment_logs,
        ]));
    }
}
