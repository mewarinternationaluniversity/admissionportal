<?php

namespace App\Models;

use App\Enums\PaymentGatewayEnum;
use Illuminate\Database\Eloquent\Model;

class Feepayment extends Model
{
    protected $fillable = [
        'fee_id',
        'session_id',
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
        'paymentgateway' => PaymentGatewayEnum::class
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }
    
    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
