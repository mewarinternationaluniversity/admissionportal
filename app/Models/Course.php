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

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function institutes()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany( Institute::class, 'institutes_courses', 'course_id', 'institute_id')->withPivot('seats', 'fees', 'session_id');
    }

    public function mappings()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(Course::class, 'courses_courses', 'two_id', 'one_id');
    }
}
