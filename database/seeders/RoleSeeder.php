<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Superadmin'
            ],
            [
                'name' => 'Admin'
            ],
            [
                'name' => 'Hospital Staff'
            ],
            [
                'name' => 'Doctor'
            ],
            [
                'name' => 'Patient'
            ]
        ];

        foreach ($roles as $key => $value) {
            Role::query()->create($value);
        }
    }
}
