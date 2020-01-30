@extends('admin::layouts.master')

@section('title')
    <h1 class="m-0 text-dark">Редактирование товара</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <a href="{{route('admin.product.index')}}" class="btn btn-secondary text-white float-left" style="margin-bottom: 1rem;">Назад</a>
        </div>
        <div class="row">
            <!-- right column -->
            <div class="col-12">
                <!-- general form elements disabled -->
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title"></h3>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
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
                                    {{isset($product) ? route('admin.product.update', $product->slug) : route('admin.product.store')}}"
                                >
                                    @csrf
                                    @if(isset($product))
                                        @method('PUT')
                                    @endif
                                    <div class="tab-content" id="vert-tabs-tabContent">
                                        <div class="tab-pane text-left fade active show" id="vert-tabs-home" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                                            <div class="row">
                                                <div class="col-4">
                                                    @component('admin::parts.form.checkbox', [
                                                        'name' => 'is_active',
                                                        'label' => 'Включить/Отключить',
                                                        'initState' => $product->is_active ?? 1
                                                    ])
                                                    @endcomponent
                                                </div>
                                                <div class="col-4">
                                                    @component('admin::parts.form.input', [
                                                        'name' => 'sku',
                                                        'label' => 'Артикул'
                                                    ])
                                                        {{ old('sku', $product->sku ?? '') }}
                                                    @endcomponent
                                                </div>
                                                <div class="col-4">
                                                    @component('admin::parts.form.input', [
                                                        'name' => 'price',
                                                        'label' => 'Цена',
                                                        'min' => 0,
                                                        'type' => 'number',
                                                        'step' => "any"
                                                    ])
                                                        {{ old('price', $product->price ?? '') }}
                                                    @endcomponent
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    @component('admin::parts.form.input', [
                                                        'name' => 'name',
                                                        'label' => 'Название товара'
                                                    ])
                                                        {{ old('name', $product->name ?? '') }}
                                                    @endcomponent
                                                </div>
                                                <div class="col-sm-6">
                                                    @component('admin::parts.form.input', [
                                                        'name' => 'slug',
                                                        'label' => 'URI'
                                                    ])
                                                        {{ old('slug', $product->slug ?? '') }}
                                                    @endcomponent
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>
                                                            Категория
                                                        </label>
                                                        <select class="form-control js-example-categories-single" name="category_id">
                                                            <option value="">Не выбрана</option>
                                                            @if($product->category ?? false)
                                                                <option value="{{$product->category->id}}" selected>{{$product->category->name}}</option>
                                                            @endif
                                                        </select>
                                                        @error('category_id')
                                                            <span class="glyphicon form-control-feedback" class="glyphicon-remove"></span>
                                                            <span class="help-block">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    @component('admin::parts.form.input', [
                                                        'name' => 'sorting',
                                                        'label' => 'Сортировка',
                                                        'type' => 'number',
                                                        'min' => 0
                                                    ])
                                                        {{ old('sorting', $product->sorting ?? '') }}
                                                    @endcomponent
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    @component('admin::parts.form.input', [
                                                        'name' => 'quantity',
                                                        'label' => 'Количество',
                                                        'type' => 'number',
                                                        'min' => 0
                                                    ])
                                                        {{ old('quantity', $product->quantity ?? '') }}
                                                    @endcomponent
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    @component('admin::parts.form.richeditor', [
                                                        'name' => 'description',
                                                        'label' => 'Описание'
                                                    ])
                                                        {{ old('description', $product->description ?? '') }}
                                                    @endcomponent
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    @component('media::admin.form.images', [
                                                        'name' => 'image',
                                                        'model' => $product ?? null,
                                                        'label' => 'Изображения'
                                                    ])
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="vert-tabs-profile" role="tabpanel" aria-labelledby="vert-tabs-profile-tab">
                                            <div class="row">
                                                <div class="col-12">
                                                    @component('seo::admin.form.seo', [
                                                        'model' => $product ?? null,
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