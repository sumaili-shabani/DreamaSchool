<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnseignantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enseignants', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('idAvenue');
            $table->foreign('idAvenue')->references('id')->on('avenues');
            
            $table->string('nomEns', 250)->nullable();
            $table->string('nomUtilisateurEns', 250)->nullable();
            $table->string('nationaliteEns', 250)->nullable();
            $table->string('telEns', 250)->nullable();
            $table->string('tel2Ens', 250)->nullable();
            $table->string('sexeEns', 250)->nullable();
            $table->string('etatcivilEns', 250)->nullable();
            $table->string('prefEns', 250)->nullable();
            $table->string('degreprefEns', 250)->nullable();
            $table->string('telprefEns', 250)->nullable();
            $table->string('codeEns', 250)->nullable();
            $table->string('numCarteEns', 250)->nullable();
            $table->string('passwordEns', 250)->nullable();
            $table->string('imageEns', 250)->nullable();

            $table->string('numMaisonEns', 250)->nullable();
            $table->string('dateNaisEns', 250)->nullable();


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
        Schema::dropIfExists('enseignants');
    }
}
