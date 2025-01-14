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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('boost_ad_id')->default(0)->nullable();
            $table->string('title');
            $table->longText('description');
            $table->string('label')->nullable();
            $table->string('image_url')->nullable();
            $table->string('link_to')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('boost_ad_id')
                ->references('id')
                ->on('boost_ads')
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
        Schema::dropIfExists('banners');
    }
};
