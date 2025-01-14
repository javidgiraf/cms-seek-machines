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
            $table->string('meta_title')->nullable()->after('location');
            $table->longtext('keywords')->nullable()->after('meta_title');
            $table->longtext('meta_descriptions')->nullable()->after('keywords');
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
