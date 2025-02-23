<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeProduitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_produit', function (Blueprint $table) {
            $table->id();
            $table->string('designation',100); 
            $table->double('pu',50,2);
            $table->double('qte',50,2)->default(0);
            $table->double('qte_unite',50,2)->default(1);
            $table->foreignId('refCategorie')->constrained('tvente_categorie_produit')->restrictOnUpdate()->restrictOnDelete();
            $table->string('devise');
            $table->string('taux');
            $table->string('unite'); 
            $table->string('author',100);
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
        Schema::dropIfExists('tvente_produit');
    }
}
