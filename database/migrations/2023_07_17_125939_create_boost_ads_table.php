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
        Schema::create('boost_ads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sell_machine_id')->default(0);
            $table->integer('days');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('total_amount', 24, 2)->default(0);
            $table->string('ad_type')->nullable(); // banner, featured, 
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('sell_machine_id')
                ->references('id')
                ->on('sell_machines')
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
        Schema::dropIfExists('boost_ads');
    }
};
