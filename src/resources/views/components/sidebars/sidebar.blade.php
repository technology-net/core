<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard.index') }}" class="brand-link">
        <img src="{{ asset('core/images/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('core.copyright') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @php
                    $avatar = Auth::user()->medias->isNotEmpty() ? Auth::user()->medias[0]->image_sm : '';
                @endphp
                <img src="{{ !empty(session('avatar_' . session('user_id'))) ? getPathImage(session('avatar_' . session('user_id'))) : $avatar }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @foreach($sidebarMenus as $sidebarMenu)
                    @include('packages/core::components.sidebars.menu',
                        [
                            'sidebarMenu' => $sidebarMenu,
                            'parentName' => $sidebarMenu->name,
                            'rangeUrlByParent' => $rangeUrlByParent
                        ]
                    )
                @endforeach
            </ul>
        </nav>
    </div>
</aside>
