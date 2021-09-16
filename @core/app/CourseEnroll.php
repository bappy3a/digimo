<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseEnroll extends Model
{
    protected $table = 'course_enrolls';
    protected $fillable = ['total','name','email','user_id','payment_gateway','payment_track','transaction_id','payment_status','status','course_id','coupon','coupon_discounted'];

    public function course(){
        return $this->belongsTo(Course::class,'course_id');
    }
}
