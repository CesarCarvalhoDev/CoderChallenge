<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAgenteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $agenteId = $this->route('agente')->id ?? $this->route('agente');

        return [
            'matricula'      => ['sometimes', 'string', 'max:50', Rule::unique('agentes', 'matricula')->ignore($agenteId)],
            'nome'           => 'sometimes|string|max:150',
            'cargo'          => 'sometimes|string|max:50',
            'orgao'          => 'sometimes|string|max:100',
            'contato'        => 'nullable|string|max:50',
            'situacao'       => 'sometimes|string|in:em_atividade,em_ocorrencia,disponivel_base,fora_de_servico',
            'bairro_atuacao' => 'nullable|string|max:100',
            'latitude'       => 'nullable|numeric|between:-90,90',
            'longitude'      => 'nullable|numeric|between:-180,180',
            'equipamento_id' => 'nullable|exists:equipamentos,id',
        ];
    }
}