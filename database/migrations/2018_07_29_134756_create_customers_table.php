<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->char('regno', 100)->nullable();
            $table->char('fname', 100);
            $table->char('lname', 100);
            $table->char('gender', 100);
            $table->date('dob')->nullable();
            $table->bigInteger('mobileno');
            $table->char('email', 100)->nullable();
            $table->char('photo', 200)->nullable();
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
        Schema::dropIfExists('customers');
    }
}
