<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdepenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdepense', function (Blueprint $table) {
            $table->id();
            $table->double('montant');
            $table->string('montantLettre',200);
            $table->string('motif',100); 
            $table->string('dateOperation',20);
            $table->foreignId('refMvt')->constrained('ttypemouvement')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refCompte')->constrained('tcompte')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refBanque')->constrained('tconf_banque')->restrictOnUpdate()->restrictOnDelete();
            $table->string('modepaie',20)->nullable();            
            $table->string('numeroBordereau',50)->default('0000')->nullable();
            $table->double('taux_dujour')->nullable();
            $table->string('AcquitterPar',100)->nullable();
            $table->string('StatutAcquitterPar',5)->default('NON')->nullable();
            $table->datetime('DateAcquitterPar')->nullable();
            $table->string('ApproCoordi',100)->nullable();
            $table->string('StatutApproCoordi',5)->default('NON')->nullable();
            $table->datetime('DateApproCoordi')->nullable();
            $table->string('numeroBE',50)->nullable();
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
        Schema::dropIfExists('tdetailproduit');
    }
}
