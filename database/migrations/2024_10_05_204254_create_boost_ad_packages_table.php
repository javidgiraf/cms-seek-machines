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
        Schema::create('boost_ad_packages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->decimal('pricing', 24, 2)->default(0);
            $table->integer('no_of_days')->default(0);
            $table->integer('discount')->default(0)->nullable();
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
        Schema::dropIfExists('boost_ad_packages');
    }
};
