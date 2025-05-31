<?php

namespace Database\Seeders;

use App\Models\Pesan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PesanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $waktuSholat = [
            'subuh' => [
                'pesan' => 'Waktunya sholat Subuh. Ayo tunaikan sholat Subuh tepat waktu!',
                'pesan_sebelum' => '10 menit lagi menuju waktu sholat Subuh. Siapkan diri untuk beribadah.'
            ],
            'dzuhur' => [
                'pesan' => 'Sudah masuk waktu sholat Dzuhur. Jangan lupa sholat ya!',
                'pesan_sebelum' => '10 menit lagi menuju waktu Dzuhur. Yuk, bersiap-siap.'
            ],
            'ashar' => [
                'pesan' => 'Waktu sholat Ashar telah tiba. Ayo kita sholat Ashar.',
                'pesan_sebelum' => '10 menit lagi menjelang waktu Ashar. Jangan lupa ya.'
            ],
            'maghrib' => [
                'pesan' => 'Sudah waktunya sholat Maghrib. Ayo kita laksanakan!',
                'pesan_sebelum' => '10 menit lagi menuju Maghrib. Persiapkan diri untuk sholat.'
            ],
            'isya' => [
                'pesan' => 'Masuk waktu sholat Isya. Mari kita sholat Isya bersama.',
                'pesan_sebelum' => '10 menit lagi waktu Isya. Yuk siap-siap.'
            ],
        ];

        foreach ($waktuSholat as $waktu => $pesan) {
            Pesan::updateOrCreate(
                ['waktu' => $waktu],
                [
                    'aktif' => true,
                    'pesan' => $pesan['pesan'],
                    'pesan_sebelum' => $pesan['pesan_sebelum'],
                ]
            );
        }
    }
}
