<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\PaymentGatewayEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('feepayments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_id')->nullable();
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->enum('paymentgateway', [                
                PaymentGatewayEnum::PAYSTACK(),
                PaymentGatewayEnum::STRIPE()
            ])->default(PaymentGatewayEnum::PAYSTACK());
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');            
            $table->unsignedBigInteger('fee_id');
            $table->foreign('fee_id')->references('id')->on('fees')->onDelete('cascade');
            $table->string('reference');
            $table->string('amount');
            $table->string('email')->nullable();
            $table->string('orderID')->nullable();
            $table->string('currency')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feepayments');
    }
};
