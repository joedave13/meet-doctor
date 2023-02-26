<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = User::query()->findOrFail(1);

        $superadmin_detail = new UserDetail;
        $superadmin_detail->user_id = $superadmin->id;
        $superadmin_detail->user_type_id = 1;

        $superadmin_detail->save();

        $admin = User::query()->findOrFail(2);

        $admin_detail = new UserDetail;
        $admin_detail->user_id = $admin->id;
        $admin_detail->user_type_id = 1;

        $admin_detail->save();
    }
}
