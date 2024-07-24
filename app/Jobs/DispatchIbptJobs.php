<?php

namespace App\Jobs;

use App\Jobs\IbptJob;
use App\Models\Ncm;
use App\Models\Cnpj;
use Illuminate\Support\Facades\Log; // Importa a classe Log
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
        // Adiciona log para o início da execução
        Log::info('DispatchIbptJobs started', [
            'descricao' => $this->descricao,
            'unidadeMedida' => $this->unidadeMedida,
            'valor' => $this->valor,
            'gtin' => $this->gtin
        ]);

        // Obter o CNPJ mais recente
        $cnpj = Cnpj::latest()->first()->cnpj;
        $token = Cnpj::latest()->first()->token;

        // Lista de NCMs
        $ncms = Ncm::pluck('ncm')->toArray();
        Log::info('NCMs retrieved', ['ncms' => $ncms]);

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
        Log::info('NCMs batches created', ['ncmsBatches' => $ncmsBatches]);

        // Loop para chamar o job para cada lote de NCMs e UF
        foreach ($ncmsBatches as $ncmsBatch) {
            foreach ($ufs as $uf) {
                // Despacha o job IbptJob com os dados fixos de NCM e UF e os outros parâmetros variáveis
                foreach ($ncmsBatch as $codigo) {
                    Log::info('Dispatching IbptJob', [
                        'cnpj' => $cnpj,
                        'token' => $token,
                        'codigo' => $codigo,
                        'uf' => $uf,
                        'descricao' => $this->descricao,
                        'unidadeMedida' => $this->unidadeMedida,
                        'valor' => $this->valor,
                        'gtin' => $this->gtin
                    ]);
                    
                    IbptJob::dispatch($cnpj, $token, $codigo, $uf, '0', $this->descricao, $this->unidadeMedida, $this->valor, $this->gtin)->onQueue('low');
                }
            }
        }

        // Adiciona log para o final da execução
        Log::info('DispatchIbptJobs completed');
    }
}
