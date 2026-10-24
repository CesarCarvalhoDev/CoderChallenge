<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EquipamentoResource;
use App\Models\Agente;
use App\Models\Equipamento;

class CentralOperacoesController extends Controller
{
    /**
     * Retorna os indicadores consolidados e alertas da 2ª Parte (GET /api/central-operacoes/resumo)
     */
    public function resumo()
    {
        $totalEquipamentos = Equipamento::count();
        $operacionais = Equipamento::where('situacao', 'operacional')->count();
        $indisponiveis = Equipamento::whereIn('situacao', ['mau_funcionamento', 'em_manutencao', 'desativado', 'furtado'])->count();

        $percentualDisponibilidade = $totalEquipamentos > 0
            ? round(($operacionais / $totalEquipamentos) * 100, 1)
            : 0;

        $agentesEmAtividade = Agente::whereIn('situacao', ['em_atividade', 'em_ocorrencia'])->count();

        // Equipamentos críticos (mau funcionamento, furtados ou manutenção imediata)
        $alertasCriticos = Equipamento::whereIn('situacao', ['mau_funcionamento', 'furtado'])
            ->orWhere('necessidade_manutencao', 'imediata')
            ->get();

        // Visão consolidada por bairro (identifica quais bairros exigem atenção)
        $visaoPorBairro = Equipamento::selectRaw("
                bairro,
                COUNT(*) as total_equipamentos,
                SUM(CASE WHEN situacao = 'operacional' THEN 1 ELSE 0 END) as operacionais,
                SUM(CASE WHEN situacao IN ('mau_funcionamento', 'furtado') OR necessidade_manutencao = 'imediata' THEN 1 ELSE 0 END) as criticos
            ")
            ->groupBy('bairro')
            ->get()
            ->map(function ($item) {
                $item->status_regiao = $item->criticos > 0 ? 'exige_atencao' : 'operando_normalmente';
                return $item;
            });

        return response()->json([
            'indicadores' => [
                'total_equipamentos'         => $totalEquipamentos,
                'equipamentos_operacionais'  => $operacionais,
                'equipamentos_indisponiveis' => $indisponiveis,
                'percentual_disponibilidade' => $percentualDisponibilidade,
                'total_agentes'              => Agente::count(),
                'agentes_em_atividade'       => $agentesEmAtividade,
            ],
            'alertas_criticos' => EquipamentoResource::collection($alertasCriticos),
            'regioes_bairros'  => $visaoPorBairro,
        ]);
    }
}