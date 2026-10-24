<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa as migrations.
     */
    public function up(): void
    {
        Schema::create('agentes', function (Blueprint $table) {
            $table->id();

            $table->string('matricula')->unique();
            $table->string('nome');
            $table->string('cargo')->index(); 
            $table->string('orgao'); 
            $table->string('contato')->nullable(); 

            $table->string('situacao')->default('disponivel_base')->index();
            $table->string('bairro_atuacao')->nullable()->index();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            $table->foreignId('equipamento_id')
                ->nullable()
                ->constrained('equipamentos')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverte as migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agentes');
    }
};