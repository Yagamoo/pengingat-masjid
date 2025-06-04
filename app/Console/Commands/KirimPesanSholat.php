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
            $jadwal = $this->getJadwalSholat($orang->kabupaten->api_id, Carbon::now()->toDateString());
            if (!$jadwal) {
                continue;
            }
            
            foreach (['imsak', 'subuh', 'terbit', 'dhuha', 'dzuhur', 'ashar', 'maghrib', 'isya'] as $waktu) {
                $jamSholat = Carbon::parse($jadwal[$waktu]);
                $jamSholatString = $jamSholat->format('H:i');
                $sebelum10Menit = $jamSholat->copy()->subMinutes(15)->format('H:i');
                
                $pesan = Pesan::where('waktu', $waktu)->where('aktif', true)->first();
                if (!$pesan) {
                    continue;
                }
                
                // Kirim pesan 10 menit sebelum waktu sholat
                if ($now === $sebelum10Menit && !empty($pesan->pesan_sebelum)) {
                    $pesanSiap = $this->gantiPlaceholder($pesan->pesan_sebelum, $waktu, $jadwal, $orang);
                    $this->sendNotification($orang->no_hp, $pesanSiap);
                }

                // Kirim pesan saat waktu sholat tiba
                if ($now === $jamSholatString && !empty($pesan->pesan)) {
                    $pesanSiap = $this->gantiPlaceholder($pesan->pesan, $waktu, $jadwal, $orang);
                    $this->sendNotification($orang->no_hp, $pesanSiap);
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

    private function gantiPlaceholder($template, $waktu, $jadwal, $orang)
    {
        $replace = [
            '{{waktu}}' => ucfirst($waktu),
            '{{lokasi}}' => $orang->kabupaten->nama ?? 'wilayah Anda',
            '{{subuh}}' => $jadwal['subuh'],
            '{{dzuhur}}' => $jadwal['dzuhur'],
            '{{ashar}}' => $jadwal['ashar'],
            '{{maghrib}}' => $jadwal['maghrib'],
            '{{isya}}' => $jadwal['isya'],
        ];

        $pesan = strtr($template, $replace);

        // Ganti <br> atau <br/> jadi newline \n supaya di WA rapi
        $pesan = preg_replace('/<br\s*\/?>/i', "\n", $pesan);

        // Jika ada tag HTML lain, bisa ditambahkan sanitasi atau di-strip tags
        $pesan = strip_tags($pesan);

        return $pesan;
    }

    private function sendNotification($nowa, $pesan)
    {
        $token = 'LWk3d6eTgBZurFgZdKyu'; // Ganti token Fonnte kamu
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
