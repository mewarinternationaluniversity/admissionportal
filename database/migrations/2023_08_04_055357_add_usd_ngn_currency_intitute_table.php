<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('institutes', function (Blueprint $table) {
            $table->string('usdappamount')->nullable()->after('logo');
            $table->string('ngnappamount')->nullable()->after('usdappamount');
        });
    }

    public function down(): void
    {
        Schema::table('institutes', function (Blueprint $table) {
            $table->dropColumn(['usdappamount', 'ngnappamount']);
        });
    }
};
