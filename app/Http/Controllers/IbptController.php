<?php

namespace App\Http\Controllers;

use App\Jobs\DispatchIbptJobs;
use App\Jobs\IbptJob;
use Dotenv\Dotenv;
use Illuminate\Http\Request;

class IbptController extends Controller
{

    public function dispatchUniqueIbptJob(Request $request)
    {
        $cnpj = $request->input('cnpj');
        $token = $request->input('token');
        $codigo = $request->input('codigo');
        $uf = $request->input('uf');
        $ex = $request->input('ex');
        $descricao = $request->input('descricao');
        $unidadeMedida = $request->input('unidadeMedida');
        $valor = $request->input('valor');
        $gtin = $request->input('gtin');

        IbptJob::dispatch($cnpj, $codigo, $uf, $ex, $descricao, $unidadeMedida, $valor, $gtin);

        return response()->json(['message' => 'Job dispatched successfully']);
    }
    public function dispatchIbptJob(Request $request)
    {
        $descricao = $request->input('descricao');
        $unidadeMedida = $request->input('unidadeMedida');
        $valor = $request->input('valor');
        $gtin = $request->input('gtin');

        DispatchIbptJobs::dispatch($descricao, $unidadeMedida, $valor, $gtin)->onQueue('high');

        return response()->json(['message' => 'Jobs dispatched successfully']);
    }
}
