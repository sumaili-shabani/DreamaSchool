<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaiementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idTranche')->nullable();
            $table->foreign('idTranche')->references('id')->on('tranches');

            $table->unsignedBigInteger('idFrais')->nullable();
            $table->foreign('idFrais')->references('id')->on('type_tranches');

            $table->unsignedBigInteger('idInscription')->nullable();
            $table->foreign('idInscription')->references('id')->on('inscriptions');

            $table->double('montant')->nullable();
            $table->string('datePaiement', 250)->nullable();
            $table->string('codePaiement', 250)->nullable();

            $table->unsignedBigInteger('idUser')->nullable();
            $table->foreign('idUser')->references('id')->on('users');

            $table->foreignId('refBanque')->constrained('tconf_banque')->restrictOnUpdate()->restrictOnDelete();
            $table->string('numeroBordereau',20)->nullable();

            $table->integer('etatPaiement')->default(0);

            

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
        Schema::dropIfExists('paiements');
    }
}
