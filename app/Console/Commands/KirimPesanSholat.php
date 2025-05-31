<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Attributes\AsScheduled;
use Illuminate\Support\Facades\Http;
use App\Models\Masyarakat;
use App\Models\Pesan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

// #[AsScheduled(frequency: 'everyMinute')]
class KirimPesanSholat extends Command
{
    protected $signature = 'pesan:sholat';
    protected $description = 'Mengirim pesan WhatsApp ke masyarakat sesuai waktu sholat.';

    public function handle()
    {
        $masyarakatList = Masyarakat::all();
        Carbon::setLocale('id');
        $now = Carbon::now()->format('H:i');

        foreach ($masyarakatList as $orang) {
            $jadwal = $this->getJadwalSholat($orang->kabupaten->api_id, now()->toDateString());
            if (!$jadwal)
                continue;

            foreach (['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya'] as $waktu) {
                $jamSholat = Carbon::parse($jadwal[$waktu]);
                $jamSholatString = $jamSholat->format('H:i');
                $sebelum10Menit = $jamSholat->copy()->subMinutes(10)->format('H:i');

                $pesan = Pesan::where('waktu', $waktu)->where('aktif', true)->first();
                if (!$pesan)
                    continue;

                if ($now == $sebelum10Menit && $pesan->pesan_sebelum) {
                    $this->sendNotification($orang->no_hp, $pesan->pesan_sebelum);
                } elseif ($now == $jamSholatString && $pesan->pesan_masuk) {
                    $this->sendNotification($orang->no_hp, $pesan->pesan_masuk);
                }
            }
        }
    }

    private function getJadwalSholat($kotaKode, $tanggal)
    {
        $date = Carbon::parse($tanggal);
        $url = "https://api.myquran.com/v2/sholat/jadwal/{$kotaKode}/{$date->year}/{$date->format('m')}/{$date->format('d')}";

        $response = Http::get($url);
        return $response->successful() ? $response->json()['data']['jadwal'] ?? null : null;
    }

    private function sendNotification($nowa, $pesan)
    {
        $token = '##tZKBP_Dp_gHypkBQVJ'; // Ganti token Fonnte kamu
        $response = Http::withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/send', [
                    'target' => $nowa,
                    'message' => $pesan,
                ]);

        if ($response->successful()) {
            $this->info('✅ Notifikasi terkirim ke ' . $nowa);
        } else {
            $this->error('❌ Gagal mengirim ke ' . $nowa . ': ' . $response->body());
        }
    }
}
