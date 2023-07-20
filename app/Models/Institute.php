<?php

namespace App\Models;

use App\Enums\InstituteTypeEnum;
use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    protected $fillable = [
        'type',
        'title',
        'logo',
        'phone',
        'banner',
        'officername',
        'officeremail',
        'seal',
        'signature',
        'letterhead',
        'sliderone',
        'slidertwo',
        'sliderthree',
        'description',
    ];

    protected $casts = [
        'type' => InstituteTypeEnum::class
    ];

    public function courses()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(Course::class, 'institutes_courses', 'institute_id', 'course_id')->withPivot('seats', 'fees', 'session_id');
    }
}
