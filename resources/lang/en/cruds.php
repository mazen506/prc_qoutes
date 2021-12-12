<?php

return [
    'userManagement' => [
        'title'          => 'User management',
        'title_singular' => 'User management',
    ],
    'permission'     => [
        'title'          => 'Permissions',
        'title_singular' => 'Permission',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'title'             => 'Title',
            'title_helper'      => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'role'           => [
        'title'          => 'Roles',
        'title_singular' => 'Role',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => '',
            'title'              => 'Title',
            'title_helper'       => '',
            'permissions'        => 'Permissions',
            'permissions_helper' => '',
            'created_at'         => 'Created at',
            'created_at_helper'  => '',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => '',
        ],
    ],
    'user'           => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => '',
            'name'                     => 'Name',
            'name_helper'              => '',
            'email'                    => 'Email',
            'email_helper'             => '',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => '',
            'password'                 => 'Password',
            'password_helper'          => '',
            'roles'                    => 'Roles',
            'roles_helper'             => '',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => '',
            'created_at'               => 'Created at',
            'created_at_helper'        => '',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => '',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => '',
        ],
    ],
    'item'        => [
        'title'          => 'Items',
        'title_singular' => 'Item',
        'fields'         => [
            'id'                => 'Item No.',
            'id_helper'         => '',
            'images'    => 'Images',
            'item_name' => 'Item Name',
            'unit'                => 'Unit',            
            'image'                => 'Images',
            'image_helper'         => '',
            'name'              => 'Name',
            'name_helper'       => '',
            'package'              => 'Package',
            'package_helper'       => '',			
            'price'             => 'Price',
            'price_helper'      => '',
			'moq'             => 'Minimum Qty',
            'moq_helper'      => 'Minimum Quantity',
            'cpm'   => 'CPM',
			'qty'             => 'Qty',
            'qty_helper'      => 'Quantity',			
			'note'             => 'Note',
            'note_helper'      => 'Package',		
            'currency'	    => 'Currency',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'qoute'          => [
        'title'          => 'Qoutes',
        'title_singular' => 'Qoute',
        'fields'         => [
            'id'                    => 'Qoute No.',
            'id_helper'             => '',
            'user'         => 'Customer',
            'name'  => 'Name',
			'name_helper'  => '',
            'note'        => 'Note',
            'note_helper' => '',
            'items'              => 'Items',
            'items_helper'       => '',
            'created_at'            => 'Create Date',
            'created_at_helper'     => '',
            'updated_at'            => 'Update Date',
            'updated_at_helper'     => '',
            'deleted_at'            => 'Deleted at',
            'deleted_at_helper'     => '',
        ],
    ],
];
