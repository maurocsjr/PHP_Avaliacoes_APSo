<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AvaliacaoNotas extends Model
{
    protected $table = 'vw_avaliacao_notas';
    protected $fillable = [
        'Id_Avaliacao',
        'Id_Secao',
        'Secao',
        'Peso_Secao',
        'Nota_Final',
        'Soma_Valor',
        'Soma_Peso_Item',
        'Porcentagem'
    ];
}
