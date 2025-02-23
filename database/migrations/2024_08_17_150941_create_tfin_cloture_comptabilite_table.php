<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTfinClotureComptabiliteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //id,numerOperation,dateCloture,tauxdujour,author  tfin_cloture_comptabilite
        Schema::create('tfin_cloture_comptabilite', function (Blueprint $table) {
            $table->id();
            $table->integer('numerOperation');
            $table->string('dateCloture',20); 
            $table->double('tauxdujour');
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
        Schema::dropIfExists('tfin_cloture_comptabilite');
    }
}
