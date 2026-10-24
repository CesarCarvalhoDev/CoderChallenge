<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEquipamentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $equipamentoId = $this->route('equipamento')->id ?? $this->route('equipamento');

        return [
            'numero_serie'                => ['sometimes', 'string', 'max:100', Rule::unique('equipamentos', 'numero_serie')->ignore($equipamentoId)],
            'marca'                       => 'sometimes|string|max:100',
            'modelo'                      => 'sometimes|string|max:100',
            'tipo'                        => 'sometimes|string|max:50',
            'cep'                         => 'sometimes|string|max:9',
            'logradouro'                  => 'sometimes|string|max:255',
            'bairro'                      => 'sometimes|string|max:100',
            'cidade'                      => 'sometimes|string|max:100',
            'uf'                          => 'sometimes|string|size:2',
            'referencia'                  => 'nullable|string|max:255',
            'latitude'                    => 'nullable|numeric|between:-90,90',
            'longitude'                   => 'nullable|numeric|between:-180,180',
            'situacao'                    => 'sometimes|string|in:ainda_nao_instalado,operacional,mau_funcionamento,em_manutencao,desativado,furtado',
            'necessidade_manutencao'      => 'sometimes|string|in:nenhuma,agendada,imediata',
            'data_proxima_manutencao'     => 'nullable|date',
            'caracteristicas_especificas' => 'nullable|array',
        ];
    }
}