<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Discount;

class ExpireDiscounts extends Command
{
    protected $signature = 'discounts:expire';

    protected $description = 'Menonaktifkan diskon yang sudah melewati tanggal berakhir';

    public function handle()
    {
        $today = now()->toDateString();

        $expiredCount = Discount::where('status', 'Aktif')
            ->whereDate('tanggal_berakhir', '<', $today)
            ->update([
                'status' => 'Nonaktif'
            ]);

        $this->info(
            $expiredCount .
            ' diskon berhasil dinonaktifkan karena sudah berakhir.'
        );

        return Command::SUCCESS;
    }
}