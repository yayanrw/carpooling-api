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
        Schema::create('t_vehicle_booking', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('user_request_id');
            $table->dateTime('estimation_start_date', $precision = 0);
            $table->dateTime('actual_start_date', $precision = 0)->nullable();
            $table->dateTime('estimation_completion_date', $precision = 0);
            $table->dateTime('actual_completion_date', $precision = 0)->nullable();
            $table->string('neccesary');
            $table->string('status')->default('REQUESTED');
            $table->timestamps();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
        });

        Schema::table('t_vehicle_booking', function ($table) {
            $table->foreign('vehicle_id')->references('id')->on('m_vehicle')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_request_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_vehicle_booking');
    }
};
