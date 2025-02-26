<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('cpf')->unique()->nullable();
            $table->string('cnpj')->unique()->nullable();
            $table->timestamps();
        });

        try {
            DB::statement('ALTER TABLE users ADD CONSTRAINT check_cpf_cnpj CHECK (cpf IS NOT NULL OR cnpj IS NOT NULL)');
        } catch (Exception $e) {}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try {
            DB::statement('ALTER TABLE users DROP CONSTRAINT check_cpf_cnpj');
        } catch (Exception $e) {}

        Schema::dropIfExists('users');
    }
}
