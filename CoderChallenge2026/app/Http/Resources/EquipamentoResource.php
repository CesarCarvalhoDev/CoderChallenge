<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipamentoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $hoje = now()->startOfDay();
        $dataManutencao = $this->data_proxima_manutencao;

        return [
            'id'                          => $this->id,
            'numero_serie'                => $this->numero_serie,
            'marca'                       => $this->marca,
            'modelo'                      => $this->modelo,
            'tipo'                        => $this->tipo,
            'localizacao'                 => [
                'cep'        => $this->cep,
                'logradouro' => $this->logradouro,
                'bairro'     => $this->bairro,
                'cidade'     => $this->cidade,
                'uf'         => $this->uf,
                'referencia' => $this->referencia,
                'latitude'   => $this->latitude,
                'longitude'  => $this->longitude,
            ],
            'situacao'                    => $this->situacao,
            'necessidade_manutencao'      => $this->necessidade_manutencao,
            'data_proxima_manutencao'     => $dataManutencao ? $dataManutencao->format('Y-m-d') : null,
            'caracteristicas_especificas' => $this->caracteristicas_especificas ?? [],
            
            'alerta_critico'              => in_array($this->situacao, ['mau_funcionamento', 'furtado']) || $this->necessidade_manutencao === 'imediata',
            'manutencao_proxima'          => $dataManutencao ? $dataManutencao->between($hoje, $hoje->copy()->addDays(7)) : false,
            
            'agentes_vinculados'          => AgenteResource::collection($this->whenLoaded('agentes')),
            'criado_em'                   => $this->created_at?->toIso8601String(),
            'atualizado_em'               => $this->updated_at?->toIso8601String(),
        ];
    }
}