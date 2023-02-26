<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = User::query()->findOrFail(1);
        $admin = User::query()->findOrFail(2);

        $superadmin->roles()->sync(1);
        $admin->roles()->sync(2);
    }
}
