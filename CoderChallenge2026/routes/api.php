<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EquipamentoController;
use App\Http\Controllers\Api\AgenteController;
use App\Http\Controllers\Api\CentralOperacoesController;

// CRUD Completo de Equipamentos e Agentes (1ª e 2ª Parte)
Route::apiResource('equipamentos', EquipamentoController::class);
Route::apiResource('agentes', AgenteController::class);

// Endpoint consolidado de Indicadores e Alertas da Central de Operações (2ª Parte)
Route::get('central-operacoes/resumo', [CentralOperacoesController::class, 'resumo']);