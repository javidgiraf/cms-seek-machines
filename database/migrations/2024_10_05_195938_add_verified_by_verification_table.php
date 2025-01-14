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
        Schema::table('verification_reasons', function (Blueprint $table) {
            $table->unsignedBigInteger('agent_id')->default(0)->after('inspection_file');

            $table->foreign('agent_id')
                ->references('id')
                ->on('seek_agents')
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
        Schema::table('verification_reasons', function (Blueprint $table) {
            //
        });
    }
};
