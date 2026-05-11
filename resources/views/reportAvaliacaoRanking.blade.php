@extends('reportTemplateRanking')

@section('reportTitle')
    Ranking de Avaliação
@endsection

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style>
        body, html {
            font-family: "Anton", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .logo {
            position: relative;
            top: 0;
            left: 331px;
        }

        .logo img {
            width: 1.5cm;
            height: 1.5cm;
        }

        .title {
            position: relative;
            top: 10px;
            left: 285px;
            background-color: #0062b8;
            color: white;
            padding: -10px 10px 10px;
            font-size: 33px;
            width: 130px;
        }

        .subtitle {
            position: relative;
            margin-top: -25px;
            left: 180px;
            font-size: 84px;
            color: #001a86;
        }

        .ranking {
            margin-top: 50px;
        }

        .stamp {
            position: relative;
        }

        .img-ranking {
            position: absolute;
            top: -60px;
            right: 200px;
            z-index: 3;
        }

        .img-ranking-balls {
            position: absolute;
            width: 220px;
            z-index: 0;
        }

        .img-ranking-silver {
            position: absolute;
            top: -70px;
            right: 200px;
            z-index: 3;
        }

        .guide-bar-gold {
            background: #a47e0e;
            width: 200px;
            height: 435px;
            border-top-left-radius: 100px;
            border-top-right-radius: 100px;
            z-index: 3;
        }

        .color-gold {
            background: #a47e0e;
            color: white;
        }

        .guide-bar-silver {
            background: #8d9399;
            width: 200px;
            height: 365px;
            border-top-left-radius: 100px;
            border-top-right-radius: 100px;
            z-index: 3;
        }

        .color-silver {
            background: #8d9399;
            color: white;
        }

        .guide-bar-diamond {
            background: #00638d;
            width: 200px;
            height: 609px;
            border-top-left-radius: 100px;
            border-top-right-radius: 100px;
            z-index: 3;
        }

        .color-diamond {
            background: #00638d;
            color: white;
        }

        #avaliacao {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            margin-right: 10px;
            padding-left: 10px;
            font-size: 10px;
        }

        #avaliacao td,
        #avaliacao th {
            text-align: center;
            border: 1px solid #ddd;
            padding: 2pt;
        }

        #avaliacao tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #avaliacao tr:hover {
            background-color: #ddd;
        }

        #avaliacao th {
            text-align: center;
            background-color: #003b6f;
            color: white;
        }

        #avaliacao tfoot {
            background-color: #003b6f;
            color: white;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

@section('reportGraph')
    <header>
        <div class="logo">
            <img src="./img/logo.png">
        </div>
        <div class="title">PÓDIO DAS</div>
        <div class="subtitle">AVALIAÇÕES</div>
    </header>

    <div class="ranking" style="width: 700px; height: 600px; position: relative">
        <div class="guide-bar-gold" style="position: absolute;top: 265px;left: 0;z-index: 1">
            <div class="stamp">
                <img class="img-ranking" src="./img/gold.png">
            </div>
        </div>
        <img class="img-ranking-balls" src="./img/background-balls.png" style="top: 180px;left: -10px">
        <div class="guide-bar-diamond" style="position: absolute;top: 91px;left: 250px;">
            <div class="stamp">
                <img class="img-ranking" src="./img/diamond.png">
            </div>
        </div>
        <img class="img-ranking-balls" src="./img/background-balls.png" style="top: 10px;left: 240px">
        <div class="guide-bar-silver" style="position: absolute;top: 335px;right: 0">
            <div class="stamp">
                <img class="img-ranking-silver" src="./img/silver.png">
            </div>
        </div>
        <img class="img-ranking-balls" src="./img/background-balls.png" style="top: 270px;right: -10px">
    </div>
@endsection



@section('reportTable')
    <div class="page-break"></div>

    @foreach ($avaliacoesRankingGrouped as $avaliacoesGrouped)
        <table id="avaliacao">
            <thead>
            <tr>
                <th colspan="{{$avaliacoesGrouped->unique('AnoAvaliacao')->count() + 1}}">
                    {{$avaliacoesGrouped->first()->CampoNome}}
                </th>
            </tr>
            <tr>
                <th style="text-align: left; width: 300px">UNIDADE ESCOLAR</th>
                @foreach($avaliacoesGrouped->unique('AnoAvaliacao')->pluck('AnoAvaliacao')->sort() as $ano)
                    <th>{{$ano}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($avaliacoesGrouped->unique('EscolaNome')->sort() as $escola)
                <tr>
                    <td style="text-align: left;">{{$escola->EscolaNome}} - {{$escola->EscolaSigla}}</td>
                    @foreach($avaliacoesGrouped->unique('AnoAvaliacao')->pluck('AnoAvaliacao')->sort() as $ano)
                        @php
                            $percentage = round($avaliacoesGrouped->filter(
                                function ($avaliacao) use ($escola, $ano) {
                                    return $avaliacao->EscolaNome == $escola->EscolaNome && $avaliacao->AnoAvaliacao == $ano;
                                })->first()->Porcentagem ?? 0);
                            $cssClass = '';
                            if ($percentage >= 96) {
                                $cssClass = 'color-diamond';
                            } elseif ($percentage >= 81 && $percentage <= 95) {
                                $cssClass = 'color-gold';
                            } elseif( $percentage <= 80 && $percentage >= 61) {
                                $cssClass = 'color-silver';
                            }
                        @endphp
                        <td class="{{$cssClass}}">
                            {{$percentage}} %
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    @endforeach
    <div style="margin-left: 10px">
        Legendas: <br>
        <div>
        <span class="color-diamond" style="display: inline-block; width: 70px; height: 30px; text-align: center">
            Diamante
        </span>
            - Acima de 95%
        </div>
        <div>
        <span class="color-gold" style="display: inline-block; width: 50px; height: 30px; text-align: center">
            Ouro
        </span>
            - Entre 81% e 95%
        </div>
        <div>
        <span class="color-silver" style="display: inline-block; width: 50px; height: 30px; text-align: center">
            Prata
        </span>
            - Entre 61% e 80%
        </div>
    </div>
@endsection
