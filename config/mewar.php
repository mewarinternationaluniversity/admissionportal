<?php

return [

    'payment_gateway'   => env('APPLICATIONGATEWAY', 'stripe'), //Either stripe or paystack
    'usd_fee'           => env('APPLICATION_FEE_USD', 100),
    'ngn_fee'           => env('APPLICATION_FEE_NGN', 780),

];
