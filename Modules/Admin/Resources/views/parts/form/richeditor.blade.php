<div class="form-group">
    <label for="{{ $name }}" class="col-sm-2 control-label">
        {{ $label }}
    </label>
    <div class="col-sm-8">
        <textarea id="{{ $name }}" name="{{ $name }}" class="rich-editor-{{ $type ?? 'full' }}">
            {{ $slot }}
        </textarea>
    </div>
</div>

@pushonce('script', 'ckeditor')
    <script src="{{ asset('assets/vendors/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/vendors/ckeditor/adapters/jquery.js') }}"></script>
@endpushonce
@push('script')
    <script>
        $(function () {
            $('#{{ $name }}').ckeditor();
        })
    </script>
@endpush