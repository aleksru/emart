<div class="form-group">
    <label for="{{ $name }}">
        {{ $label }}
    </label>
    <textarea id="{{ $name }}" name="{{ $name }}" class="rich-editor-{{ $type ?? 'full' }}">
        {{ $slot }}
    </textarea>
</div>

@prepend('script')
    <script src="{{ asset('assets/vendors/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/vendors/ckeditor/adapters/jquery.js') }}"></script>
@endprepend
@push('script')
<script>
    $(function () {
        $('#{{ $name }}').ckeditor();
    })
</script>
@endpush