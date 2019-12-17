<?php
/**
 * Air Datepicker
 * @see http://t1m0n.name/air-datepicker/docs/index-ru.html
 * 
 * @var string $position - позиция окна дэйтпикера
 * @var string $startDate - начальная дата
 * @var string $minDate - минимальная дата
 * @var string $maxDate - максимальная дата
 * @var string $dateFormat - формат даты
 * @var boolean $range - диапазон дат
 * @var string $multipleDatesSeparator - разделитель дат
 * @var boolean $timepicker - включает выбор времени
 * @var boolean $onlyTimepicker - показывать ли только таймпикер
 * @var string $dateTimeSeparator - разделитель между датой и временем
 * @var string $timeFormat - формат времени
 * @var int $hoursStep - шаг времени
 * @var int $minutesStep - шаг минут
 * @var int $minHours - минимальный час
 * @var int $maxHours - максимальный час
 * @var string $view - отображаемый вид выбора даты
 * @var string $minView - минимальный вид, который можно выбрать
 */

$onlyTimepicker = $onlyTimepicker ?? false;
$position = $position ?? '';
$startDate = $startDate ?? '';
$minDate = $minDate ?? '';
$maxDate = $maxDate ?? '';
$dateFormat = $dateFormat ?? 'yyyy-mm-dd';
$range = $range ?? false;
$multipleDatesSeparator = $multipleDatesSeparator ?? ' - ';
$timepicker = $timepicker ?? $onlyTimepicker;
$hoursStep = $hoursStep ?? 1;
$minutesStep = $minutesStep ?? 5;
$minHours = $minHours ?? 0;
$maxHours = $maxHours ?? 23;
$dateTimeSeparator = $dateTimeSeparator ?? '';
$timeFormat = $timeFormat ?? 'hh:ii';
$view = $view ?? '';
$minView = $minView ?? '';

?>

<div class="form-group {{ $errors->first($name) ? 'has-error' : '' }}">
    <label for="{{ $name }}" class="col-sm-2 control-label">
        {{ $label ?? '' }}
    </label>

    <div class="col-sm-8">
        <input class="form-control" id="datepicker-{{ $name }}" name="{{ $name }}" type="text" value="{{ $slot }}"
               autocomplete="off" placeholder="{{ $placeholder ?? '' }}">
        @if ($errors->first($name))
            <span class="glyphicon form-control-feedback" class="glyphicon-remove"></span>
            <span class="help-block">
                <strong class="text-danger">{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>

@push('script')
    <script>
        $(function () {
            $('#datepicker-{{ $name }}').datepicker({
                autoClose: true,
                @if ($dateFormat) dateFormat: '{{ $dateFormat }}', @endif
                @if ($startDate) startDate: '{{ $startDate }}', @endif
                @if ($minDate) minDate: '{{ $minDate }}', @endif
                @if ($maxDate) maxDate: '{{ $maxDate }}', @endif
                @if ($onlyTimepicker) onlyTimepicker: true, @endif
                @if ($timepicker) timepicker: true, @endif
                @if ($dateTimeSeparator) '{{ $dateTimeSeparator }}', @endif
                @if ($range) range: true, @endif
                @if ($multipleDatesSeparator) multipleDatesSeparator: '{{ $multipleDatesSeparator }}', @endif
                @if ($timeFormat) timeFormat: '{{ $timeFormat }}', @endif
                @if ($hoursStep) hoursStep: {{ $hoursStep }}, @endif
                @if ($minutesStep) minutesStep: {{ $minutesStep }}, @endif
                @if ($minHours) minHours: {{ $minHours }}, @endif
                @if ($maxHours) maxHours: {{ $maxHours }}, @endif
                @if ($position) position: '{{ $position }}', @endif
                @if ($view) view: '{{ $view }}', @endif
                @if ($minView) minView: '{{ $minView }}', @endif
            })
        })
    </script>
@endpush