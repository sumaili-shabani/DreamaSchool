<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributionCoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribution_cours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idCours');
            $table->foreign('idCours')->references('id')->on('cours');
            $table->unsignedBigInteger('idEnseignant');
            $table->foreign('idEnseignant')->references('id')->on('enseignants');
            $table->unsignedBigInteger('idPeriode');
            $table->foreign('idPeriode')->references('id')->on('periodes');

            $table->unsignedBigInteger('idAnne');
            $table->foreign('idAnne')->references('id')->on('anne_scollaires');

            $table->unsignedBigInteger('idOption');
            $table->foreign('idOption')->references('id')->on('options');

            $table->unsignedBigInteger('idClasse');
            $table->foreign('idClasse')->references('id')->on('classes');

            $table->double('maximale');
            $table->string('codeAt', 250)->nullable();
            
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
        Schema::dropIfExists('attribution_cours');
    }
}
