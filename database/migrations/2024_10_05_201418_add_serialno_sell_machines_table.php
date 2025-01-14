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
        Schema::table('sell_machines', function (Blueprint $table) {
            //
            $table->string('serialno')->nullable()->after('modelno');
            $table->softDeletes();

            $table->index(['item_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sell_machines', function (Blueprint $table) {
            //
        });
    }
};
