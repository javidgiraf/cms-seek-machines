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
        Schema::create('machine_catalogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sell_machine_id')->default(0);
            $table->string('file_path');
            $table->string('file_type')->nullable();
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
        Schema::dropIfExists('machine_catalogs');
    }
};
