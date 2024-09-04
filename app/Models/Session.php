<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status'
    ];
    
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function institutesession()
    {
        return $this->hasOne(InstituteSession::class);
    }
    
}
