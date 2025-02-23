<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTcompteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcompte', function (Blueprint $table) {
            $table->id();
            $table->string('designation',100); 
            $table->foreignId('refMvt')->constrained('ttypemouvement')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refSscompte')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete();
            $table->timestamps();
           
        });
    }
//refSscompte
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
