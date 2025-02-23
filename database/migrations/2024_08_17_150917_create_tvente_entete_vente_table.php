<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeEnteteVenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_entete_vente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refClient')->constrained('inscriptions')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateVente',20);
            $table->string('libelle',50);
            $table->double('montant',50,2)->default(0);
            $table->double('paie',50,2)->default(0);
            $table->string('author',50);
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
        Schema::dropIfExists('tvente_entete_vente');
    }
}
