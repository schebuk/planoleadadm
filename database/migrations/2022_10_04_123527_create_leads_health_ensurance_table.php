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
        Schema::create('leads_health_ensurance', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->integer('telephone');
            $table->integer('cityId')->unsigned();
            $table->foreign('cityId')->references('id')->on('city');
            $table->integer('adId')->unsigned();
            $table->foreign('adId')->references('id')->on('ads');
            $table->string('negReason');
            $table->string('devReason');
            $table->dateTime('negDate');
            $table->dateTime('devDate');
            $table->string('category');
            $table->decimal('price',8,2);
            $table->integer('clientId')->unsigned();
            $table->foreign('clientId')->references('id')->on('clients');
            $table->integer('qualityId')->unsigned();
            $table->integer('integrantId')->unsigned();
            $table->longText('note');
            $table->integer('font');
            $table->integer('segmentId')->unsigned();
            $table->string('segmentCNPJType');
            $table->string('segmentPersonType');
            $table->string('segmentOperator');
            $table->string('segmentLives');
            $table->dateTime('exibitionDate');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads_health_ensurance');
    }
};
