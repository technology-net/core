@if(count($sidebarMenu->children) > 0)
    <li class="nav-item menu-items {{ isSidebarMenuActive($sidebarMenu->slug)? 'active' : '' }}">
        <a class="nav-link level-{{$i}}"
            data-toggle="collapse" href="#ui-{{ $sidebarMenu->id }}"
            aria-expanded="false" aria-controls="ui-{{ $sidebarMenu->id }}">
            <span class="menu-icon {{ !empty($sidebarMenu->icon) ? '' : 'd-none' }}">
                {!! $sidebarMenu->icon !!}
            </span>
            <span class="menu-title">{{ $sidebarMenu->name }}</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-{{ $sidebarMenu->id }}">
            <ul class="nav flex-column sub-menu">
                @foreach($sidebarMenu->children as $children)
                    @if(!count($children->children) > 0)
                        <li class="nav-item">
                            <a class="nav-link a-level-{{ $i }}
                                {{ isSidebarMenuActive($children->slug) ? 'active' : '' }}"
                                href="{{ !empty($children->slug) ? route($children->slug) : null }}">{{ $children->name }}
                            </a>
                        </li>
                    @else
                        @include('packages/core::components.sidebars.menu', ['sidebarMenu' => $children, 'i' => $i+1])
                    @endif
                @endforeach
            </ul>
        </div>
    </li>
    @else
    <li class="nav-item menu-items {{ isSidebarMenuActive($sidebarMenu->slug)
        ? 'active' : '' }}">
        <a class="nav-link" href="{{ !empty($sidebarMenu->slug) ? route($sidebarMenu->slug) : null }}">
            <span class="menu-icon">
                {!! $sidebarMenu->icon !!}
            </span>
            <span class="menu-title">{{ $sidebarMenu->name }}</span>
        </a>
    </li>
@endif

