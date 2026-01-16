<?php

return [
    'attributes' => [
        'name' => 'Name',
        'email' => 'Email Address',
        'phone' => 'Phone Number',
        'password' => 'Password',
        'password_confirmation' => 'Confirm Password',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'age' => 'Age',
        'location' => 'Location',
        'bio' => 'Biography',
        'status' => 'Status',
        'availability_hours' => 'Availability Hours',
        'services_offered' => 'Services Offered',
        'pricing' => 'Pricing',
        'gender' => 'Gender',
        'gender_male' => 'Male',
        'gender_female' => 'Female',
        'user_id' => 'User',
        'roles' => 'Roles',
    ],
    
    'values' => [
        'gender' => [
            'woman' => 'Woman',
            'man' => 'Man',
        ],
        'status' => [
            'active' => 'Active',
            'inactive' => 'Inactive',
            'pending' => 'Pending',
        ],
    ],
    
    'navigation' => [
        'dashboard' => 'Dashboard',
        'users' => 'Users',
        'profiles' => 'Profiles',
        'services' => 'Services',
        'pages' => 'Pages',
        'blog_posts' => 'Blog Posts',
        'roles' => 'Roles',
        'permissions' => 'Permissions',
    ],
    
    'actions' => [
        'create' => 'Create',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'save' => 'Save',
        'cancel' => 'Cancel',
        'view' => 'View',
        'export' => 'Export',
    ],
    
    'pages' => [
        'create' => 'Create :resource',
        'edit' => 'Edit :resource',
        'list' => ':resource List',
    ],
];
