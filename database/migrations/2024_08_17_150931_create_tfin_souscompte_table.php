<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTfinSouscompteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tfin_souscompte', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refCompte')->constrained('tfin_compte')->restrictOnUpdate()->restrictOnDelete();
            $table->string('nom_souscompte',100);
            $table->string('numero_souscompte',50);
            $table->string('author');
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
        Schema::dropIfExists('tfin_souscompte');
    }
}
