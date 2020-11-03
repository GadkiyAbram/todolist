<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');       //increments
            $table->string('name');
            $table->text('description');
            $table->date('due_date');
            $table->string('priority')->default('Low');
            $table->string('status')->default('on start');
            $table->unsignedBigInteger('created_by')->default(1);   //unsignedBigInteger
            $table->unsignedBigInteger('assigned_to')->default(1);  //unsignedBigInteger
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('assigned_to')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
