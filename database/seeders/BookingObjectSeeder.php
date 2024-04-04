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
                'name' => $bungaloName . '№2',
                'description' => $secondBungaloDescription,
                'max_persons' => null,
            ],
            [
                'name' => $bungaloName . '№3',
                'description' => $bungaloDescription,
                'max_persons' => null,
            ],
            [
                'name' => $bungaloName . '№4',
                'description' => $bungaloDescription,
                'max_persons' => null,
            ],
            [
                'name' => $bungaloName . '№5',
                'description' => $bungaloDescription,
                'max_persons' => null,
            ],
            [
                'name' => $bungaloName . '№6',
                'description' => $bungaloDescription,
                'max_persons' => null,
            ],
            [
                'name' => $littleCottageName . '№7',
                'description' => $littleCottageDescription,
                'max_persons' => 4,
            ],
            [
                'name' => $littleCottageName . '№8',
                'description' => $littleCottageDescription,
                'max_persons' => 4,
            ],
            [
                'name' => $littleCottageName . '№9',
                'description' => $littleCottageDescription,
                'max_persons' => 4,
            ],
            [
                'name' => $littleCottageName . '№10',
                'description' => $littleCottageDescription,
                'max_persons' => 4,
            ],
            [
                'name' => $bigCottageName . '№11',
                'description' => $bigCottageDescription,
                'max_persons' => 4,
            ],
            [
                'name' => $bigCottageName . '№12',
                'description' => $bigCottageDescription,
                'max_persons' => 4,
            ],
            [
                'name' => $bigCottageName . '№13',
                'description' => $bigCottageDescription,
                'max_persons' => 4,
            ],
            [
                'name' => $bigCottageName . '№14',
                'description' => $bigCottageDescription,
                'max_persons' => 4,
            ],
            [
                'name' => $bigCottageName . '№15',
                'description' => $bigCottageDescription,
                'max_persons' => 4,
            ],
            [
                'name' => $bigCottageName . '№16',
                'description' => $bigCottageDescription,
                'max_persons' => 4,
            ],
            [
                'name' => $bigCottageName . '№17',
                'description' => $bigCottageDescription,
                'max_persons' => 4,
            ],
            [
                'name' => $bigCottageName . '№18',
                'description' => $bigCottageDescription,
                'max_persons' => 4,
            ]

        ];

        DB::table('booking_objects')->insert($objects);
    }
}
