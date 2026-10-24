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
        Schema::create('equipamentos', function (Blueprint $table) {
            $table->id();

            // Identificação Básica
            $table->string('numero_serie')->unique();
            $table->string('marca');
            $table->string('modelo');
            $table->string('tipo')->index(); // radar, camera, balanca, viatura, patinete, etc.

            // Localização (Instalação ou Base)
            $table->string('cep', 9);
            $table->string('logradouro'); // Nome da rua/via
            $table->string('bairro')->index(); // Indexado para filtros e mapas de calor
            $table->string('cidade');
            $table->char('uf', 2);
            $table->string('referencia')->nullable(); // Ex: "número 181", "KM 203", "em frente ao Mercado do Tio"
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Situação e Controle de Manutenção
            // Ex: ainda_nao_instalado, operacional, mau_funcionamento, em_manutencao, desativado, furtado
            $table->string('situacao')->default('ainda_nao_instalado')->index();
            
            // Ex: nenhuma, agendada, imediata
            $table->string('necessidade_manutencao')->default('nenhuma')->index();
            $table->date('data_proxima_manutencao')->nullable();

            // Outras características específicas de cada tipo (JSON flexível)
            // Ex: {"visao_noturna": true, "resolucao": "4K"} ou {"velocidade_maxima": 60}
            $table->json('caracteristicas_especificas')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverte as migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipamentos');
    }
};