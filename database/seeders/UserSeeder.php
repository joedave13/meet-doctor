<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Superadmin',
                'email' => 'superadmin@meetdoctor.test',
                'password' => Hash::make('12345'),
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@meetdoctor.test',
                'password' => Hash::make('12345')
            ]
        ];

        foreach ($users as $key => $value) {
            User::query()->create($value);
        }
    }
}
