<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'complex administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'booking agent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'registered user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('roles')->insert($roles);
    }
}
