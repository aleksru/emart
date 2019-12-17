<div class="form-group {{ $errors->first($name) ? 'has-error' : '' }}">
    <label for="{{ $name }}" class="col-sm-2 control-label">
        {{ $label ?? '' }}
    </label>
    
    <div class="col-sm-8">
        <textarea class="form-control" id="{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder ?? '' }}" rows="5">{{ $slot }}</textarea>
        @if ($errors->first($name))
            <span class="glyphicon form-control-feedback" class="glyphicon-remove"></span>
            <span class="help-block">
                <strong class="text-danger">{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>