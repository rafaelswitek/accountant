<?php

namespace App\Jobs;

use App\Models\Accountant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AccountantProcess implements ShouldQueue
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
        Log::channel('accountant')->info('Init', ['offset' => $this->offset, 'batchSize' => $this->batchSize]);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Accountant::storeFromCFC($this->data);
        Log::channel('accountant')->info('End', ['offset' => $this->offset, 'batchSize' => $this->batchSize]);
    }
}
