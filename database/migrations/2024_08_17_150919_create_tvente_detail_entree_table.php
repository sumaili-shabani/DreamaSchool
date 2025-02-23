<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeDetailEntreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_detail_entree', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteEntree')->constrained('tvente_entete_entree')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refProduit')->constrained('tvente_produit')->restrictOnUpdate()->restrictOnDelete();
            $table->double('puEntree',50,2);
            $table->string('devise',50);
            $table->double('taux',50,2);            
            $table->double('qteEntree',50,2);
            $table->string('unite_paquet',50)->default('Par Pièce');
            $table->double('puPaquet',50,2)->default(0);
            $table->double('qtePaquet',50,2)->default(0);
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
        Schema::dropIfExists('tvente_detail_entree');
    }
}
