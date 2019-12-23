
@php

$header           = $header ?? true;
$header_2         = $header_2 ?? false;

@endphp

@if (isset($model))
    
    {{-- SEO HEADER --}}
    @if ($header)
        <div class="form-group">
            <label for="seo-header" class="col-sm-2 control-label">
                Заголовок H1
            </label>
            <div class="col-sm-8">
                <input id="seo-header" class="form-control" type="text" value="{{ old('seo.header', $model->seo->header ?? '') }}"
                       name="seo[header]" placeholder="Введите SEO заголовок H1">
            </div>
        </div>
    @endif

    {{-- SEO HEADER --}}
    @if ($header_2)
        <div class="form-group">
            <label for="seo-header_2" class="col-sm-2 control-label">
                Заголовок H2
            </label>
            <div class="col-sm-8">
                <input id="seo-header_2" class="form-control" type="text" value="{{ old('seo.header_2', $model->seo->header_2 ?? '') }}"
                       name="seo[header_2]" placeholder="Введите SEO заголовок H1">
            </div>
        </div>
    @endif

    {{-- SEO TITLE --}}
    <div class="form-group">
        <label for="seo-title" class="col-sm-2 control-label">
            Заголовок браузера
        </label>
        <div class="col-sm-8">
            <input id="seo-title" class="form-control" type="text" value="{{ old('seo.title', $model->seo->title ?? '') }}"
                   name="seo[title]" placeholder="Введите SEO заголовок страницы в браузере">
        </div>
    </div>

    {{-- SEO KEYWORDS --}}
    <div class="form-group">
        <label for="seo-keywords" class="col-sm-2 control-label">
            Ключевые слова для меты
        </label>
        <div class="col-sm-8">
            <input id="seo-keywords" class="form-control" type="text" value="{{ old('seo.keywords', $model->seo->keywords ?? '') }}"
                   name="seo[keywords]" placeholder="Введите ключевые слова для мета тэга">
        </div>
    </div>

    {{-- SEO DESCRIPTIONS --}}
    <div class="form-group">
        <label for="seo-description" class="col-sm-2 control-label">
            Описание для меты
        </label>
        <div class="col-sm-8">
            <textarea class="form-control" id="seo-description" name="seo[description]" placeholder="Введите описание для мета тэга" rows="5">{{ old('seo.description', $model->seo->description ?? '') }}</textarea>
        </div>
    </div>

    

@else

    <div class="form-group">
        <label for="seo-disabled" class="col-sm-2 control-label">
            SEO информация
        </label>
        <div class="col-sm-8">
            <input id="seo-disabled" class="form-control" value="Для редактирования SEO сохраните изменения!" disabled>
        </div>
    </div>

@endif

