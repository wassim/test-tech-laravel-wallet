<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Actions\PerformRecurringTransfer;
use App\Enums\RecurringTransferStatus;
use App\Models\RecurringTransfer;
use Exception;
use Illuminate\Console\Command;

class ProcessRecurringTransfers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-recurring-transfers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process all recurring transfers';

    /**
     * Execute the console command.
     */
    public function handle(PerformRecurringTransfer $performRecurringTransfer)
    {
        $this->info('Processing recurring transfers…');

        $now = now();
        $dueTransfers = RecurringTransfer::where('status', RecurringTransferStatus::ACTIVE)
            ->where('next_execution', '<=', $now)
            ->get();

        foreach ($dueTransfers as $transfer) {
            try {
                $performRecurringTransfer->execute($transfer);
            } catch (Exception $e) {
                $this->error("Error processing recurring transfer #{$transfer->id}: {$e->getMessage()}");
            }
        }

        $this->info('Finished processing recurring transfers!');
    }
}
