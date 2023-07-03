<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\ApplicationStatusEnum;

class Application extends Model
{
    protected $fillable = [
        'course_id',
        'institute_id',
        'student_id',
        'status',
        'letter',
        'paid_on',
        'approved_on'
    ];

    protected $casts = [
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
}
