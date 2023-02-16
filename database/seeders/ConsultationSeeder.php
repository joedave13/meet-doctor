<?php

namespace Database\Seeders;

use App\Models\Consultation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConsultationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $consultations = [
            [
                'name' => 'Jantung Sesak',
                'level' => 1,
                'fee' => 100
            ],
            [
                'name' => 'Penyakit Kulit',
                'level' => 2,
                'fee' => 250
            ],
            [
                'name' => 'Masalah Tekanan Darah',
                'level' => 1,
                'fee' => 150
            ],
            [
                'name' => 'Penyakit Mata',
                'level' => 2,
                'fee' => 300
            ],
            [
                'name' => 'Penyakit Gigi',
                'level' => 3,
                'fee' => 450
            ]
        ];

        foreach ($consultations as $key => $value) {
            Consultation::query()->create($value);
        }
    }
}
