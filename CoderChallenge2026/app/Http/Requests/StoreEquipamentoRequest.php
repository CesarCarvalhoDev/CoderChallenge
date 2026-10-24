<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipamentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Liberado para os testes da API
    }

    public function rules(): array
    {
        return [
            'numero_serie'                => 'required|string|max:100|unique:equipamentos,numero_serie',
            'marca'                       => 'required|string|max:100',
            'modelo'                      => 'required|string|max:100',
            'tipo'                        => 'required|string|max:50',
            'cep'                         => 'required|string|max:9',
            'logradouro'                  => 'required|string|max:255',
            'bairro'                      => 'required|string|max:100',
            'cidade'                      => 'required|string|max:100',
            'uf'                          => 'required|string|size:2',
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