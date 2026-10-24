<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAgenteRequest;
use App\Http\Requests\UpdateAgenteRequest;
use App\Http\Resources\AgenteResource;
use App\Models\Agente;
use Illuminate\Http\Request;

class AgenteController extends Controller
{
    /**
     * Listar agentes com filtros por cargo, órgão, situação e bairro
     * Ex: GET /api/agentes?orgao=GCM&situacao=em_atividade
     */
    public function index(Request $request)
    {
        $agentes = Agente::query()
            ->with('equipamento')
            ->when($request->filled('cargo'), fn($q) => $q->where('cargo', $request->query('cargo')))
            ->when($request->filled('orgao'), fn($q) => $q->where('orgao', $request->query('orgao')))
            ->when($request->filled('situacao'), fn($q) => $q->where('situacao', $request->query('situacao')))
            ->when($request->filled('bairro_atuacao'), fn($q) => $q->where('bairro_atuacao', $request->query('bairro_atuacao')))
            ->latest()
            ->get();

        return AgenteResource::collection($agentes);
    }

    /**
     * Cadastrar novo agente (POST /api/agentes)
     */
    public function store(StoreAgenteRequest $request)
    {
        $agente = Agente::create($request->validated());

        return (new AgenteResource($agente->load('equipamento')))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Detalhes de um agente específico (GET /api/agentes/{agente})
     */
    public function show(Agente $agente)
    {
        $agente->load('equipamento');

        return new AgenteResource($agente);
    }

    /**
     * Atualizar agente (PUT/PATCH /api/agentes/{agente})
     */
    public function update(UpdateAgenteRequest $request, Agente $agente)
    {
        $agente->update($request->validated());

        return new AgenteResource($agente->fresh('equipamento'));
    }

    /**
     * Remover agente (DELETE /api/agentes/{agente})
     */
    public function destroy(Agente $agente)
    {
        $agente->delete();

        return response()->json([
            'mensagem' => 'Agente removido com sucesso.'
        ], 200);
    }
}