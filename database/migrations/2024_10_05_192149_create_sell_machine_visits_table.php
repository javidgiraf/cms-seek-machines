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
        Schema::create('sell_machine_visits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sell_machine_id');
            $table->datetime('visit_at');
            $table->string('ip_address')->nullable();
            $table->string('country')->nullable();
            $table->text('user_agent')->nullable();
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
        Schema::dropIfExists('sell_machine_visits');
    }
};
