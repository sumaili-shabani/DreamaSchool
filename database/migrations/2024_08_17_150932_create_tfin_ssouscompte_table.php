<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTfinSsouscompteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tfin_ssouscompte', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refSousCompte')->constrained('tfin_souscompte')->restrictOnUpdate()->restrictOnDelete();
            $table->string('nom_ssouscompte',100);
            $table->string('numero_ssouscompte',50);
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
        Schema::dropIfExists('tfin_ssouscompte');
    }
}
