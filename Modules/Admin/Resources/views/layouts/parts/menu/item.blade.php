<li class="nav-item">
    <a href="{{isset($menu['route']) ? route($menu['route']) : '#'}}" class="nav-link {{active($menu['active'])}}">
        <i class="{{ $menu['icon'] ?? 'far fa-circle nav-icon'}}"></i>
        <p>{{$menu['name']}}</p>
    </a>
</li>
