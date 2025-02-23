<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeDetailRequisitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_detail_requisition', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteCmd')->constrained('tvente_entete_requisition')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refProduit')->constrained('tvente_produit')->restrictOnUpdate()->restrictOnDelete();
            $table->double('puCmd',50,2);
            $table->string('devise',50);
            $table->double('taux',50,2);  
            $table->double('qteCmd',50,2);
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
        Schema::dropIfExists('tvente_detail_requisition');
    }
}
