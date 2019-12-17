

@if ($model)
    
@php ($type = $type ?? $name) @endphp
@php ($modelClass = str_replace('\\', '\\\\', get_class($model))) @endphp
@php ($single = $model->getMedia()[$name]['single'] ?? false) @endphp

@pushonce('css', 'dropzone')
    <link href="{{asset('compiled/css/modules/media/app.css')}}" rel="stylesheet">
@endpushonce

<div class="form-group {{ $errors->first($name) ? 'has-errors' : '' }}">
    <label for="{{ $name }}" class="col-sm-2 control-label">
        {{ $label ?? '' }}
    </label>
    <div class="col-sm-8">
        <div id="dropzone-{{ $name }}" style="width: 100%; min-height: 200px;">
            <div class="dz-message needsclick">
                Добавьте или перетащите файлы для загрузки.
            </div>
        </div>
    </div>
</div>

@pushonce('script', 'dropzone')
    <script src="{{ asset('compiled/js/modules/media/app.js') }}"></script>
@endpushonce

@push('script')
    <script>
        $(function () {
            let dropzone = new Dropzone('#dropzone-{{ $name }}', {
                dictRemoveFile: 'Удалить',
                addRemoveLinks: true,
                paramName: 'image',
                parallelUploads: 5,
                createImageThumbnails: true,
                sending: function(file, xhr, formData) {
                    formData.append('id', '{{ $model->id }}');
                    formData.append('model', '{{ $modelClass }}');
                    formData.append('type', '{{ $type }}');
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                @if ($single)
                url: '{{ route('admin.media.images.replace') }}',
                @else
                url: '{{ route('admin.media.images.upload') }}',
                @endif
                init: function () {
                    /**
                     * Добавляем уже существующие файлы
                     */
                    @if (!$single)
                    let images = {!! $model->$name !!};
                    @else
                    let images = [@if ($model->$name) {!! json_encode($model->$name) !!} @endif];
                    @endif
                            
                    images.forEach((file) => {
                        let image = {
                            size:   file.size,
                            name:   file.path,
                            id:     file.id,
                        };

                        /**
                         * Все это требуется, чтобы правильно добавить файл в dropzone
                         * (запустить все события, учесть настройки и т.д.)
                         */
                        this.files.push(image);
                        this.emit('addedfile', image);
                        this.emit('thumbnail', image, '/' + image.name);
                        this.emit('processing', image);
                        this.emit('success', image, { image_id: image.id }, false);
                        this.emit('complete', image);
                    });
                    /**
                     * Обработчик для удаления файлов
                     */
                    this.on('removedfile', function (file) {
                        if (!file.name)
                            return;

                        axios.post('{{ route('admin.media.images.delete') }}', {
                            id: '{{ $model->id }}',
                            model: '{{ $modelClass }}',
                            type: '{{ $type }}',
                            image_id: file.id
                        });
                    });

                    /**
                     * Ставим id изображения, приходящее с сервера.
                     */
                    this.on('success', function (file, response) {
                        file.id = response.image_id;
                    });

                    @if ($single)
                        this.on('addedfile', function () {
                        if (this.files[1] != null) {
                            this.removeFile(this.files[0]);
                        }
                    });
                    @endif
                }

            });

            $('#dropzone-{{ $name }}').addClass('dropzone');
        })
    </script>
@endpush
    
@else
    
<div class="form-group {{ $errors->first($name) ? 'has-errors' : '' }}">
    <label for="{{ $name }}" class="col-sm-2 control-label">
        {{ $label ?? '' }}
    </label>
    <div class="col-sm-8">
        <input class="form-control" value="Для загрузки изображений сохраните изменения!" disabled>
    </div>
</div>
    
@endif




