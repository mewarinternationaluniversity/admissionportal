<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\ApplicationStatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_id')->nullable();
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->enum('status', [                
                ApplicationStatusEnum::SUBMITTED(),
                ApplicationStatusEnum::PROCESSING(),
                ApplicationStatusEnum::APPROVED(),
                ApplicationStatusEnum::ACCEPTED(),
                ApplicationStatusEnum::REJECTED()
            ])->default(ApplicationStatusEnum::SUBMITTED());            
            $table->unsignedBigInteger('institute_id');
            $table->foreign('institute_id')->references('id')->on('institutes')->onDelete('cascade');
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('letter')->nullable();
            $table->timestamp('paid_on')->nullable();
            $table->string('payref')->nullable();            
            $table->timestamp('approved_on')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
