<?php

namespace Database\Seeders;

use App\Models\Specialist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specialists = [
            [
                'name' => 'Dermatology'
            ],
            [
                'name' => 'Neurology'
            ],
            [
                'name' => 'Dentist'
            ],
            [
                'name' => 'Allergist'
            ],
            [
                'name' => 'Cardiologist'
            ]
        ];

        foreach ($specialists as $key => $value) {
            Specialist::query()->create($value);
        }
    }
}
