<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('admin_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained();
            $table->string('action_type');
            $table->string('module');
            $table->json('action_details');
            $table->string('ip_address');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_logs');
    }
}; 