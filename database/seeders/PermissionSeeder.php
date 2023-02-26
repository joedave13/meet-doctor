<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'dashboard_access'
            ],
            [
                'name' => 'user_access',
            ],
            [
                'name' => 'user_table',
            ],
            [
                'name' => 'user_create',
            ],
            [
                'name' => 'user_show',
            ],
            [
                'name' => 'user_edit',
            ],
            [
                'name' => 'user_delete',
            ],
            [
                'name' => 'permission_access',
            ],
            [
                'name' => 'permission_table',
            ],
            [
                'name' => 'role_access',
            ],
            [
                'name' => 'role_table',
            ],
            [
                'name' => 'role_create',
            ],
            [
                'name' => 'role_show',
            ],
            [
                'name' => 'role_edit',
            ],
            [
                'name' => 'role_delete',
            ],
            [
                'name' => 'user_type_access',
            ],
            [
                'name' => 'user_type_table',
            ],
            [
                'name' => 'specialist_access',
            ],
            [
                'name' => 'specialist_table',
            ],
            [
                'name' => 'specialist_create',
            ],
            [
                'name' => 'specialist_show',
            ],
            [
                'name' => 'specialist_edit',
            ],
            [
                'name' => 'specialist_delete',
            ],
            [
                'name' => 'consultation_access',
            ],
            [
                'name' => 'consultation_table',
            ],
            [
                'name' => 'consultation_create',
            ],
            [
                'name' => 'consultation_show',
            ],
            [
                'name' => 'consultation_edit',
            ],
            [
                'name' => 'consultation_delete',
            ],
            [
                'name' => 'doctor_access',
            ],
            [
                'name' => 'doctor_table',
            ],
            [
                'name' => 'doctor_create',
            ],
            [
                'name' => 'doctor_show',
            ],
            [
                'name' => 'doctor_edit',
            ],
            [
                'name' => 'doctor_delete',
            ],
            [
                'name' => 'patient_access',
            ],
            [
                'name' => 'patient_table',
            ],
            [
                'name' => 'appointment_access',
            ],
            [
                'name' => 'appointment_table',
            ],
            [
                'name' => 'appointment_show',
            ],
            [
                'name' => 'appointment_export',
            ],
            [
                'name' => 'payment_access',
            ],
            [
                'name' => 'payment_table',
            ],
            [
                'name' => 'payment_show',
            ],
            [
                'name' => 'payment_export',
            ],
        ];

        foreach ($permissions as $key => $value) {
            Permission::query()->create($value);
        }
    }
}
