<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userTypes = [
            [
                'name' => 'Admin',
            ],
            [
                'name' => 'Doctor',
            ],
            [
                'name' => 'Patient'
            ]
        ];

        foreach ($userTypes as $key => $value) {
            UserType::query()->create($value);
        }
    }
}
