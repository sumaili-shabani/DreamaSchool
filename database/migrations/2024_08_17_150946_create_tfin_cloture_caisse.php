<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTfinClotureCaisse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tfin_cloture_caisse', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refSscompte')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete();
            $table->string('date_cloture',20);
            $table->double('montant_cloture');
            $table->double('taux_dujour');           
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
        Schema::dropIfExists('tfin_cloture_caisse');
    }
}
