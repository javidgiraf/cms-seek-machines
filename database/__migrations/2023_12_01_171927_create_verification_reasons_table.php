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
        Schema::create('verification_reasons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sell_machine_id');
            $table->longText('description')->nullable();
            $table->string('inspection_file')->nullable();
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
        Schema::dropIfExists('verification_reasons');
    }
};
