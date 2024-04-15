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
        $bungaloName = 'Бунгало ';
        $littleCottageName = 'Маленький котедж ';
        $bigCottageName = 'Великий котедж з мангальною зоною ';

        $secondBungaloDescription = 'Невеликий скляний будиночок з просторою терасою , розташований на узбережі Дніпра. Всередині бунгало оснащене кондиціонером, невеликим диваном для відпочинку та санвузлом (рукомийник,душ та туалет) В бунгало є 2 рушники, та засоби особистої гігієни (гелі для душу (2шт), шампуні (2шт), рідке мило для рук, туалетний папір та одноразові капці (2 пари)). Тераса облаштована вуличними меблями.';
        $bungaloDescription = 'Невеликий скляний будиночок з просторою терасою , розташований на узбережі Дніпра. Всередині бунгало оснащене кондиціонером, невеликим диваном для відпочинку та санвузлом (рукомийник,душ та туалет) В бунгало є 2 рушники, та засоби особистої гігієни (гелі для душу (2шт), шампуні (2шт), рідке мило для рук, туалетний папір та одноразові капці (2 пари)). Тераса облаштована вуличними меблями.';
        $littleCottageDescription = 'Окремо стоячий дворівневий котедж - це комфортабельний будинок, розташований на березі Дніпра. Ідеальне місце для сімейного відпочинку та невеликої компанії. 1-й рівень - кухонна панель з необхідним посудом (тарілки,склянки  та столові прибори), мікрохвильова піч, електрочайник, невеликий холодильник, раковина, шафа купе, санвузол (рукомийник, душ та туалет), бойлер, кондиціонер, розкладний двоспальний диван. В котеджі є рушники (4шт), 2 комплекти постільної білизни, ковдри, капці, засоби особистої гігієни (гелі для душу,шампуні, рідке мило, туалетний папір) 2-й рівень - ліжко. Біля котеджу є невелика тераса з вуличними меблями, для відпочинку з видом на Дніпро. У вартість оренди входить 4 людини за додаткових гостей доплата';
        $bigCottageDescription = 'Котедж на березі Дніпра - чудове місце для відпочинку великою компанією. Оточено природою з власною великою терасою та особистим мангалом. Апартаменти оснащені: Простора кухонна панель з необхідним посудом  (тарілки,склянки, столові прибори),мікрохвильова піч, електрочайник, невеликий холодильник, раковина,  санвузол (рукомийник, душ та туалет), бойлер, кондиціонер, шафа, стіл, стільці, двоспальне ліжко та розкладний  двоспальний диван. В котеджі є рушники (4шт), 2 комплекти постільної білизни, ковдри, капці, засоби особистої гігієни (гелі для душу,шампуні, рідке мило, туалетний папір) Біля котеджу є простора тераса з вуличними меблями, для відпочинку з видом на Дніпро, та мангальна зона ( вугілля та дрова входять у вартість, приблизно для одного розпалення мангалу). У вартість оренди входить 4 людини за додаткових гостей доплата';

        $objects = [
            [
                'name_ua' => $bungaloName . '№2 ua',
                'name_en' => $bungaloName . '№2 en',
                'description' => $secondBungaloDescription,
                'zone' => 'bungalow',
                'type' => 'second bungalow',
                'max_persons' => null,
            ],
            [
                'name_ua' => $bungaloName . '№3 ua',
                'name_en' => $bungaloName . '№3 en',
                'description' => $bungaloDescription,
                'zone' => 'bungalow',
                'type' => 'bungalow',
                'max_persons' => null,
            ],
            [
                'name_ua' => $bungaloName . '№4 ua',
                'name_en' => $bungaloName . '№4 en',
                'description' => $bungaloDescription,
                'zone' => 'bungalow',
                'type' => 'bungalow',
                'max_persons' => null,
            ],
            [
                'name_ua' => $bungaloName . '№5 ua',
                'name_en' => $bungaloName . '№5 en',
                'description' => $bungaloDescription,
                'zone' => 'bungalow',
                'type' => 'bungalow',
                'max_persons' => null,
            ],
            [
                'name_ua' => $bungaloName . '№6 ua',
                'name_en' => $bungaloName . '№6 en',
                'description' => $bungaloDescription,
                'zone' => 'bungalow',
                'type' => 'bungalow',
                'max_persons' => null,
            ],
            [
                'name_ua' => $littleCottageName . '№7 ua',
                'name_en' => $littleCottageName . '№7 en',
                'description' => $littleCottageDescription,
                'zone' => 'cottages',
                'type' => 'little cottage',
                'max_persons' => 4,
            ],
            [
                'name_ua' => $littleCottageName . '№8 ua',
                'name_en' => $littleCottageName . '№8 en',
                'description' => $littleCottageDescription,
                'zone' => 'cottages',
                'type' => 'little cottage',
                'max_persons' => 4,
            ],
            [
                'name_ua' => $littleCottageName . '№9 ua',
                'name_en' => $littleCottageName . '№9 en',
                'description' => $littleCottageDescription,
                'zone' => 'cottages',
                'type' => 'little cottage',
                'max_persons' => 4,
            ],
            [
                'name_ua' => $littleCottageName . '№10 ua',
                'name_en' => $littleCottageName . '№10 en',
                'description' => $littleCottageDescription,
                'zone' => 'cottages',
                'type' => 'little cottage',
                'max_persons' => 4,
            ],
            [
                'name_ua' => $bigCottageName . '№11 ua',
                'name_en' => $bigCottageName . '№11 en',
                'description' => $bigCottageDescription,
                'zone' => 'cottages',
                'type' => 'big cottage',
                'max_persons' => 4,
            ],
            [
                'name_ua' => $bigCottageName . '№12 ua',
                'name_en' => $bigCottageName . '№12 en',
                'description' => $bigCottageDescription,
                'zone' => 'cottages',
                'type' => 'big cottage',
                'max_persons' => 4,
            ],
            [
                'name_ua' => $bigCottageName . '№13 ua',
                'name_en' => $bigCottageName . '№13 en',
                'description' => $bigCottageDescription,
                'zone' => 'cottages',
                'type' => 'big cottage',
                'max_persons' => 4,
            ],
            [
                'name_ua' => $bigCottageName . '№14 ua',
                'name_en' => $bigCottageName . '№14 en',
                'description' => $bigCottageDescription,
                'zone' => 'cottages',
                'type' => 'big cottage',
                'max_persons' => 4,
            ],
            [
                'name_ua' => $bigCottageName . '№15 ua',
                'name_en' => $bigCottageName . '№15 en',
                'description' => $bigCottageDescription,
                'zone' => 'cottages',
                'type' => 'big cottage',
                'max_persons' => 4,
            ],
            [
                'name_ua' => $bigCottageName . '№16 ua',
                'name_en' => $bigCottageName . '№16 en',
                'description' => $bigCottageDescription,
                'zone' => 'cottages',
                'type' => 'big cottage',
                'max_persons' => 4,
            ],
            [
                'name_ua' => $bigCottageName . '№17 ua',
                'name_en' => $bigCottageName . '№17 en',
                'description' => $bigCottageDescription,
                'zone' => 'cottages',
                'type' => 'big cottage',
                'max_persons' => 4,
            ],
            [
                'name_ua' => $bigCottageName . '№18 ua',
                'name_en' => $bigCottageName . '№18 en',
                'description' => $bigCottageDescription,
                'zone' => 'cottages',
                'type' => 'big cottage',
                'max_persons' => 4,
            ],
            [
                'name_ua' => 'ліжко ua',
                'name_en' => 'ліжко en',
                'description' => 'просто ліжко',
                'zone' => 'pool',
                'type' => 'bed',
                'max_persons' => 1,
            ],
            [
                'name_ua' => 'ліжко ua',
                'name_en' => 'ліжко en',
                'description' => 'просто ліжко',
                'zone' => 'pool',
                'type' => 'bed',
                'max_persons' => 1,
            ],
            [
                'name_ua' => 'ліжко ua',
                'name_en' => 'ліжко en',
                'description' => 'просто ліжко',
                'zone' => 'pool',
                'type' => 'bed',
                'max_persons' => 1,
            ],
            [
                'name_ua' => 'ліжко ua',
                'name_en' => 'ліжко en',
                'description' => 'просто ліжко',
                'zone' => 'pool',
                'type' => 'bed',
                'max_persons' => 1,
            ],
            [
                'name_ua' => 'лежак ua',
                'name_en' => 'ліжко en',
                'description' => 'просто лежак',
                'zone' => 'pool',
                'type' => 'sunbed',
                'max_persons' => 1,
            ],

        ];

        DB::table('booking_objects')->insert($objects);
    }
}
