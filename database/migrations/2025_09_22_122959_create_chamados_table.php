<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chamados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('autor_id')->nullable()->constrained('users')->nullOnDelete(); //FK
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->nullOnDelete(); //FK
            $table->string('titulo');
            $table->dateTime('data');
            $table->string('status'); #nao inciado, em andamento, finalizado, cancelado
            $table->text('descricao');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chamados');
    }
};
