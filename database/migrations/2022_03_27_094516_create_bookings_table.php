<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('car_id');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->decimal('price', 7, 2);
            $table->tinyInteger('has_child_seat');
            $table->decimal('child_weight', 4, 2)->nullable();
            $table->string('cancel_token');
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
