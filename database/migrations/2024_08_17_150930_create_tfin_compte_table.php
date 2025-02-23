<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTfinCompteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tfin_compte', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refClasse')->constrained('tfin_classe')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refTypecompte')->constrained('tfin_typecompte')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refPosition')->constrained('tfin_typeposition')->restrictOnUpdate()->restrictOnDelete();
            $table->string('nom_compte',100);
            $table->string('numero_compte',100);
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
        Schema::dropIfExists('tfin_compte');
    }
}
