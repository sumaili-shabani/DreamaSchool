<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtTresoEnteteEtatbesoinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tt_treso_entete_etatbesoin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refProvenance')->constrained('tt_treso_provenance')->restrictOnUpdate()->restrictOnDelete();
            $table->string('motifDepense',100)->nullable();
            $table->datetime('DateElaboration')->nullable();
            $table->string('AcquitterPar',100)->nullable();
            $table->string('StatutAcquitterPar',100)->default('NON')->nullable();
            $table->datetime('DateAcquitterPar')->nullable();
            $table->string('ApproCoordi',100)->nullable();
            $table->string('StatutApproCoordi',100)->default('NON')->nullable();
            $table->datetime('DateApproCoordi')->nullable();
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
        Schema::dropIfExists('tt_treso_entete_etatbesoin');
    }
}
