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
        Schema::rename('leads_health_ensurance', 'leads');
        
        Schema::table('leads', function (Blueprint $table) {
            $table->boolean('status')->default(0)->change();
            $table->boolean('trash')->default(0);
            $table->boolean('delete')->default(0);   
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
