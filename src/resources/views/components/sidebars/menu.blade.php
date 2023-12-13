<li class="nav-item">
    <a href="{{ (!empty($sidebarMenu->url) && Route::has($sidebarMenu->url)) ? route($sidebarMenu->url) : 'javascript:void(0)' }}" class="nav-link {{ isSidebarMenuActive($rangeUrlByParent, $parentName, $sidebarMenu->url) ? 'active' : '' }}">
        <i class="nav-icon {{ !empty($sidebarMenu->icon) ? $sidebarMenu->icon : 'far fa-circle' }}"></i>
        <p>
            {{ $sidebarMenu->name }}
            @if($sidebarMenu->children->isNotEmpty())
                <i class="right fas fa-angle-left"></i>
            @endif
        </p>
    </a>
    @if($sidebarMenu->children->isNotEmpty())
        <ul class="nav nav-treeview">
            @foreach($sidebarMenu->children as $children)
                @include('packages/core::components.sidebars.menu',
                    [
                        'sidebarMenu' => $children,
                        'parentName' => $sidebarMenu->name,
                        'rangeUrlByParent' => $rangeUrlByParent
                    ]
                )
            @endforeach
        </ul>
    @endif
</li>
