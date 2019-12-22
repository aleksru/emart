<div class="form-group">
    <label>
        {{ $label ?? '' }}
    </label>
    <input id="hide_switch_{{$name}}" name="{{$name}}" value="{{old($name, (int)$initState)}}" style="display: none">
    <input id="switch_{{$name}}" type="checkbox">
</div>

@push('script')
    <script>
        $(function() {
            $('#switch_{{$name}}').bootstrapSwitch('state', parseInt($('#hide_switch_{{$name}}').val()));
            $('#switch_{{$name}}').bootstrapSwitch('onSwitchChange', function onSwitchChange(e, state) {
                if(state){
                    $('#hide_switch_{{$name}}').val(1)
                }else{
                    $('#hide_switch_{{$name}}').val(0)
                }
            });
        });
    </script>
@endpush
