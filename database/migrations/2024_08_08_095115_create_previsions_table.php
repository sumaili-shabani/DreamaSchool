<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrevisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('previsions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('idTranche')->nullable();
            $table->foreign('idTranche')->references('id')->on('tranches');

            $table->unsignedBigInteger('idFrais')->nullable();
            $table->foreign('idFrais')->references('id')->on('type_tranches');

            $table->unsignedBigInteger('idClasse')->nullable();
            $table->foreign('idClasse')->references('id')->on('classes');

            $table->unsignedBigInteger('idAnne')->nullable();
            $table->foreign('idAnne')->references('id')->on('anne_scollaires');

            $table->unsignedBigInteger('idOption')->nullable();
            $table->foreign('idOption')->references('id')->on('options');

            $table->double('montant')->nullable();
            
            $table->integer('etatPrevision')->default(0);

            $table->string('date_debit_prev',250)->nullable();
            $table->string('date_fin_prev',250)->nullable();

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
        Schema::dropIfExists('previsions');
    }
}
