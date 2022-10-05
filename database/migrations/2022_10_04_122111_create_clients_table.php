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
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('firstName');
            $table->string('lastName');
            $table->integer('clientUserId')->unsigned();
            $table->string('email')->unique();
            $table->string('telephone');
            $table->string('telephoneBusiness');
            $table->string('personType');
            $table->integer('documentNumber')->unique();
            $table->string('corporateName');
            $table->string('CEP');
            $table->string('adress');
            $table->string('adressComplement');
            $table->string('district');
            $table->integer('cityId')->unsigned();
            $table->foreign('cityId')->references('id')->on('city');
            $table->integer('segmentId')->unsigned();
            $table->decimal('balance',8,2);
            $table->integer('integrantId')->unsigned();
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
        Schema::dropIfExists('clients');
    }
};
