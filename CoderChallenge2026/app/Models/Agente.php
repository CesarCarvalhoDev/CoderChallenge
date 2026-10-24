<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agente extends Model
{
    use HasFactory;

    protected $table = 'agentes';

    protected $fillable = [
        'matricula',
        'nome',
        'cargo',
        'orgao',
        'contato',
        'situacao',
        'bairro_atuacao',
        'latitude',
        'longitude',
        'equipamento_id',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    public function equipamento()
    {
        return $this->belongsTo(Equipamento::class, 'equipamento_id');
    }
}