<?php

namespace App\Jobs;

use App\Models\Donasi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckExpiredTransactionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $expired = Donasi::where('tenggat_waktu', '<=', now())->get();

        foreach ($expired as $transaction) {
            $transaction->status = 'Declined';
            $transaction->isProcessed = 'True';
            $transaction->save();
        }
    }
}
