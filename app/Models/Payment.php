<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'application_id',
        'reference',
        'student_id',
        'paymentgateway',
        'amount',
        'email',
        'orderID',
        'currency'
    ];
    
    protected $casts = [
        'created_at'  => 'date:Y-m-d H:i A',
        'paymentgateway' => ApplicationStatusEnum::class
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
