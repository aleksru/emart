<div class="form-group {{ $errors->first($name) ? 'text-danger font-weight-bold' : '' }}">
    <label for="{{ $name }}">
        {{ $label ?? '' }}
    </label>

    <input class="form-control {{ $errors->first($name) ? ' is-invalid' : '' }}"
           id="{{ $name }}"
           name="{{ $name }}"
           type="{{ $type ?? 'text' }}"
           value="{{ $slot }}"
           placeholder="{{ $placeholder ?? '' }}"
           @if (!empty($step)) step="{{ $step }}" @endif
           @isset($disabled) disabled @endisset>
    @if ($errors->first($name))
        <span class="glyphicon form-control-feedback" class="glyphicon-remove"></span>
        <span class="help-block">
            <strong class="text-danger">{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>