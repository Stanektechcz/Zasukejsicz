<?php

return [
    'attributes' => [
        'name' => 'Jméno',
        'email' => 'E-mailová adresa',
        'phone' => 'Telefonní číslo',
        'password' => 'Heslo',
        'password_confirmation' => 'Potvrdit heslo',
        'created_at' => 'Vytvořeno',
        'updated_at' => 'Aktualizováno',
        'age' => 'Věk',
        'location' => 'Lokalita',
        'bio' => 'Biografie',
        'status' => 'Status',
        'availability_hours' => 'Dostupnost',
        'services_offered' => 'Nabízené služby',
        'pricing' => 'Ceník',
        'gender' => 'Pohlaví',
        'gender_male' => 'Muž',
        'gender_female' => 'Žena',
        'user_id' => 'Uživatel',
        'roles' => 'Role',
    ],
    
    'values' => [
        'gender' => [
            'woman' => 'Žena',
            'man' => 'Muž',
        ],
        'status' => [
            'active' => 'Aktivní',
            'inactive' => 'Neaktivní',
            'pending' => 'Čekající',
        ],
    ],
    
    'navigation' => [
        'dashboard' => 'Nástěnka',
        'users' => 'Uživatelé',
        'profiles' => 'Profily',
        'services' => 'Služby',
        'pages' => 'Stránky',
        'blog_posts' => 'Blog příspěvky',
        'roles' => 'Role',
        'permissions' => 'Oprávnění',
    ],
    
    'actions' => [
        'create' => 'Vytvořit',
        'edit' => 'Upravit',
        'delete' => 'Smazat',
        'save' => 'Uložit',
        'cancel' => 'Zrušit',
        'view' => 'Zobrazit',
        'export' => 'Exportovat',
    ],
    
    'pages' => [
        'create' => 'Vytvořit :resource',
        'edit' => 'Upravit :resource',
        'list' => 'Seznam :resource',
    ],
];
