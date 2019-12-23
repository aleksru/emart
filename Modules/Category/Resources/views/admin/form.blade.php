@extends('admin::layouts.master')

@section('title')
    <h1 class="m-0 text-dark">Редактирование категории</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <a href="{{route('admin.category.index')}}" class="btn btn-secondary text-white float-left" style="margin-bottom: 1rem;">Назад</a>
        </div>
        <div class="row">
            <!-- right column -->
            <div class="col-12">
                <!-- general form elements disabled -->
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title"></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-sm-2">
                                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill" href="#vert-tabs-home" role="tab" aria-controls="vert-tabs-home" aria-selected="true">Основное</a>
                                    <a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill" href="#vert-tabs-profile" role="tab" aria-controls="vert-tabs-profile" aria-selected="false">Seo</a>
                                    {{--<a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill" href="#vert-tabs-messages" role="tab" aria-controls="vert-tabs-messages" aria-selected="false">Messages</a>--}}
                                    {{--<a class="nav-link" id="vert-tabs-settings-tab" data-toggle="pill" href="#vert-tabs-settings" role="tab" aria-controls="vert-tabs-settings" aria-selected="false">Settings</a>--}}
                                </div>
                            </div>
                            <div class="col-8 col-sm-10">
                                <form id="form-category" role="form" method="POST" action="
                                    {{isset($category) ? route('admin.category.update', $category->slug) : route('admin.category.store')}}"
                                >
                                    @csrf
                                    @if(isset($category))
                                        @method('PUT')
                                    @endif
                                    <div class="tab-content" id="vert-tabs-tabContent">
                                        <div class="tab-pane text-left fade active show" id="vert-tabs-home" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                                            <div class="row">
                                                <div class="col-6">
                                                    @component('admin::parts.form.checkbox', [
                                                        'name' => 'is_active',
                                                        'label' => 'Включить/Отключить',
                                                        'initState' => $category->is_active ?? 1
                                                    ])
                                                        {{ old('ordering', $category->ordering ?? '') }}
                                                    @endcomponent
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    @component('admin::parts.form.input', [
                                                        'name' => 'name',
                                                        'label' => 'Название категории'
                                                    ])
                                                        {{ old('name', $category->name ?? '') }}
                                                    @endcomponent
                                                </div>
                                                <div class="col-sm-6">
                                                    @component('admin::parts.form.input', [
                                                        'name' => 'slug',
                                                        'label' => 'URI'
                                                    ])
                                                        {{ old('slug', $category->slug ?? '') }}
                                                    @endcomponent
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>
                                                            Родительская категория
                                                        </label>
                                                        <select class="form-control js-example-categories-single" name="parent_id">
                                                            <option value="0">Корневая</option>
                                                            @if($category->parent ?? false)
                                                                <option value="{{$category->parent->name}}" selected>{{$category->parent->name}}</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    @component('admin::parts.form.input', [
                                                        'name' => 'ordering',
                                                        'label' => 'Сортировка',
                                                        'type' => 'number',
                                                        'min' => 0
                                                    ])
                                                        {{ old('ordering', $category->ordering ?? '') }}
                                                    @endcomponent
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    @component('admin::parts.form.richeditor', [
                                                        'name' => 'description',
                                                        'label' => 'Описание'
                                                    ])
                                                        {{ old('description', $category->description ?? '') }}
                                                    @endcomponent
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    @component('media::admin.form.images', [
                                                        'name' => 'image',
                                                        'model' => $category ?? null,
                                                        'label' => 'Изображение'
                                                    ])
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="vert-tabs-profile" role="tabpanel" aria-labelledby="vert-tabs-profile-tab">
                                            <div class="row">
                                                <div class="col-12">
                                                    @component('seo::admin.form.seo', [
                                                        'model' => $category ?? null,
                                                    ])
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    <div class="card-footer">
                                        <button type="submit" form="form-category" class="btn btn-primary float-right">Сохранить</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (right) -->
        </div>
    </div>
@stop
@push('script')
<script>
    let categories = {!! json_encode(\Modules\Category\Entities\Category::select('id', 'name as text')->where('id', '<>', $category->id ?? null)->get()->toArray()) !!}
    $(function() {
        $('.js-example-categories-single').select2({
            data: categories,
            placeholder: "Выберите родительскую категорию...",
        });
    });
</script>
@endpush