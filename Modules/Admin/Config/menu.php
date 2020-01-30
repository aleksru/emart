<?php
return [
    'catalog' => [
        'name'  => 'Каталог',
        'route' => '#',
        'icon'  => 'nav-icon fas fa-tags',
        'active' => [
            'admin.category.index',
            'admin.category.edit',
            'admin.category.create',
            'admin.product.index',
            'admin.product.edit',
            'admin.product.create'
        ],
        'sub_categories' => [
            [
                'name'  => 'Категории',
                'route' => 'admin.category.index',
                'active' => [
                    'admin.category.index',
                    'admin.category.edit',
                    'admin.category.create'
                ]
            ],
            [
                'name'  => 'Товары',
                'route' => 'admin.product.index',
                'active' => [
                    'admin.product.index',
                    'admin.product.edit',
                    'admin.product.create'
                ]
            ],
        ]
    ],

    'test' => [
        'name'  => 'Test',
        'icon'  => 'nav-icon fas fa-th',
        'active' => [],
    ],
];