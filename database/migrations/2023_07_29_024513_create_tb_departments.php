<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbDepartments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_departments', function (Blueprint $table) {
            $table->id(); // Número inteiro auto-incrementado
            $table->string('name'); // Nome do Departamento
            $table->timestamps(); // Criação e atualização das colunas
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_departments');
    }
}
