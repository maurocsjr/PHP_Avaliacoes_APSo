<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('get-avaliacoes/{id}', [ReportController::class, 'getAvaliacao']);
Route::get('get-avaliacoes/{id}/secao/{idSecao}', [ReportController::class, 'getAvaliacaoPorSecao']);

Route::get('get-avaliacoes-ranking', function (Request $request, ReportController $reportController) {
    $campos = $request->query('campos');
    $anos = $request->query('anos');
    return $reportController->getReportAvaliacaoRanking($campos, $anos);
});
