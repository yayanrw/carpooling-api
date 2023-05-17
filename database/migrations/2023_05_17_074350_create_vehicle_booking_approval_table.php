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
        Schema::create('t_vehicle_booking_approval', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('approval_order');
            $table->unsignedBigInteger('approval_user_id');
            $table->string('note')->nullable();
            $table->boolean('is_approved')->nullable();
            $table->timestamps();
            $table->dateTime('approved_at')->nullable();
            $table->unsignedBigInteger('created_by');
        });

        Schema::table('t_vehicle_booking_approval', function ($table) {
            $table->foreign('vehicle_id')->references('id')->on('m_vehicle')->onDelete('cascade');
            $table->foreign('approval_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_vehicle_booking_approval');
    }
};
