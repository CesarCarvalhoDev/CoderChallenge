<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAgenteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'matricula'      => 'required|string|max:50|unique:agentes,matricula',
            'nome'           => 'required|string|max:150',
            'cargo'          => 'required|string|max:50', // agente_transito, guarda_municipal, policial_militar
            'orgao'          => 'required|string|max:100', // CET, GCM, PM, etc.
            'contato'        => 'nullable|string|max:50',
            'situacao'       => 'sometimes|string|in:em_atividade,em_ocorrencia,disponivel_base,fora_de_servico',
            'bairro_atuacao' => 'nullable|string|max:100',
            'latitude'       => 'nullable|numeric|between:-90,90',
            'longitude'      => 'nullable|numeric|between:-180,180',
            'equipamento_id' => 'nullable|exists:equipamentos,id',
        ];
    }
}