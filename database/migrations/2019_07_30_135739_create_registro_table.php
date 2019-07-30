<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('registro_tipo_id');
            $table->unsignedBigInteger('registro_categoria_id');
            $table->unsignedBigInteger('vendedor_id')->nullable();
            $table->date('data');
            $table->decimal('valor');
            $table->string('descricao')->nullable();
            $table->jsonb('tags')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('registro_tipo_id')->references('id')->on('registro_tipo');
            $table->foreign('registro_categoria_id')->references('id')->on('registro_categoria');
            $table->foreign('vendedor_id')->references('id')->on('vendedor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registro');
    }
}
