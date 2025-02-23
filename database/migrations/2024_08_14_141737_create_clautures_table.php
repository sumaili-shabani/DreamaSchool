<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClauturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clautures', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('idAnne')->nullable();
            $table->foreign('idAnne')->references('id')->on('anne_scollaires');

            $table->unsignedBigInteger('idOption')->nullable();
            $table->foreign('idOption')->references('id')->on('options');

            $table->unsignedBigInteger('idSection')->nullable();
            $table->foreign('idSection')->references('id')->on('sections');
            $table->unsignedBigInteger('idClasse')->nullable();
            $table->foreign('idClasse')->references('id')->on('classes');

            $table->integer('refMois')->nullable();
            $table->string('mois', 250)->nullable();
            
            $table->integer('effectifClasse')->default(0);
            $table->integer('effectifAbandon')->default(0);
            $table->integer('effectifTotal')->default(0);

            

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
        Schema::dropIfExists('clautures');
    }
}
