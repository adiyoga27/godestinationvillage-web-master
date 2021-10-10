<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('category_events'); 
            $table->string('name', 100);
            $table->text('description');
            $table->double('price');
            $table->double('disc');
            $table->text('location');
            $table->dateTime('date_event');
            $table->string('duration')->nullable();
            $table->text('interary')->nullable();
            $table->text('inclusion')->nullable();
            $table->text('additional')->nullable();
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
        Schema::dropIfExists('events');
    }
}
