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
        Schema::create('sell_machines', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->longText('description');
            $table->string('item_code')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->string('default_image');
            $table->integer('brand_id')->default(0);
            $table->integer('country_id')->default(0)->nullable();
            $table->tinyInteger('is_capital')->default(0);
            $table->decimal('expected_price', 24, 2)->default(0);
            $table->integer('yearof')->nullable();
            $table->string('modelno')->nullable();
            $table->string('usage')->nullable();
            $table->text('location')->nullable();
            $table->tinyInteger('isverified')->default(0);
            $table->date('verify_submitted_on')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
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
        Schema::dropIfExists('sell_machines');
    }
};
