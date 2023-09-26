<?php

namespace App\Models;

use App\Enums\SubjectTypeEnum;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'type',
        'title',
        'description'
    ];

    protected $casts = [
        'type' => SubjectTypeEnum::class
    ];

}