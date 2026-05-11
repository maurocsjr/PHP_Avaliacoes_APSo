<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    protected $table = 'vw_avaliacao';
    protected $fillable = [
        'Id_Avaliacao',
        'Id_Secao',
        'Escola',
        'Campo',
        'Secao',
        'Posicao',
        'Id_Item',
        'Item',
        'Peso_Item',
        'Valor_Item',
        'Nota_Item',
        'Nota_Final_Item',
        'Peso_Secao',
        'Anexo_Possui',
        'Anexo_Enviado',
        'Descricao_Nota',
        'Soma_Valor'
    ];
}
