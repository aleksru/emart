@if ($check)
    <button class="btn btn-xs btn-success btn-toggle" data-route="{{ $route }}" data-id="{{ $id }}" data-status="activated">
        <i class="fa fa-check"></i>
    </button>
@else
    <button class="btn btn-xs btn-warning btn-toggle" data-route="{{ $route }}" data-id="{{ $id }}" data-status="deactivated">
        <i class="fa fa-ban"></i>
    </button>
@endif