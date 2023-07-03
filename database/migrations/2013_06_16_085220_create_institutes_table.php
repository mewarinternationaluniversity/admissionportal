<?php

use App\Enums\InstituteTypeEnum;
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
        Schema::create('institutes', function (Blueprint $table) {
            $table->id();
            $table->enum('type', [InstituteTypeEnum::DIPLOMA(), InstituteTypeEnum::BACHELORS()]);
            $table->string('title');
            $table->string('phone')->nullable();
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->string('letterhead')->nullable();
            $table->string('sliderone')->nullable();
            $table->string('slidertwo')->nullable();
            $table->string('sliderthree')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institutes');
    }
};
