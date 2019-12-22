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
                            'is_active' => [
                                'name' => 'Отображение',
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
    </div>
@stop