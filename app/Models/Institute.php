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
        'sliders',
        'description'
    ];

    protected $casts = [
        'type' => InstituteTypeEnum::class,
        'sliders' => 'array'
    ];
}
