<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Поле :attribute повинно бути прийнято.',
    'accepted_if' => 'Поле :attribute повинно бути прийнято, коли :other є :value.',
    'active_url' => 'Поле :attribute повинно бути дійсним URL.',
    'after' => 'Поле :attribute повинно бути датою після :date.',
    'after_or_equal' => 'Поле :attribute повинно бути датою після або рівною :date.',
    'alpha' => 'Поле :attribute повинно містити лише букви.',
    'alpha_dash' => 'Поле :attribute може містити лише літери, цифри, дефіси та підкреслення.',
    'alpha_num' => 'Поле :attribute може містити лише літери та цифри.',
    'array' => 'Поле :attribute повинно бути масивом.',
    'ascii' => 'Поле :attribute може містити лише однобайтові буквено-цифрові символи та символи.',
    'before' => 'Поле :attribute повинно бути датою до :date.',
    'before_or_equal' => 'Поле :attribute повинно бути датою до або рівною :date.',
    'between' => [
        'array' => 'Поле :attribute повинно містити від :min до :max елементів.',
        'file' => 'Поле :attribute повинно бути від :min до :max кілобайт.',
        'numeric' => 'Поле :attribute повинно бути від :min до :max.',
        'string' => 'Поле :attribute повинно бути від :min до :max символів.',
    ],
    'boolean' => 'Поле :attribute повинно мати значення true або false.',
    'can' => 'Поле :attribute містить недопустиме значення.',
    'confirmed' => 'Підтвердження поля :attribute не збігається.',
    'current_password' => 'Пароль невірний.',
    'date' => 'Поле :attribute повинно бути дійсною датою.',
    'date_equals' => 'Поле :attribute повинно бути датою, рівною :date.',
    'date_format' => 'Поле :attribute не відповідає формату :format.',
    'decimal' => 'Поле :attribute повинно мати :decimal знаки після коми.',
    'declined' => 'Поле :attribute повинно бути відхилене.',
    'declined_if' => 'Поле :attribute повинно бути відхилене, коли :other є :value.',
    'different' => 'Поля :attribute і :other повинні бути різними.',
    'digits' => 'Поле :attribute повинно бути :digits цифр.',
    'digits_between' => 'Поле :attribute повинно бути від :min до :max цифр.',
    'dimensions' => 'Поле :attribute має недійсні розміри зображення.',
    'distinct' => 'Поле :attribute має повторюване значення.',
    'doesnt_end_with' => 'Поле :attribute не повинно закінчуватися одним з наступних значень: :values.',
    'doesnt_start_with' => 'Поле :attribute не повинно починатися з одного з наступних значень: :values.',
    'email' => 'Поле :attribute повинно бути дійсною електронною адресою.',
    'ends_with' => 'Поле :attribute повинно закінчуватися одним з наступних значень: :values.',
    'enum' => 'Вибрано неправильне значення для :attribute.',
    'exists' => 'Вибране значення для :attribute недійсне.',
    'extensions' => 'Поле :attribute повинно бути файлом одного з наступних типів: :values.',
    'file' => 'Поле :attribute повинно бути файлом.',
    'filled' => 'Поле :attribute повинно мати значення.',
    'gt' => [
        'array' => 'Поле :attribute повинно містити більше ніж :value елементів.',
        'file' => 'Поле :attribute повинно бути більшим за :value кілобайт.',
        'numeric' => 'Поле :attribute повинно бути більшим за :value.',
        'string' => 'Поле :attribute повинно бути більшим за :value символів.',
    ],
    'gte' => [
        'array' => 'Поле :attribute повинно містити :value елементів або більше.',
        'file' => 'Поле :attribute повинно бути більшим або рівним :value кілобайт.',
        'numeric' => 'Поле :attribute повинно бути більшим або рівним :value.',
        'string' => 'Поле :attribute повинно бути більшим або рівним :value символів.',
    ],
    'hex_color' => 'Поле :attribute повинно бути дійсним шестнадцятковим кольором.',
    'image' => 'Поле :attribute повинно бути зображенням.',
    'in' => 'Вибране значення для :attribute недійсне.',
    'in_array' => 'Поле :attribute не існує в :other.',
    'integer' => 'Поле :attribute повинно бути цілим числом.',
    'ip' => 'Поле :attribute повинно бути дійсною IP-адресою.',
    'ipv4' => 'Поле :attribute повинно бути дійсною IPv4-адресою.',
    'ipv6' => 'Поле :attribute повинно бути дійсною IPv6-адресою.',
    'json' => 'Поле :attribute повинно бути дійсною JSON-строкою.',
    'list' => 'Поле :attribute повинно бути списком.',
    'lowercase' => 'Поле :attribute повинно бути в нижньому регістрі.',
    'lt' => [
        'array' => 'Поле :attribute повинно містити менше ніж :value елементів.',
        'file' => 'Поле :attribute повинно бути менше, ніж :value кілобайт.',
        'numeric' => 'Поле :attribute повинно бути менше, ніж :value.',
        'string' => 'Поле :attribute повинно бути менше, ніж :value символів.',
    ],
    'lte' => [
        'array' => 'Поле :attribute повинно містити не більше ніж :value елементів.',
        'file' => 'Поле :attribute повинно бути менше або рівним :value кілобайт.',
        'numeric' => 'Поле :attribute повинно бути менше або рівним :value.',
        'string' => 'Поле :attribute повинно бути менше або рівним :value символів.',
    ],
    'mac_address' => 'Поле :attribute повинно бути дійсною MAC-адресою.',
    'max' => [
        'array' => 'Поле :attribute не може містити більше ніж :max елементів.',
        'file' => 'Поле :attribute не може бути більше, ніж :max кілобайт.',
        'numeric' => 'Поле :attribute не може бути більше, ніж :max.',
        'string' => 'Поле :attribute не може бути більше, ніж :max символів.',
    ],
    'max_digits' => 'Поле :attribute не може містити більше ніж :max цифр.',
    'mimes' => 'Поле :attribute повинно бути файлом одного з наступних типів: :values.',
    'mimetypes' => 'Поле :attribute повинно бути файлом одного з наступних типів: :values.',
    'min' => [
        'array' => 'Поле :attribute повинно містити щонайменше :min елементів.',
        'file' => 'Поле :attribute повинно бути не менше :min кілобайт.',
        'numeric' => 'Поле :attribute повинно бути не менше :min.',
        'string' => 'Поле :attribute повинно бути не менше :min символів.',
    ],
    'min_digits' => 'Поле :attribute повинно містити щонайменше :min цифр.',
    'missing' => 'Поле :attribute повинно бути відсутнім.',
    'missing_if' => 'Поле :attribute повинно бути відсутнім, коли :other є :value.',
    'missing_unless' => 'Поле :attribute повинно бути відсутнім, якщо :other не є :value.',
    'missing_with' => 'Поле :attribute повинно бути відсутнім, коли :values присутній.',
    'missing_with_all' => 'Поле :attribute повинно бути відсутнім, коли :values присутній.',
    'multiple_of' => 'Поле :attribute повинно бути кратним :value.',
    'not_in' => 'Вибране значення для :attribute недійсне.',
    'not_regex' => 'Формат поля :attribute недійсний.',
    'numeric' => 'Поле :attribute повинно бути числом.',
    'password' => [
        'letters' => 'Поле :attribute повинно містити щонайменше одну літеру.',
        'mixed' => 'Поле :attribute повинно містити щонайменше одну велику і одну маленьку літеру.',
        'numbers' => 'Поле :attribute повинно містити щонайменше одну цифру.',
        'symbols' => 'Поле :attribute повинно містити щонайменше один символ.',
        'uncompromised' => "Вказане :attribute з'являлося в протоколі даних. Будь ласка, оберіть інший :attribute.",
    ],
    'present' => 'Поле :attribute повинно бути присутнім.',
    'present_if' => 'Поле :attribute повинно бути присутнім, коли :other є :value.',
    'present_unless' => 'Поле :attribute повинно бути присутнім, якщо :other не є :value.',
    'present_with' => 'Поле :attribute повинно бути присутнім, коли :values присутній.',
    'present_with_all' => 'Поле :attribute повинно бути присутнім, коли :values присутній.',
    'prohibited' => 'Поле :attribute заборонене.',
    'prohibited_if' => 'Поле :attribute заборонене, коли :other є :value.',
    'prohibited_unless' => 'Поле :attribute заборонене, якщо :other не є :value.',
    'prohibits' => 'Поле :attribute забороняє :other бути присутнім.',
    'regex' => 'Формат поля :attribute недійсний.',
    'required' => "Поле :attribute обов'язкове.",
    'required_array_keys' => 'Поле :attribute повинно містити записи для: :values.',
    'required_if' => "Поле :attribute обов'язкове, коли :other є :value.",
    'required_if_accepted' => "Поле :attribute обов'язкове, коли :other прийнято.",
    'required_unless' => "Поле :attribute обов'язкове, якщо :other не є :values.",
    'required_with' => "Поле :attribute обов'язкове, коли :values присутній.",
    'required_with_all' => "Поле :attribute обов'язкове, коли :values присутній.",
    'required_without' => "Поле :attribute обов'язкове, коли :values не присутній.",
    'required_without_all' => "Поле :attribute обов'язкове, коли немає жодного з :values.",
    'same' => 'Поля :attribute і :other повинні збігатися.',
    'size' => [
        'array' => 'Поле :attribute повинно містити :size елементів.',
        'file' => 'Поле :attribute повинно бути :size кілобайт.',
        'numeric' => 'Поле :attribute повинно бути :size.',
        'string' => 'Поле :attribute повинно бути :size символів.',
    ],
    'starts_with' => 'Поле :attribute повинно починатися з одного з наступних значень: :values.',
    'string' => 'Поле :attribute повинно бути рядком.',
    'timezone' => 'Поле :attribute повинно бути дійсною часовою зоною.',
    'unique' => 'Поле :attribute вже зайняте.',
    'uploaded' => 'Поле :attribute не вдалося завантажити.',
    'uppercase' => 'Поле :attribute повинно бути великими літерами.',
    'url' => 'Формат поля :attribute недійсний.',
    'ulid' => 'Поле :attribute повинно бути дійсним ULID.',
    'uuid' => 'Поле :attribute повинно бути дійсним UUID.',

    /*
    |--------------------------------------------------------------------------
    | Мовні рядки валідації за замовчуванням
    |--------------------------------------------------------------------------
    |
    | Тут ви можете вказати мовні рядки за замовчуванням, використовувані валідатором.
    | Деякі з цих правил мають кілька версій, таких як правила розміру.
    | Вільно налаштовуйте кожне з цих повідомлень тут.
    |
    */

    'accepted' => 'Поле :attribute повинно бути прийнято.',
    'accepted_if' => 'Поле :attribute повинно бути прийнято, коли :other є :value.',
    'active_url' => 'Поле :attribute не є дійсним URL.',
    'after' => 'Поле :attribute повинно бути датою після :date.',
    'after_or_equal' => 'Поле :attribute повинно бути датою після або рівною :date.',
    'alpha' => 'Поле :attribute може містити лише літери.',
    'alpha_dash' => 'Поле :attribute може містити лише літери, цифри, дефіси та підкреслення.',
    'alpha_num' => 'Поле :attribute може містити лише літери та цифри.',
    'array' => 'Поле :attribute повинно бути масивом.',
    'before' => 'Поле :attribute повинно бути датою до :date.',
    'before_or_equal' => 'Поле :attribute повинно бути датою до або рівною :date.',
    'between' => [
        'array' => 'Поле :attribute повинно містити від :min до :max елементів.',
        'file' => 'Поле :attribute повинно бути від :min до :max кілобайт.',
        'numeric' => 'Поле :attribute повинно бути від :min до :max.',
        'string' => 'Поле :attribute повинно бути від :min до :max символів.',
    ],
    'boolean' => 'Поле :attribute повинно мати значення true або false.',
    'confirmed' => 'Підтвердження :attribute не співпадає.',
    'current_password' => 'Пароль невірний.',
    'date' => 'Поле :attribute не є дійсною датою.',
    'date_equals' => 'Поле :attribute повинно бути датою, рівною :date.',
    'date_format' => 'Поле :attribute не відповідає формату :format.',
    'different' => 'Поля :attribute і :other повинні бути різними.',
    'digits' => 'Поле :attribute повинно бути довжиною :digits цифр.',
    'digits_between' => 'Поле :attribute повинно бути від :min до :max цифр.',
    'dimensions' => 'Поле :attribute має недійсні розміри зображення.',
    'distinct' => 'Поле :attribute має повторюване значення.',
    'email' => 'Поле :attribute повинно бути дійсною адресою електронної пошти.',
    'ends_with' => 'Поле :attribute повинно закінчуватися одним з наступних значень: :values.',
    'exists' => 'Вибране :attribute недійсне.',
    'file' => 'Поле :attribute повинно бути файлом.',
    'filled' => 'Поле :attribute повинно мати значення.',
    'gt' => [
        'array' => 'Поле :attribute повинно містити більше :value елементів.',
        'file' => 'Поле :attribute повинно бути більше :value кілобайт.',
        'numeric' => 'Поле :attribute повинно бути більше :value.',
        'string' => 'Поле :attribute повинно бути більше :value символів.',
    ],
    'gte' => [
        'array' => 'Поле :attribute повинно містити :value елементів або більше.',
        'file' => 'Поле :attribute повинно бути більше або рівним :value кілобайт.',
        'numeric' => 'Поле :attribute повинно бути більше або рівним :value.',
        'string' => 'Поле :attribute повинно бути більше або рівним :value символів.',
    ],
    'image' => 'Поле :attribute повинно бути зображенням.',
    'in' => 'Вибране :attribute недійсне.',
    'in_array' => 'Поле :attribute не існує в :other.',
    'integer' => 'Поле :attribute повинно бути цілим числом.',
    'ip' => 'Поле :attribute повинно бути дійсною IP-адресою.',
    'ipv4' => 'Поле :attribute повинно бути дійсною адресою IPv4.',
    'ipv6' => 'Поле :attribute повинно бути дійсною адресою IPv6.',
    'json' => 'Поле :attribute повинно бути дійсною JSON-стрічкою.',
    'lt' => [
        'array' => 'Поле :attribute повинно містити менше :value елементів.',
        'file' => 'Поле :attribute повинно бути менше :value кілобайт.',
        'numeric' => 'Поле :attribute повинно бути менше :value.',
        'string' => 'Поле :attribute повинно бути менше :value символів.',
    ],
    'lte' => [
        'array' => 'Поле :attribute повинно містити не більше, ніж :value елементів.',
        'file' => 'Поле :attribute повинно бути менше або рівним :value кілобайт.',
        'numeric' => 'Поле :attribute повинно бути менше або рівним :value.',
        'string' => 'Поле :attribute повинно бути менше або рівним :value символів.',
    ],
    'max' => [
        'array' => 'Поле :attribute не може містити більше :max елементів.',
        'file' => 'Поле :attribute не може бути більше :max кілобайт.',
        'numeric' => 'Поле :attribute не може бути більше :max.',
        'string' => 'Поле :attribute не може бути більше :max символів.',
    ],
    'max_digits' => 'Поле :attribute не може містити більше ніж :max цифр.',
    'mimes' => 'Поле :attribute повинно бути файлом типу: :values.',
    'mimetypes' => 'Поле :attribute повинно бути файлом типу: :values.',
    'min' => [
        'array' => 'Поле :attribute повинно містити щонайменше :min елементів.',
        'file' => 'Поле :attribute повинно бути не менше :min кілобайт.',
        'numeric' => 'Поле :attribute повинно бути не менше :min.',
        'string' => 'Поле :attribute повинно бути не менше :min символів.',
    ],
    'min_digits' => 'Поле :attribute повинно містити щонайменше :min цифр.',
    'missing' => 'Поле :attribute повинно бути відсутнім.',
    'missing_if' => 'Поле :attribute повинно бути відсутнім, коли :other є :value.',
    'missing_unless' => 'Поле :attribute повинно бути відсутнім, якщо :other не є :value.',
    'missing_with' => 'Поле :attribute повинно бути відсутнім, коли :values присутній.',
    'missing_with_all' => 'Поле :attribute повинно бути відсутнім, коли :values присутній.',
    'multiple_of' => 'Поле :attribute повинно бути кратним :value.',
    'not_in' => 'Вибране :attribute недійсне.',
    'not_regex' => 'Формат поля :attribute недійсний.',
    'numeric' => 'Поле :attribute повинно бути числом.',
    'password' => [
        'letters' => 'Поле :attribute повинно містити щонайменше одну літеру.',
        'mixed' => 'Поле :attribute повинно містити щонайменше одну велику і одну маленьку літеру.',
        'numbers' => 'Поле :attribute повинно містити щонайменше одну цифру.',
        'symbols' => 'Поле :attribute повинно містити щонайменше один символ.',
        'uncompromised' => "Вказане :attribute з'являлося в протоколі даних. Будь ласка, оберіть інший :attribute.",
    ],
    'present' => 'Поле :attribute повинно бути присутнім.',
    'present_if' => 'Поле :attribute повинно бути присутнім, коли :other є :value.',
    'present_unless' => 'Поле :attribute повинно бути присутнім, якщо :other не є :value.',
    'present_with' => 'Поле :attribute повинно бути присутнім, коли :values присутній.',
    'present_with_all' => 'Поле :attribute повинно бути присутнім, коли :values присутній.',
    'prohibited' => 'Поле :attribute заборонене.',
    'prohibited_if' => 'Поле :attribute заборонене, коли :other є :value.',
    'prohibited_unless' => 'Поле :attribute заборонене, якщо :other не є :value.',
    'prohibits' => 'Поле :attribute забороняє :other бути присутнім.',
    'regex' => 'Формат поля :attribute недійсний.',
    'required' => "Поле :attribute обов'язкове.",
    'required_array_keys' => 'Поле :attribute повинно містити записи для: :values.',
    'required_if' => "Поле :attribute обов'язкове, коли :other є :value.",
    'required_if_accepted' => "Поле :attribute обов'язкове, коли :other прийнято.",
    'required_unless' => "Поле :attribute обов'язкове, якщо :other не є :values.",
    'required_with' => "Поле :attribute обов'язкове, коли :values присутній.",
    'required_with_all' => "Поле :attribute обов'язкове, коли :values присутній.",
    'required_without' => "Поле :attribute обов'язкове, коли :values не присутній.",
    'required_without_all' => "Поле :attribute обов'язкове, коли немає жодного з :values.",
    'same' => 'Поля :attribute і :other повинні збігатися.',
    'size' => [
        'array' => 'Поле :attribute повинно містити :size елементів.',
        'file' => 'Поле :attribute повинно бути :size кілобайт.',
        'numeric' => 'Поле :attribute повинно бути :size.',
        'string' => 'Поле :attribute повинно бути :size символів.',
    ],
    'starts_with' => 'Поле :attribute повинно починатися з одного з наступних значень: :values.',
    'string' => 'Поле :attribute повинно бути рядком.',
    'timezone' => 'Поле :attribute повинно бути дійсною часовою зоною.',
    'unique' => 'Поле :attribute вже зайняте.',
    'uploaded' => 'Поле :attribute не вдалося завантажити.',
    'uppercase' => 'Поле :attribute повинно бути великими літерами.',
    'url' => 'Формат поля :attribute недійсний.',
    'ulid' => 'Поле :attribute повинно бути дійсним ULID.',
    'uuid' => 'Поле :attribute повинно бути дійсним UUID.',

    /*
    |--------------------------------------------------------------------------
    | Власні мовні рядки валідації
    |--------------------------------------------------------------------------
    |
    | Тут ви можете вказати власні мовні рядки для атрибутів за конвенцією "attribute.rule"
    | для найменування рядків. Це дозволяє зручно вказати конкретний власний мовний рядок для
    | заданого правила атрибута.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Власні атрибути валідації
    |--------------------------------------------------------------------------
    |
    | Наступні мовні рядки використовуються для заміни наших плейсхолдерів атрибутів
    | чимось більш приємним для читання, наприклад, "Електронна адреса" замість "email".
    | Це просто допомагає нам зробити наше повідомлення більш виразним.
    |
    */

    'attributes' => [],

];

