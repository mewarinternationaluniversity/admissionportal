<?php

namespace App\Models;

use App\Enums\CourseTypeEnum;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'type',
        'title',
        'fees',
        'description'
    ];

    protected $casts = [
        'type' => CourseTypeEnum::class
    ];


    public function institutes()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany( Institute::class, 'institutes_courses', 'course_id', 'institute_id')->withPivot('seats', 'fees');
    }

    public function mappings()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(Course::class, 'courses_courses', 'one_id', 'two_id');
    }
}
