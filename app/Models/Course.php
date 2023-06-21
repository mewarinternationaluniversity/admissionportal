<?php

namespace App\Models;

use App\Enums\CourseTypeEnum;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'type',
        'title',
        'description'
    ];

    protected $casts = [
        'type' => CourseTypeEnum::class
    ];
}
