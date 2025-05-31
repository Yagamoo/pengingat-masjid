<?php

namespace Database\Seeders;

use App\Models\Kabupaten;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $response = Http::get('https://api.myquran.com/v2/sholat/kota/semua');
        foreach ($response->json()['data'] as $kota) {
            Kabupaten::updateOrCreate(
                ['api_id' => $kota['id']],
                ['nama' => $kota['lokasi']]
            );
        }

        $this->call([PesanSeeder::class]);
        $this->call([MasyarakatSeeder::class]);
    }
}
