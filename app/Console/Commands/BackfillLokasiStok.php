<?php

namespace App\Console\Commands;

use App\Models\LokasiStok;
use App\Models\VarianProduk;
use Illuminate\Console\Command;

class BackfillLokasiStok extends Command
{
    protected $signature = 'lokasi-stok:backfill';
    protected $description = 'Isi tabel lokasi_stoks dari data rak_id + stok_varian yang sudah ada di varian_produks';

    public function handle()
    {
        $varianProduks = VarianProduk::whereNotNull('rak_id')->where('stok_varian', '>', 0)->get();

        if ($varianProduks->isEmpty()) {
            $this->info('Tidak ada data varian dengan rak & stok untuk dimigrasikan.');
            return Command::SUCCESS;
        }

        $this->info("Memigrasikan {$varianProduks->count()} varian ke tabel lokasi_stoks...");
        $bar = $this->output->createProgressBar($varianProduks->count());
        $bar->start();

        foreach ($varianProduks as $varian) {
            LokasiStok::updateOrCreate(
                ['varian_produk_id' => $varian->id, 'rak_id' => $varian->rak_id],
                ['qty' => $varian->stok_varian]
            );
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info('Selesai! Data lokasi stok sudah terisi sesuai rak utama masing-masing varian.');

        return Command::SUCCESS;
    }
}
