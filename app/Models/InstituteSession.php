<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstituteSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'institute_id'
    ];

    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }
}
