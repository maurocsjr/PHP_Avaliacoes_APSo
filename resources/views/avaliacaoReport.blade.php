@extends('reportTemplate')

@section('reportTitle')
    Relatório
@endsection

@section('body')
    <header>
        <div class="titulo">Relatório de Avaliação - APSo</div>
        <img class="logo" src="./img/logo.png">
        <div class="subtitle">{{$itensAvaliacao[0]->Campo}} - {{$itensAvaliacao[0]->Escola}}</div>
        <div class="numero-avaliacao">Nº {{$id}}</div>
    </header>
    <div class="content">
        <hr class="linha-content"/>
        <div class="texto-table">Itens da Avaliação</div>
        @foreach ($secoesAvaliacao as $secao)
            <br>
            <div class="texto-table">{{$secao->Secao}}</div>
            <table id="avaliacao">
                <thead>
                <tr>
                    <th>#</th>
                    <th style="text-align: left;">Item</th>
                    <th>Peso</th>
                    <th>Valor</th>
                    <th>Nota</th>
                    <th>Possui Anexo</th>
                    <th>Anexo Enviado</th>
                    <th>Nota Final</th>
                    <th style="text-align: left;">Descrição da Nota</th>
                </tr>
                </thead>
                <tbody>
                @foreach($itensAvaliacao as $item)
                    @if ($secao->Id_Secao == $item->Id_Secao)
                        <tr>
                            <td>{{$item->Posicao}}</td>
                            <td class="item-html">{!! $item->Item !!}</td>
                            <td>{{$item->Peso_Item}}</td>
                            <td>{{$item->Valor_Item}}</td>
                            <td>{{$item->Nota_Item}}</td>
                            <td>{{$item->Anexo_Possui == 1 ? 'Sim' : 'Não' }}</td>
                            <td>{{$item->Anexo_Enviado == 1 ? 'Sim' : 'Não'}}</td>
                            <td>{{$item->Nota_Final_Item}}</td>
                            <td style="text-align: left">{{$item->Descricao_Nota}}</td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="8" style="text-align: right">Soma das Notas:</td>
                    <td colspan="1">{{$secao->Nota_Final}} / {{$secao->Soma_Peso_Item}}
                        ou {{round((($secao->Nota_Final / $secao->Soma_Peso_Item) * 100), 0)}} %
                    </td>
                </tr>
                </tfoot>
            </table>
        @endforeach

        <br>
        <hr class="linha-content"/>
        <br>
        <div class="texto-table">Totalizador</div>
        <table id="avaliacao">
            <thead>
            <tr>
                <th style="text-align: left;">Seção</th>
                <th>Soma das Notas</th>
                <th>Peso da Seção</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($secoesAvaliacao as $secao)
                <tr>
                    <td style="text-align: left">{{$secao->Secao}}</td>
                    <td>{{$secao->Porcentagem * 100}} %</td>
                    <td>{{$secao->Peso_Secao}}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="2" style="text-align: right">Nota Final Total:</td>
                <td colspan="1">{{round((($secoesAvaliacao->sum('Porcentagem') / $secoesAvaliacao->count())  * 100), 0)}}
                    %
                </td>
            </tr>
            </tfoot>
        </table>
        <div>
            <hr class="linha-content"/>
            <div class="texto-table" style="font-size: 20px;">Feedback</div>
            @if (count($feedbacksAll) > 0)
                @php
                    $feedbacksAllGrouped = collect($feedbacksAll)->groupBy(function ($feedback) {
                        return $feedback['secao']['secao'] ?? 'Sem seção';
                    });
                @endphp
                @foreach($feedbacksAllGrouped as $secaoNome => $feedbacksDaSecao)
                    <div class="texto-table" style="margin-top: 18px; padding-bottom: 10px;">{{ $secaoNome }}</div>
                    <div style="margin: 4px 0 22px 20px; font-size: 12px;">
                        @foreach($feedbacksDaSecao as $feedback)
                            <div style="margin: 3px 0;">
                                <span style="font-weight: 600;">{{ $feedback['feedback']['descricao'] ?? '-' }}:</span>
                                <span>{{ $feedback['texto'] ?? '-' }}</span>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @else
                <div style="margin-left: 20px; margin-top: 18px; padding-bottom: 10px;">
                    Nenhum feedback registrado.
                </div>
            @endif
        </div>

        <footer>

        </footer>
@endsection
