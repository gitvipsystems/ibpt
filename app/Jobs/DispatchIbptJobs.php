<?php

namespace App\Jobs;

use App\Jobs\IbptJob;
use App\Models\Ncm;
use App\Models\Cnpj;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DispatchIbptJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $priority = 3;

    protected $descricao;
    protected $unidadeMedida;
    protected $valor;
    protected $gtin;

    public function __construct($descricao, $unidadeMedida, $valor, $gtin)
    {
        $this->descricao = $descricao;
        $this->unidadeMedida = $unidadeMedida;
        $this->valor = $valor;
        $this->gtin = $gtin;
    }

    public function handle()
    {
        // Obter o CNPJ mais recente
        $cnpj = Cnpj::latest()->first()->cnpj;
        $token = Cnpj::latest()->first()->token;

        // Lista de NCMs
        $ncms = Ncm::pluck('ncm')->toArray();

        // Lista de UF
        $ufs = [
            'AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA',
            'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN',
            'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'
        ];

        // Tamanho do lote
        $batchSize = 5; // Define o tamanho do lote

        // Dividindo a lista de NCMs em lotes menores
        $ncmsBatches = array_chunk($ncms, $batchSize);

        // Loop para chamar o job para cada lote de NCMs e UF
        foreach ($ncmsBatches as $ncmsBatch) {
            foreach ($ufs as $uf) {
                // Despacha o job IbptJob com os dados fixos de NCM e UF e os outros parâmetros variáveis
                foreach ($ncmsBatch as $codigo) {
                    IbptJob::dispatch($cnpj, $token, $codigo, $uf, '0', $this->descricao, $this->unidadeMedida, $this->valor, $this->gtin)->onQueue('low');
                }
            }
        }
    }
}
