<?php

namespace App\Jobs;

use App\Models\Accountancy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AccountancyProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private array $data, 
        private int $offset, 
        private int $batchSize
    )
    {
        Log::channel('accountancy')->info('Init', ['offset' => $this->offset, 'batchSize' => $this->batchSize]);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Accountancy::storeFromCFC($this->data);
        Log::channel('accountancy')->info('End', ['offset' => $this->offset, 'batchSize' => $this->batchSize]);
    }
}
