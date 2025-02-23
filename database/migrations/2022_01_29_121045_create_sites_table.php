<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 250)->nullable();
            $table->text('description')->nullable();
            $table->string('email', 250)->nullable();
            $table->string('adresse', 250)->nullable();
            $table->string('tel1', 250)->nullable();
            $table->string('tel2', 250)->nullable();
            $table->string('tel3', 250)->nullable();
            $table->string('token', 250)->nullable();
            $table->string('about', 250)->nullable();
            $table->string('mission', 250)->nullable();
            $table->string('objectif', 250)->nullable();
            $table->text('politique')->nullable();
            $table->text('condition')->nullable();
            $table->string('logo', 250)->nullable();
            $table->string('facebook', 500)->nullable();
            $table->string('linkedin', 500)->nullable();
            $table->string('twitter', 500)->nullable();
            $table->string('youtube', 500)->nullable();
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
        Schema::dropIfExists('sites');
    }
}
