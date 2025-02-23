<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElevesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eleves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idAvenue');
            $table->foreign('idAvenue')->references('id')->on('avenues');


            $table->string('nomEleve', 250)->nullable();
            $table->string('postNomEleve', 250)->nullable();
            $table->string('preNomEleve', 250)->nullable();
            $table->string('etatCivilEleve', 250)->nullable();
            $table->string('sexeEleve', 250)->nullable();


            $table->string('nomPere', 250)->nullable();
            $table->string('nomMere', 250)->nullable();

            $table->string('numPere', 250)->nullable();
            $table->string('numMere', 250)->nullable();
            $table->string('photoEleve', 250)->nullable();
            $table->string('codeEleve', 250)->nullable();

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
        Schema::dropIfExists('eleves');
    }
}
