<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ibpt extends Model
{
    use HasFactory;

    protected $table = 'ibpt';

    protected $fillable = [
        'codigo',
        'uf',
        'ex',
        'descricao',
        'nacional',
        'estadual',
        'importado',
        'municipal',
        'tipo',
        'vigencia_inicio',
        'vigencia_fim',
        'chave',
        'versao',
        'fonte',
        'valor',
        'valor_tributo_nacional',
        'valor_tributo_estadual',
        'valor_tributo_importado',
        'valor_tributo_municipal',
    ];

    protected $casts = [
        'vigencia_inicio' => 'date',
        'vigencia_fim' => 'date',
        'nacional' => 'decimal:2',
        'estadual' => 'decimal:2',
        'importado' => 'decimal:2',
        'municipal' => 'decimal:2',
        'valor' => 'decimal:2',
        'valor_tributo_nacional' => 'decimal:2',
        'valor_tributo_estadual' => 'decimal:2',
        'valor_tributo_importado' => 'decimal:2',
        'valor_tributo_municipal' => 'decimal:2',
    ];
}