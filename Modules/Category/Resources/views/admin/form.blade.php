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
                        <form id="form-category" role="form" method="POST" action="
                            {{isset($category) ? route('admin.category.update', $category->slug) : route('admin.category.store')}}"
                        >
                            @csrf
                            @if(isset($category))
                                @method('PUT')
                            @endif
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
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    @component('admin::parts.form.input', [
                                        'name' => 'ordering',
                                        'label' => 'Сортировка',
                                        'type' => 'number'
                                    ])
                                        {{ old('ordering', $category->ordering ?? '') }}
                                    @endcomponent
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    @component('admin::parts.form.richeditor', [
                                        'name' => 'description',
                                        'label' => 'Описание'
                                    ])
                                        {{ old('description', $category->description ?? '') }}
                                    @endcomponent
                                </div>
                                <div class="col-4">
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
                                <div class="col-6">
                                    @component('media::admin.form.images', [
                                        'name' => 'image',
                                        'model' => $category ?? null,
                                        'label' => 'Изображение'
                                    ])
                                    @endcomponent
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" form="form-category" class="btn btn-primary float-right">Сохранить</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </div>
@stop
@push('script')
<script>
    let categories = {!! json_encode(\Modules\Category\Entities\Category::select('id', 'name as text')->where('id', '<>', $category->id ?? null)->get()->toArray()) !!}
    $(function() {
        $('.js-example-categories-single').select2({
            allowClear: true,
            data: categories,
            placeholder: "Выберите родительскую категорию...",
        });
    });
</script>
@endpush