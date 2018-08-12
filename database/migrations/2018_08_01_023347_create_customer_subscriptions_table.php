<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subscription_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->float('amount');
            $table->float('balance');
            $table->date('doj');
            $table->foreign('customer_id', 'foreign_customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');
            $table->foreign('subscription_id', 'foreign_subscription_id')
                ->references('id')
                ->on('subscriptions')
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
        Schema::dropIfExists('customer_subscriptions');
    }
}
