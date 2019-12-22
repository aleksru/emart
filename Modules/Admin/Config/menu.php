<?php
return [
    'catalog' => [
        'name'  => 'Каталог',
        'route' => '#',
        'icon'  => 'nav-icon fas fa-tachometer-alt',
        'active' => [
            'admin.category.index',
            'admin.category.edit',
            'admin.category.create'
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
                'active' => []
            ],
        ]
    ],
    'test' => [
        'name'  => 'Test',
        'icon'  => 'nav-icon fas fa-th',
        'active' => [],
    ],
];