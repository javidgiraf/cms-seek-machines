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
        Schema::create('membership_plans', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->decimal('pricing', 24, 2)->default(0);
            $table->integer('no_of_month')->default(0);
            $table->integer('discount')->default(0)->nullable();
            $table->integer('view_limit')->default(0);
            $table->tinyInteger('is_premium')->default(0);
            $table->decimal('min_premium_amount', 24, 2)->default(0);
            $table->decimal('max_premium_amount', 24, 2)->default(0);
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('membership_plans');
    }
};
