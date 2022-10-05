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
        
        Schema::table('leads_health_ensurance', function (Blueprint $table) {
            $table->foreign('qualityId')->references('id')->on('quality');
            $table->foreign('integrantId')->references('id')->on('integrant');
            $table->foreign('segmentId')->references('id')->on('segment');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
