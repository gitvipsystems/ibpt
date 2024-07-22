<?php

namespace App\Console\Commands;

use App\Models\Ibpt;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Jobs\DispatchIbptJobs;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckAndDispatchIbptJobs extends Command
{
    protected $signature = 'check:dispatch-ibpt-jobs';
    protected $description = 'Check vigencia_fim and dispatch IBPT jobs if expired';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Log::info('CheckAndDispatchIbptJobs command started.');

        $firstRecord = Ibpt::orderBy('vigencia_fim', 'asc')->first();

        if ($firstRecord && Carbon::parse($firstRecord->vigencia_fim)->isPast()) {
            $descricao = "Camiseta de algodão";
            $unidadeMedida = "UN";
            $valor = "50";
            $gtin = "12345678901234";

            DispatchIbptJobs::dispatch($descricao, $unidadeMedida, $valor, $gtin)->onQueue('high');

            Log::info('Jobs dispatched successfully.');
            $this->info('Jobs dispatched successfully.');
        } else {
            Log::info('No jobs dispatched. Vigencia_fim is not expired.');
            $this->info('No jobs dispatched. Vigencia_fim is not expired.');
        }

        Log::info('CheckAndDispatchIbptJobs command finished.');
    }
}
