<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtTresoDetailAngagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tt_treso_detail_angagement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEntete')->constrained('ttreso_entete_angagement')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refRubrique')->constrained('tt_treso_rubrique')->restrictOnUpdate()->restrictOnDelete();
            $table->double('Qte');
            $table->double('PU');
            $table->string('service_beneficiaire',100);
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
        Schema::dropIfExists('tt_treso_detail_angagement');
    }
}
