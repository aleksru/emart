<div class="form-group {{ $errors->first($name) ? 'has-error' : '' }}">
    <label for="{{ $name }}" class="col-sm-2 control-label">
        {{ $label ?? '' }}
    </label>
    
    <div class="col-sm-8">
        <input class="form-control" id="{{ $name }}" name="{{ $name }}" type="{{ $type ?? 'text' }}" value="{{ $slot }}"
           placeholder="{{ $placeholder ?? '' }}" @if (!empty($step)) step="{{ $step }}" @endif @isset($disabled) disabled @endisset>
        @if ($errors->first($name))
            <span class="glyphicon form-control-feedback" class="glyphicon-remove"></span>
            <span class="help-block">
                <strong class="text-danger">{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>