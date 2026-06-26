<?php

namespace App\Console\Commands;

use App\Models\Rak;
use App\Models\VarianProduk;
use Illuminate\Console\Command;

class SyncRakCapacity extends Command
{
    protected $signature = 'rak:sync-capacity';
    protected $description = 'Sinkronkan kapasitas_terpakai di setiap rak berdasarkan stok_varian aktual';

    public function handle()
    {
        $this->info('Mereset kapasitas_terpakai semua rak ke 0...');
        Rak::query()->update(['kapasitas_terpakai' => 0]);

        $this->info('Menghitung ulang berdasarkan stok varian saat ini...');

        $totals = VarianProduk::whereNotNull('rak_id')
            ->selectRaw('rak_id, SUM(stok_varian) as total_stok')
            ->groupBy('rak_id')
            ->get();

        $bar = $this->output->createProgressBar($totals->count());
        $bar->start();

        foreach ($totals as $row) {
            Rak::where('id', $row->rak_id)->update(['kapasitas_terpakai' => $row->total_stok]);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info('Selesai! Kapasitas rak sudah disinkronkan dengan stok aktual.');

        return Command::SUCCESS;
    }
}
