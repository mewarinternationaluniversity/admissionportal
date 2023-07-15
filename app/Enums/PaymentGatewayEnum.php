<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self PAYSTACK()
 * @method static self STRIPE()
 */

 final class PaymentGatewayEnum extends Enum {}