<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses_courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('one_id');
            $table->foreign('one_id')->references('id')->on('courses')->onDelete('cascade');
            $table->unsignedBigInteger('two_id');
            $table->foreign('two_id')->references('id')->on('courses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses_courses');
    }
};
