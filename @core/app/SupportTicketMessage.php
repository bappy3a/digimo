<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportTicketMessage extends Model
{
    protected $table = 'support_ticket_messages';
    protected $fillable = ['message','notify','attachment','support_ticket_id','type'];
}
