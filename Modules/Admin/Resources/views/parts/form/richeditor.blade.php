
<label>{{ $label }}</label>
<textarea id="{{ $name }}" name="{{ $name }}">{{ $slot }}</textarea>

@push('script')
    <script>
        $(function () {
            ClassicEditor
                .create( document.querySelector( '#{{ $name }}' ) )
                .catch( error => {
                    console.error( error );
                } );
        })
    </script>
@endpush