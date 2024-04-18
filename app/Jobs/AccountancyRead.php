<?php

namespace App\Jobs;

use App\Services\ReadTXTService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AccountancyRead implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $txtService = new ReadTXTService();
        $result = $txtService->readFile('app/contabilidades.txt');

        $batchSize = 100;
        $totalCount = count($result['data']);
        $numBatches = ceil($totalCount / $batchSize);

        for ($i = 0; $i < $numBatches; $i++) {
            $offset = $i * $batchSize;
            $batch = array_slice($result['data'], $offset, $batchSize);

            AccountancyProcess::dispatch($batch, $offset, $batchSize)->delay(now()->addMinutes(1));
        }
    }
}
