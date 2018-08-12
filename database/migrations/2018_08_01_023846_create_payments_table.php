<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->integer('customer_subscription_id')->unsigned();
            $table->float('amount');
            $table->date('paid_at');
            $table->foreign('customer_subscription_id', 'foreign_customer_subscription_id')
                ->references('id')
                ->on('customer_subscriptions')
                ->onDelete('cascade');
            $table->foreign('customer_id', 'foreign_customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');
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
        Schema::dropIfExists('payments');
    }
}
