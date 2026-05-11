<?php

namespace App\Http\Controllers;

use \App\Models\Avaliacao;
use \App\Models\AvaliacaoNotas;
use App\Models\AvaliacaoRanking;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function getAvaliacao($id)
    {
        if ($id !== null) {
            $itensAvaliacao = Avaliacao::where('Id_Avaliacao', '=', $id)->orderBy('Id_Secao')->orderBy('Posicao')->get();
            $secoesAvaliacao = AvaliacaoNotas::selectRaw('*, ROUND((Nota_Final / Soma_Peso_Item), 2) AS Porcentagem')
                ->where('Id_Avaliacao', '=', $id)->orderBy('Id_Secao')->get();
            $feedbacksAll = collect($this->getAvaliacaoFeedbacks($id))->values()->toArray();
            $pdf = FacadePdf::loadView('avaliacaoReport',
                [
                    'itensAvaliacao' => $itensAvaliacao,
                    'secoesAvaliacao' => $secoesAvaliacao,
                    'feedbacksAll' => $feedbacksAll,
                    'id' => $id
                ]
            );
            $nameFile = $itensAvaliacao[0]->Escola . '_' . date("dmY");
            return $pdf->setPaper('a4')->stream($nameFile . '.pdf');
        }
    }

    private function getAvaliacaoFeedbacks($id)
    {
        $rows = DB::table('vw_avaliacao_feedback')
            ->where('Id_Avaliacao', '=', $id)
            ->where('FeedbackActive', '=', 1)
            ->orderBy('Id_Secao')
            ->orderBy('Id_Feedback')
            ->get();

        return $rows->map(function ($row) {
            $rowArr = (array)$row;
            $texto = $rowArr['Texto'] ?? $rowArr['texto'] ?? $rowArr['FeedbackTexto'] ?? null;
            $feedbackDescricao = $rowArr['Feedback'] ?? $rowArr['feedback'] ?? $rowArr['Descricao'] ?? $rowArr['Descricao_Feedback'] ?? null;
            $secaoNome = $rowArr['Secao'] ?? $rowArr['secao'] ?? null;

            return [
                'idSecao' => $rowArr['Id_Secao'] ?? $rowArr['idSecao'] ?? null,
                'idFeedback' => $rowArr['Id_Feedback'] ?? $rowArr['idFeedback'] ?? null,
                'texto' => $texto,
                'feedback' => ['descricao' => $feedbackDescricao],
                'secao' => ['secao' => $secaoNome],
            ];
        })->values()->toArray();
    }

    public function getReportAvaliacaoRanking($campos, $anos)
    {
        if ($campos !== null && $anos !== null) {
            $avaliacoesRanking =
                AvaliacaoRanking::whereIn('Id_Campo', $campos)->whereIn('AnoAvaliacao', $anos)
                    ->orderBy('EscolaNome')->get();

            $avaliacoesRankingGrouped = $avaliacoesRanking->groupBy('Id_Campo');

            $pdf = FacadePdf::loadView('reportAvaliacaoRanking',
                [
                    'avaliacoesRankingGrouped' => $avaliacoesRankingGrouped,
                ]);

            $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'debugPng' => true, 'chroot' => "/"]);

            return $pdf->setPaper('a4')->stream('Ranking_' . implode('-', $campos) . '_' . implode('-', $anos) . '.pdf');
        }
    }
}
