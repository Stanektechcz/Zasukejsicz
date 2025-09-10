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
        'user_id' => 'Uživatel',
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
        'dashboard' => 'Dashboard',
        'users' => 'Uživatelé',
        'profiles' => 'Profily',
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
