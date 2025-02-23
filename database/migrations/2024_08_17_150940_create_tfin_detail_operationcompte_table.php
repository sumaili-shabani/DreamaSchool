<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTfinDetailOperationcompteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //id,refEnteteOperation,refSscompte,typeOperation,montantOpration
        Schema::create('tfin_detail_operationcompte', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteOperation')->constrained('tfin_entete_operationcompte')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refSscompte')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete();
            $table->string('typeOperation');
            $table->double('montantOpration');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
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
        Schema::dropIfExists('tfin_detail_operationcompte');
    }
}
