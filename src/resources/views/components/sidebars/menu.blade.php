<li class="nav-item menu-items {{ isSidebarMenuActive($rangeUrlByParent, $parentName, $sidebarMenu->slug) ? 'active' : '' }}">
    <a class="nav-link level-{{$i}}"
        data-toggle="{{ $sidebarMenu->children->count() ? 'collapse' : '' }}"
        href="{{ !$sidebarMenu->children->count()
        ? (!empty($sidebarMenu->slug) ? route($sidebarMenu->slug) : null)
        : '#ui-' . $sidebarMenu->id }}"
        aria-expanded="false" >
        <span class="menu-icon {{ !empty($sidebarMenu->icon) ? '' : 'd-none' }}">
            {!! $sidebarMenu->icon !!}
        </span>
        <span class="menu-title">{{ $sidebarMenu->name }}</span>
        @if($sidebarMenu->children->count())
            <i class="menu-arrow"></i>
        @endif
    </a>
    @if($sidebarMenu->children->count())
        <div class="collapse" id="ui-{{ $sidebarMenu->id }}">
            <ul class="nav flex-column sub-menu">
                @foreach($sidebarMenu->children as $children)
                    @include('packages/core::components.sidebars.menu',
                        [
                            'sidebarMenu' => $children,
                            'i' => $i+1,
                            'nameParent' => $sidebarMenu->name,
                            'rangeUrlByParent' => $rangeUrlByParent
                        ]
                    )
                @endforeach
            </ul>
        </div>
    @endif
</li>
