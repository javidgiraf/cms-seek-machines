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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('type', ['subscription', 'ads', 'verified']);
            $table->string('payment_method')->nullable();
            $table->decimal('total_amount', 24, 2)->default(0);
            $table->string('currency')->nullable();
            $table->date('paid_on')->nullable();
            $table->string('reference_id')->nullable();
            $table->string('payment_status')->default('pending'); //pending, cancelled, failed, complete
            $table->text('note')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
        // for ads
        Schema::create('transaction_ads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('ad_id');

            $table->foreign('transaction_id')
                ->references('id')
                ->on('transactions')
                ->onDelete('cascade');

            $table->foreign('ad_id')
                ->references('id')
                ->on('boost_ads')
                ->onDelete('cascade');
        });
        // for subscription
        Schema::create('transaction_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('subscription_id');

            $table->foreign('transaction_id')
                ->references('id')
                ->on('transactions')
                ->onDelete('cascade');

            $table->foreign('subscription_id')
                ->references('id')
                ->on('subscriptions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('transaction_ads');
        Schema::dropIfExists('transaction_subscriptions');
    }
};
