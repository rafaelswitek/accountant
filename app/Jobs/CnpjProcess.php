<?php

namespace App\Jobs;

use App\Models\Company;
use App\Services\CnpjWsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CnpjProcess implements ShouldQueue
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
        $current = null;
        $result = null;
        try {
            $api = new CnpjWsService();
            $companies = Company::whereNull('email')
                ->whereNull('phone')
                ->limit(100)
                ->get();

            foreach ($companies as $company) {
                $current = $company->document;
                $result = $api->get($company->document);
                $company->updateFromCNPJWS($result);
            }
        } catch (\Exception $e) {
            Log::error('[JOB][CnpjProcess]: ', ['message' => $e->getMessage(), 'current' => $current, 'result' => $result]);
        }
    }
}
