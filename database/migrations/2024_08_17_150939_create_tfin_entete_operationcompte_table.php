<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTfinEnteteOperationcompteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //id,libelleOperation,dateOpration,numOpereation  author
        Schema::create('tfin_entete_operationcompte', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refTresorerie')->constrained('tconf_banque')->restrictOnUpdate()->restrictOnDelete();
            $table->string('libelleOperation');
            $table->date('dateOpration');
            $table->string('numOpereation');            
            $table->double('tauxdujour');
            $table->string('author'); 
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
        Schema::dropIfExists('tfin_entete_operationcompte');
    }
}
