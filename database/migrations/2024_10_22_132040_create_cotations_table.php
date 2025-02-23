<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idInscription');
            $table->foreign('idInscription')->references('id')->on('inscriptions');
            $table->unsignedBigInteger('idCours');
            $table->foreign('idCours')->references('id')->on('cours');
            $table->unsignedBigInteger('idPeriode');
            $table->foreign('idPeriode')->references('id')->on('periodes');

            $table->double('cote')->default(0);
            $table->double('maxima')->default(0);
            $table->string('codeCote', 250)->nullable();
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
        Schema::dropIfExists('cotations');
    }
}
