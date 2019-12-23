@extends('admin::layouts.master')

@section('title')
    <h1 class="m-0 text-dark">Категории</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Список категорий</h3>
                    <a href="{{route('admin.category.create')}}" class="btn btn-primary float-right">Создать</a>
                </div>
                <div class="card-body table-responsive">
                    @include('admin::parts.datatable.datatable',[
                        'id' => 'category-table',
                        'route' => route('admin.category.datatable'),
                        'columns' => [
                            'id' => [
                                'name' => 'ID',
                                'width' => '2%',
                                'searchable' => true,
                            ],
                            'name' => [
                                'name' => 'Название',
                                'width' => '20%',
                                'searchable' => true,
                            ],
                            'parent_id' => [
                                'name' => 'Родитель',
                                'width' => '20%',
                                'searchable' => true,
                            ],
                            'slug' => [
                                'name' => 'SLUG',
                                'width' => '20%',
                                'searchable' => true,
                            ],
                            'ordering' => [
                                'name' => 'Сортировка',
                                'width' => '20%',
                                'searchable' => false,
                            ],
                            'deleted_at' => [
                                'name' => 'Удалено',
                                'width' => '5%',
                                'searchable' => false,
                            ],
                            'is_active' => [
                                'name' => 'Включена',
                                'width' => '5%',
                                'searchable' => false,
                            ],
                            'actions' => [
                                'name' => 'Действия',
                                'width' => '10%',
                                'orderable' => 'false'
                            ],
                        ],
                    ])
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Древо категорий</h3>
                </div>
                <div class="card-body">
                    <ul>
                        @php
                            $traverse = function ($categories) use (&$traverse) {
                                foreach ($categories as $category) {
                                    echo '<li>' . '<a href="'.route('admin.category.edit', $category->slug).'" target="_blank">' . $category->name . '</a>';
                                    if(!$category->children->isEmpty()){
                                        echo '<ul>';
                                            $traverse($category->children);
                                        echo '</ul>';
                                    }
                                    echo '</li>';
                                 }
                            };
                            $traverse($categories)
                        @endphp
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
