<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\ApplicationStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Application extends Model
{
    protected $fillable = [
        'course_id',
        'session_id',
        'institute_id',
        'student_id',
        'status',
        'letter',
        'paid_on',
        'payref',
        'approved_on'
    ];

    protected $casts = [
        'created_at'  => 'date:Y-m-d H:i A',
        'status' => ApplicationStatusEnum::class
    ];
    
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function institute()
    {
        return $this->belongsTo(Institute::class, 'institute_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
