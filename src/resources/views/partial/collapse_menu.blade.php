@foreach($sidebarItems as $sidebarItem)
    @if(!empty($sidebarItem->child_of) && !$sidebarItem->is_parent)
        <div class="collapse" id="ui-{{ $sidebarItem->child_of }}">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link {{ isSidebarMenuActive($sidebarItem['route'])? 'active' : '' }}"
                        href="{{ route($sidebarItem['route']) }}">
                        {{ $sidebarItem['name_package'] }}
                    </a>
                </li>
            </ul>
        </div>
    @endif
@endforeach
