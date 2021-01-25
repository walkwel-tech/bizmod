<?php

return [
    'welcome' => 'Welcome to :name',
    'access' => "Sorry You don't have Access to view this.",
    'routes' => [
        'login' => 'Login',
        'register' => 'Register',
        'logout' => 'Logout',
        'admin' => 'Admin',
    ],
    'inputs' => [
        'avatar' => 'Select a file',
        'role' => 'User Role',
        'address' => [
            'title' => 'Address Title',
            'phone' => 'Phone Number',
            'line_1' => 'Line 1',
            'line_2' => 'Line 2',
            'zip' => 'Zipcode',
            'details' => 'Details',
        ],
        'toggle' => [
            'on' => 'On',
            'off' => 'Off',
        ],
    ],
    'stats' => [
        'title' => 'Stats',
        'text' => 'Since',
    ],
    'actions' => [
        'back' => 'Back to :name',
        'view' => 'View :name details',
        'update' => 'Edit :name',
        'modified' => ':name has been modified',
        'save' => 'Save :name information',
        'saved' => 'Saved :name information into system',
        'restore' => 'Recover :name',
        'restored' => 'Restored :name back.',
        'trash' => 'Trash :name',
        'trashed' => 'Trashed :name',
        'delete' => 'Delete :name',
        'deleted' => 'Deleted :name',
        'removed' => 'Removed :name',
        'permanent_delete' => 'Permanently Delete :name',
        'permanent_deleted' => 'Permanently Deleted :name',
        'confirm' => [
            'delete' => 'Are you sure? :name will be deleted.',
            'restore' =>'Are you sure? :name will be restored.',
            'permanent_delete' =>'Are you sure? :name will be deleted permanently.',
        ]
    ]
];
