<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingObjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $objects = [
            [
                'name' => 'test',
                'description' => 'test',
                'price' => 1000,
                'photos' => 'test',
                'preview_photo' => 'test',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('booking_objects')->insert($objects);
    }
}
