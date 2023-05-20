<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_approval_request', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_booking_id');
            $table->unsignedBigInteger('approval_user_id');
            $table->tinyInteger('approval_order');
            $table->string('note')->nullable();
            $table->boolean('is_approved')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->timestamps();
            $table->unique(['vehicle_booking_id', 'approval_order']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_approval_request');
    }
};
