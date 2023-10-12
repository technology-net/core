<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <a class="sidebar-brand brand-logo" href="/admin/dashboard"><img src="{{ asset('core/images/img.png') }}" alt="logo" /></a>
        <a class="sidebar-brand brand-logo-mini" href="/admin/dashboard"><img src="{{ asset('core/images/img.png') }}" alt="logo" /></a>
    </div>
    <ul class="nav">
        <li class="nav-item profile">
            <div class="profile-desc">
                <div class="profile-pic">
                    <div class="count-indicator">
                        <img class="img-xs rounded-circle" src="{{ asset('core/images/faces/face15.jpg') }}" alt="" />
                        <span class="count bg-success"></span>
                    </div>
                    <div class="profile-name">
                        <h5 class="mb-0 font-weight-normal">{{ Auth::user()->name }}</h5>
                        <span>Admin</span>
                    </div>
                </div>
                <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
                <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                    <a href="#" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-settings text-primary"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-onepassword text-info"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-calendar-today text-success"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">To-do list</p>
                        </div>
                    </a>
                </div>
            </div>
        </li>
        <li class="nav-item nav-category"></li>
        @foreach($sidebarItems as $sidebarItem)
            @if($sidebarItem->is_parent)
                <li class="nav-item menu-items">
                    <a class="nav-link {{ !empty($sidebarItem['route']) && isSidebarMenuActive($sidebarItem['route'])
                        ? 'active' : '' }}" data-toggle="collapse" href="#ui-{{ $sidebarItem->id }}"
                        aria-expanded="false" aria-controls="ui-{{ $sidebarItem->id }}">
                        <span class="menu-icon">
                            {!! $sidebarItem['icon'] !!}
                        </span>
                        <span class="menu-title">{{ $sidebarItem['name_package'] }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    @include('packages/core::partial.collapse_menu')
                </li>
            @elseif(empty($sidebarItem->child_of))
                <li class="nav-item menu-items
                    {{ !empty($sidebarItem['route']) && isSidebarMenuActive($sidebarItem['route'])
                        ? 'active' : '' }}">
                    <a class="nav-link" href="{{ !empty($sidebarItem['route']) ? route($sidebarItem['route']) : null }}">
                        <span class="menu-icon">
                            {!! $sidebarItem['icon'] !!}
                        </span>
                        <span class="menu-title">{{ $sidebarItem['name_package'] }}</span>
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</nav>
