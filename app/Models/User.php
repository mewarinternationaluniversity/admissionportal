<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'dob',
        'yearofgraduation',
        'gender',
        'institute_id',
        'matriculation_no',
        'address',
        'phone',
        'nd_institute',
        'nd_course',
        'avatar',
        'idproof',
        'ndtranscript',
        'ndgraduationcert',
        'otheruploads'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }

    public function ndinstitute()
    {
        return $this->belongsTo(Institute::class, 'nd_institute');
    }

    public function ndcourse()
    {
        return $this->belongsTo(Course::class, 'nd_course');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'student_id');
    }
}
