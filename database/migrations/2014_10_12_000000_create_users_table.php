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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');            
            $table->string('email')->unique();
            $table->string('matriculation_no')->nullable()->unique();
            $table->integer('institute_id')->unsigned()->references('id')->on('institutes')->nullable()->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('dob')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('nd_institute')->nullable();
            $table->string('nd_course')->nullable();
            $table->string('avatar')->nullable();
            $table->string('idproof')->nullable();
            $table->string('ndtranscript')->nullable();
            $table->string('ndgraduationcert')->nullable();
            $table->string('otheruploads')->nullable();            
            $table->rememberToken();
            $table->timestamps();            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
