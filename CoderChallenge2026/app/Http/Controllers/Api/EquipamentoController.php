<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEquipamentoRequest;
use App\Http\Requests\UpdateEquipamentoRequest;
use App\Http\Resources\EquipamentoResource;
use App\Models\Equipamento;
use Illuminate\Http\Request;

class EquipamentoController extends Controller
{
    /**
     * Listar equipamentos com suporte aos filtros da 2ª Parte
     * Ex: GET /api/equipamentos?tipo=radar&situacao=operacional&bairro=Centro
     */
    public function index(Request $request)
    {
        $equipamentos = Equipamento::query()
            ->with('agentes')
            ->when($request->filled('tipo'), fn($q) => $q->where('tipo', $request->query('tipo')))
            ->when($request->filled('situacao'), fn($q) => $q->where('situacao', $request->query('situacao')))
            ->when($request->filled('bairro'), fn($q) => $q->where('bairro', $request->query('bairro')))
            ->when($request->filled('necessidade_manutencao'), fn($q) => $q->where('necessidade_manutencao', $request->query('necessidade_manutencao')))
            ->latest()
            ->get();

        return EquipamentoResource::collection($equipamentos);
    }

    /**
     * Cadastrar novo equipamento (POST /api/equipamentos)
     */
    public function store(StoreEquipamentoRequest $request)
    {
        $equipamento = Equipamento::create($request->validated());

        return (new EquipamentoResource($equipamento))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Detalhes de um equipamento específico (GET /api/equipamentos/{equipamento})
     */
    public function show(Equipamento $equipamento)
    {
        $equipamento->load('agentes');

        return new EquipamentoResource($equipamento);
    }

    /**
     * Atualizar equipamento (PUT/PATCH /api/equipamentos/{equipamento})
     */
    public function update(UpdateEquipamentoRequest $request, Equipamento $equipamento)
    {
        $equipamento->update($request->validated());

        return new EquipamentoResource($equipamento->fresh('agentes'));
    }

    /**
     * Remover equipamento (DELETE /api/equipamentos/{equipamento})
     */
    public function destroy(Equipamento $equipamento)
    {
        $equipamento->delete();

        return response()->json([
            'mensagem' => 'Equipamento removido com sucesso.'
        ], 200);
    }
}