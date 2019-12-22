<li class="nav-item has-treeview {{active($menu['active']) ? 'menu-open' : ''}}">
    <a href="#" class="nav-link {{active($menu['active'])}}">
        <i class="{{$menu['icon'] ?? 'nav-icon fas fa-tachometer-alt'}}"></i>
        <p>
            {{$menu['name']}}
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @foreach($menu['sub_categories'] as $sub_category)
            @if(isset($sub_category['sub_categories']))
                @include('admin::layouts.parts.menu.list', ['menu' => $sub_category])
            @else
                @include('admin::layouts.parts.menu.item', ['menu' => $sub_category])
            @endif
        @endforeach
    </ul>
</li>
