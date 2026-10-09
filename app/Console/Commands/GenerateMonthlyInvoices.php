<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use App\Models\Invoice;
use Carbon\Carbon;

class GenerateMonthlyInvoices extends Command
{
    protected $signature = 'invoices:generate';
    protected $description = 'Generate tagihan bulanan secara otomatis untuk seluruh penghuni aktif';

    public function handle()
    {
        $now = Carbon::now();
        $activeTenants = Tenant::where('is_active', true)->with('room')->get();
        $generatedCount = 0;

        foreach ($activeTenants as $tenant) {
            $existingInvoice = Invoice::where('tenant_id', $tenant->id)
                ->where('period_month', $now->month)
                ->where('period_year', $now->year)
                ->exists();

            if (!$existingInvoice) {
                Invoice::create([
                    'tenant_id' => $tenant->id,
                    'room_id' => $tenant->room_id,
                    'period_month' => $now->month,
                    'period_year' => $now->year,
                    'amount' => $tenant->room->price,
                    'due_date' => $now->copy()->day(10)->toDateString(),
                    'status' => 'unpaid',
                ]);
                $generatedCount++;
            }
        }

        $this->info("Berhasil membuat {$generatedCount} tagihan untuk periode {$now->format('F Y')}.");
    }
}