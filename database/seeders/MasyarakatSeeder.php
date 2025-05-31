<?php

namespace Database\Seeders;

use App\Models\Kabupaten;
use App\Models\Masyarakat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasyarakatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada kabupaten di database
        $kabupaten = Kabupaten::first();

        if (!$kabupaten) {
            $this->command->warn('Seeder batal: tidak ada data kabupaten di tabel kabupaten.');
            return;
        }

        $masyarakatList = [
            [
                'nama' => 'Muh. Iqbal Nur Pamungkas',
                'no_hp' => '089603336375',
                'gender' => 'L',
                'id_kabupaten' => 91,
            ],
            [
                'nama' => 'Jihan Cindaga',
                'no_hp' => '085869278611',
                'gender' => 'P',
                'id_kabupaten' => 91,
            ],
            [
                'nama' => 'Wahyuni Nur Hidayat',
                'no_hp' => '083866056693',
                'gender' => 'P',
                'id_kabupaten' => 91,
            ],
            [
                'nama' => 'Affan',
                'no_hp' => '085161666808',
                'gender' => 'L',
                'id_kabupaten' => 92,
            ],
        ];

        foreach ($masyarakatList as $data) {
            Masyarakat::updateOrCreate(
                ['no_hp' => $data['no_hp']], // agar tidak duplicate
                $data
            );
        }
    }
}
