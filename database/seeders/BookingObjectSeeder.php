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
        $bungaloNameUa = json_decode(file_get_contents(base_path('lang/ua.json')), true)['booking_objects']['seeders']['bungalo_name'];
        $bungaloNameEn = json_decode(file_get_contents(base_path('lang/en.json')), true)['booking_objects']['seeders']['bungalo_name'];

        $littleCottageNameUa = json_decode(file_get_contents(base_path('lang/ua.json')), true)['booking_objects']['seeders']['little_cottage_name'];
        $littleCottageNameEn = json_decode(file_get_contents(base_path('lang/en.json')), true)['booking_objects']['seeders']['little_cottage_name'];

        $bigCottageNameUa = json_decode(file_get_contents(base_path('lang/ua.json')), true)['booking_objects']['seeders']['big_cottage_name'];
        $bigCottageNameEn = json_decode(file_get_contents(base_path('lang/en.json')), true)['booking_objects']['seeders']['big_cottage_name'];

        $bedNameUa = json_decode(file_get_contents(base_path('lang/ua.json')), true)['booking_objects']['seeders']['bed_name'];
        $bedNameEn = json_decode(file_get_contents(base_path('lang/en.json')), true)['booking_objects']['seeders']['bed_name'];

        $sunbedNameUa = json_decode(file_get_contents(base_path('lang/ua.json')), true)['booking_objects']['seeders']['sunbed_name'];
        $sunbedNameEn = json_decode(file_get_contents(base_path('lang/en.json')), true)['booking_objects']['seeders']['sunbed_name'];

        $secondBungaloDescriptionUa = json_decode(file_get_contents(base_path('lang/ua.json')), true)['booking_objects']['seeders']['second_bungalo_description'];
        $secondBungaloDescriptionEn = json_decode(file_get_contents(base_path('lang/en.json')), true)['booking_objects']['seeders']['second_bungalo_description'];

        $bungaloDescriptionUa = json_decode(file_get_contents(base_path('lang/ua.json')), true)['booking_objects']['seeders']['bungalo_description'];
        $bungaloDescriptionEn = json_decode(file_get_contents(base_path('lang/en.json')), true)['booking_objects']['seeders']['bungalo_description'];

        $littleCottageDescriptionUa = json_decode(file_get_contents(base_path('lang/ua.json')), true)['booking_objects']['seeders']['little_cottage_description'];
        $littleCottageDescriptionEn = json_decode(file_get_contents(base_path('lang/en.json')), true)['booking_objects']['seeders']['little_cottage_description'];
        
        $bigCottageDescriptionUa = json_decode(file_get_contents(base_path('lang/ua.json')), true)['booking_objects']['seeders']['big_cottage_description'];
        $bigCottageDescriptionEn = json_decode(file_get_contents(base_path('lang/en.json')), true)['booking_objects']['seeders']['big_cottage_description'];

        $bedDescriptionUa = json_decode(file_get_contents(base_path('lang/ua.json')), true)['booking_objects']['seeders']['bed_description'];
        $bedDescriptionEn = json_decode(file_get_contents(base_path('lang/en.json')), true)['booking_objects']['seeders']['bed_description'];

        $sunbedDescriptionUa = json_decode(file_get_contents(base_path('lang/ua.json')), true)['booking_objects']['seeders']['sunbed_description'];
        $sunbedDescriptionEn = json_decode(file_get_contents(base_path('lang/en.json')), true)['booking_objects']['seeders']['sunbed_description'];

        $objects = [
            [
                'name_ua' => $bungaloNameUa . '№2',
                'name_en' => $bungaloNameEn . '№2',
                'description_ua' => $secondBungaloDescriptionUa,
                'description_en' => $secondBungaloDescriptionEn,
                'zone' => 'bungalow',
                'type' => 'second bungalow',
                'max_persons' => null,
            ],
            [
                'name_ua' => $bungaloNameUa . '№3',
                'name_en' => $bungaloNameEn . '№3',
                'description_ua' => $bungaloDescriptionUa,
                'description_en' => $bungaloDescriptionEn,
                'zone' => 'bungalow',
                'type' => 'bungalow',
                'max_persons' => null,
            ],
            [
                'name_ua' => $bungaloNameUa . '№4',
                'name_en' => $bungaloNameEn . '№4',
                'description_ua' => $bungaloDescriptionUa,
                'description_en' => $bungaloDescriptionEn,
                'zone' => 'bungalow',
                'type' => 'bungalow',
                'max_persons' => null,
            ],
            [
                'name_ua' => $bungaloNameUa . '№5',
                'name_en' => $bungaloNameEn . '№5',
                'description_ua' => $bungaloDescriptionUa,
                'description_en' => $bungaloDescriptionEn,
                'zone' => 'bungalow',
                'type' => 'bungalow',
                'max_persons' => null,
            ],
            [
                'name_ua' => $bungaloNameUa . '№6',
                'name_en' => $bungaloNameEn . '№6',
                'description_ua' => $bungaloDescriptionUa,
                'description_en' => $bungaloDescriptionEn,
                'zone' => 'bungalow',
                'type' => 'bungalow',
                'max_persons' => null,
            ],
            [
                'name_ua' => $littleCottageNameUa . '№7',
                'name_en' => $littleCottageNameEn . '№7',
                'description_ua' => $littleCottageDescriptionUa,
                'description_en' => $littleCottageDescriptionEn,
                'zone' => 'cottages',
                'type' => 'little cottage',
                'max_persons' => 4,
            ],
            [
                'name_ua' => $littleCottageNameUa . '№8',
                'name_en' => $littleCottageNameEn . '№8',
                'description_ua' => $littleCottageDescriptionUa,
                'description_en' => $littleCottageDescriptionEn,
                'zone' => 'cottages',
                'type' => 'little cottage',
                'max_persons' => 4,
            ],
            [
                'name_ua' => $littleCottageNameUa . '№9',
                'name_en' => $littleCottageNameEn . '№9',
                'description_ua' => $littleCottageDescriptionUa,
                'description_en' => $littleCottageDescriptionEn,
                'zone' => 'cottages',
                'type' => 'little cottage',
                'max_persons' => 4,
            ],
            [
                'name_ua' => $littleCottageNameUa . '№10',
                'name_en' => $littleCottageNameEn . '№10',
                'description_ua' => $littleCottageDescriptionUa,
                'description_en' => $littleCottageDescriptionEn,
                'zone' => 'cottages',
                'type' => 'little cottage',
                'max_persons' => 4,
            ],
            [
                'name_ua' => $bigCottageNameUa . '№11',
                'name_en' => $bigCottageNameEn . '№11',
                'description_ua' => $bigCottageDescriptionUa,
                'description_en' => $bigCottageDescriptionEn,
                'zone' => 'cottages',
                'type' => 'big cottage',
                'max_persons' => 4,
            ],
            [
                'name_ua' => $bigCottageNameUa . '№12',
                'name_en' => $bigCottageNameEn . '№12',
                'description_ua' => $bigCottageDescriptionUa,
                'description_en' => $bigCottageDescriptionEn,
                'zone' => 'cottages',
                'type' => 'big cottage',
                'max_persons' => 4,
            ],
            [
                'name_ua' => $bigCottageNameUa . '№13',
                'name_en' => $bigCottageNameEn . '№13',
                'description_ua' => $bigCottageDescriptionUa,
                'description_en' => $bigCottageDescriptionEn,
                'zone' => 'cottages',
                'type' => 'big cottage',
                'max_persons' => 4,
            ],
            [
                'name_ua' => $bigCottageNameUa . '№14',
                'name_en' => $bigCottageNameEn . '№14',
                'description_ua' => $bigCottageDescriptionUa,
                'description_en' => $bigCottageDescriptionEn,
                'zone' => 'cottages',
                'type' => 'big cottage',
                'max_persons' => 4,
            ],
            [
                'name_ua' => $bigCottageNameUa . '№15',
                'name_en' => $bigCottageNameEn . '№15',
                'description_ua' => $bigCottageDescriptionUa,
                'description_en' => $bigCottageDescriptionEn,
                'zone' => 'cottages',
                'type' => 'big cottage',
                'max_persons' => 4,
            ],
            [
                'name_ua' => $bigCottageNameUa . '№16',
                'name_en' => $bigCottageNameEn . '№16',
                'description_ua' => $bigCottageDescriptionUa,
                'description_en' => $bigCottageDescriptionEn,
                'zone' => 'cottages',
                'type' => 'big cottage',
                'max_persons' => 4,
            ],
            [
                'name_ua' => $bigCottageNameUa . '№17',
                'name_en' => $bigCottageNameEn . '№17',
                'description_ua' => $bigCottageDescriptionUa,
                'description_en' => $bigCottageDescriptionEn,
                'zone' => 'cottages',
                'type' => 'big cottage',
                'max_persons' => 4,
            ],
            [
                'name_ua' => $bigCottageNameUa . '№18',
                'name_en' => $bigCottageNameEn . '№18',
                'description_ua' => $bigCottageDescriptionUa,
                'description_en' => $bigCottageDescriptionEn,
                'zone' => 'cottages',
                'type' => 'big cottage',
                'max_persons' => 4,
            ],
            [
                'name_ua' => $bedNameUa,
                'name_en' => $bedNameEn,
                'description_ua' => $bedDescriptionUa,
                'description_en' => $bedDescriptionEn,
                'zone' => 'pool',
                'type' => 'bed',
                'max_persons' => 1,
            ],
            [
                'name_ua' => $bedNameUa,
                'name_en' => $bedNameEn,
                'description_ua' => $bedDescriptionUa,
                'description_en' => $bedDescriptionEn,
                'zone' => 'pool',
                'type' => 'bed',
                'max_persons' => 1,
            ],
            [
                'name_ua' => $bedNameUa,
                'name_en' => $bedNameEn,
                'description_ua' => $bedDescriptionUa,
                'description_en' => $bedDescriptionEn,
                'zone' => 'pool',
                'type' => 'bed',
                'max_persons' => 1,
            ],
            [
                'name_ua' => $bedNameUa,
                'name_en' => $bedNameEn,
                'description_ua' => $bedDescriptionUa,
                'description_en' => $bedDescriptionEn,
                'zone' => 'pool',
                'type' => 'bed',
                'max_persons' => 1,
            ],
            [
                'name_ua' => $sunbedNameUa,
                'name_en' => $sunbedNameEn,
                'description_ua' => $sunbedDescriptionUa,
                'description_en' => $sunbedDescriptionEn,
                'zone' => 'pool',
                'type' => 'sunbed',
                'max_persons' => 1,
            ],

        ];

        DB::table('booking_objects')->insert($objects);
    }
}
