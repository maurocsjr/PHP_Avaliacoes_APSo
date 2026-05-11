<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvaliacaoRanking extends Model
{
    protected $table = 'vw_avaliacao_ranking';
    protected $fillable = [
        'Id_Campo',
        'CampoNome',
        'Id_Escola',
        'EscolaSigla',
        'EscolaNome',
        'Id_Avaliacao',
        'AnoAvaliacao',
        'Secoes',
        'NotaFinal',
        'SomaPesoItem',
        'Porcentagem'
    ];
}
