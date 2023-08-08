<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $fillable = [
        'course_id',
        'session_id',
        'institute_id',
        'application_id',
        'student_id'
    ];

    protected $casts = [
        'created_at'  => 'date:Y-m-d H:i A'
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

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function payments()
    {
        return $this->hasMany(Feepayment::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
