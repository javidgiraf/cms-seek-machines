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
        Schema::create('sell_machine_agents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sell_machine_id');
            $table->integer('sales_percent')->default(0);
            $table->unsignedBigInteger('agent_id');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('agent_id')
                ->references('id')
                ->on('seek_agents')
                ->onDelete('cascade');

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
        Schema::dropIfExists('sell_machine_agents');
    }
};