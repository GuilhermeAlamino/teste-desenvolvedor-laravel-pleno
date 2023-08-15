<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_employees', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');   // firstName: String, obrigatório
            $table->string('lastName');    // lastName: String, obrigatório
            $table->string('email')->unique();   // email: String, obrigatório, deve ser único
            $table->string('phone')->nullable(); // phone: String, opcional
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('tb_departments')->onDelete('set null');  // department_id: Chave estrangeira, relacionada ao modelo Departamento
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
        Schema::table('tb_employees', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropColumn('department_id');
        });
    }
}
