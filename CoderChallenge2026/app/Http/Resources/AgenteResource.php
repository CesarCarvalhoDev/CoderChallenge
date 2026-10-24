<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgenteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'matricula'      => $this->matricula,
            'nome'           => $this->nome,
            'cargo'          => $this->cargo,
            'orgao'          => $this->orgao,
            'contato'        => $this->contato,
            'situacao'       => $this->situacao,
            'bairro_atuacao' => $this->bairro_atuacao,
            'coordenadas'    => [
                'latitude'  => $this->latitude,
                'longitude' => $this->longitude,
            ],
            'equipamento_id' => $this->equipamento_id,
            'equipamento'    => new EquipamentoResource($this->whenLoaded('equipamento')),
            'criado_em'      => $this->created_at?->toIso8601String(),
            'atualizado_em'  => $this->updated_at?->toIso8601String(),
        ];
    }
}