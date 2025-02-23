<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idEleve');
            $table->foreign('idEleve')->references('id')->on('eleves');

            $table->unsignedBigInteger('idAnne');
            $table->foreign('idAnne')->references('id')->on('anne_scollaires');

            $table->unsignedBigInteger('idOption');
            $table->foreign('idOption')->references('id')->on('options');

            $table->unsignedBigInteger('idClasse');
            $table->foreign('idClasse')->references('id')->on('classes');

            $table->unsignedBigInteger('idDivision');
            $table->foreign('idDivision')->references('id')->on('divisions');

            $table->string('dateInscription', 250)->nullable();
            $table->string('codeInscription', 250)->nullable();
            $table->double('reductionPaiement')->default(0);           
            $table->double('fraisinscription')->default(0);
            $table->double('restoreinscription')->default(0);

            $table->timestamps();
        });
    }

    //fraisinscription

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inscriptions');
    }
}
