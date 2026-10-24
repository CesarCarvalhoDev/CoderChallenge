<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    use HasFactory;

    protected $table = 'equipamentos';

    protected $fillable = [
        'numero_serie',
        'marca',
        'modelo',
        'tipo',
        'cep',
        'logradouro',
        'bairro',
        'cidade',
        'uf',
        'referencia',
        'latitude',
        'longitude',
        'situacao',
        'necessidade_manutencao',
        'data_proxima_manutencao',
        'caracteristicas_especificas',
    ];

    protected function casts(): array
    {
        return [
            'data_proxima_manutencao' => 'date',
            'caracteristicas_especificas' => 'array',
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    /**
     * Regra de negócio automática: se entrar em "mau_funcionamento",
     * exige manutenção "imediata" automaticamente.
     */
    protected static function booted(): void
    {
        static::saving(function (Equipamento $equipamento) {
            if ($equipamento->situacao === 'mau_funcionamento') {
                $equipamento->necessidade_manutencao = 'imediata';
            }
        });
    }

    public function agentes()
    {
        return $this->hasMany(Agente::class, 'equipamento_id');
    }
}