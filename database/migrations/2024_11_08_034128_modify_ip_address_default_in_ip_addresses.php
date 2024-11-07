<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('ip_addresses', function (Blueprint $table) {
            $table->string('ipAddress')->default(null)->change();
        });
    }

    public function down()
    {
        Schema::table('ip_addresses', function (Blueprint $table) {
            $table->string('ipAddress')->default('127.0.0.1')->change();
        });
    }
};
