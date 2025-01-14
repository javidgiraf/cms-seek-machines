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
        Schema::create('machine_specifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sell_machine_id');
            $table->string('spec_title');
            $table->string('spec_value');
            $table->tinyInteger('priority')->nullable()->default(0);
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
        Schema::dropIfExists('machine_specifications');
    }
};
