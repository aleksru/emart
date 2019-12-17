<div class="btn-group">
    <button type="button" class="btn btn-xs btn-default" onclick="copyToClipboard(this.nextElementSibling.href)">
        <i class="fa fa-link"></i>
    </button>
    <a href="{{ $route }}" class="btn btn-xs btn-default" target="_blank">
        {{ trim($display, '/') }}
    </a>
</div>