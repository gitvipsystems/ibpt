<?php

namespace App\Jobs;

use App\Models\Ibpt;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class IbptJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $cnpj;
    protected $token;
    protected $codigo;
    protected $uf;
    protected $ex;
    protected $descricao;
    protected $unidadeMedida;
    protected $valor;
    protected $gtin;

    public $tries = 10;
    public $timeout = 300;

    public function __construct($cnpj, $token, $codigo, $uf, $ex, $descricao, $unidadeMedida, $valor, $gtin)
    {
        $this->cnpj = $cnpj;
        $this->token = $token;
        $this->codigo = $codigo;
        $this->uf = $uf;
        $this->ex = $ex;
        $this->descricao = $descricao;
        $this->unidadeMedida = $unidadeMedida;
        $this->valor = $valor;
        $this->gtin = $gtin;
    }

    public function handle()
    {
        $response = Http::get('https://apidoni.ibpt.org.br/api/v1/produtos', [
            'token' => $this->token,
            'cnpj' => $this->cnpj,
            'codigo' => $this->codigo,
            'uf' => $this->uf,
            'ex' => $this->ex,
            'descricao' => $this->descricao,
            'unidadeMedida' => $this->unidadeMedida,
            'valor' => $this->valor,
            'gtin' => $this->gtin,
        ]);

        if ($response->successful()) {
            $produtoData = $response->json();

            $vigenciaInicio = Carbon::createFromFormat('d/m/Y', $produtoData['VigenciaInicio'])->format('Y-m-d');
            $vigenciaFim = Carbon::createFromFormat('d/m/Y', $produtoData['VigenciaFim'])->format('Y-m-d');

            Ibpt::updateOrCreate(
                [
                    'codigo' => $produtoData['Codigo'],
                    'uf' => $produtoData['UF']
                ],
                [
                    'descricao' => $produtoData['Descricao'],
                    'nacional' => $produtoData['Nacional'],
                    'estadual' => $produtoData['Estadual'],
                    'importado' => $produtoData['Importado'],
                    'municipal' => $produtoData['Municipal'],
                    'tipo' => $produtoData['Tipo'],
                    'vigencia_inicio' => $vigenciaInicio,
                    'vigencia_fim' => $vigenciaFim,
                    'chave' => $produtoData['Chave'],
                    'versao' => $produtoData['Versao'],
                    'fonte' => $produtoData['Fonte'],
                    'valor' => $produtoData['Valor'],
                    'valor_tributo_nacional' => $produtoData['ValorTributoNacional'],
                    'valor_tributo_estadual' => $produtoData['ValorTributoEstadual'],
                    'valor_tributo_importado' => $produtoData['ValorTributoImportado'],
                    'valor_tributo_municipal' => $produtoData['ValorTributoMunicipal'],
                ]
            );
        }
    }
}
