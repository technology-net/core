<?php

namespace IBoot\Core\app\View\Components;

use Closure;
use IBoot\Core\app\Models\MenuItem;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $sidebarMenus = MenuItem::query()
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('order')
            ->get();
        view()->share('sidebarMenus', $sidebarMenus);

        return view('packages/core::components.sidebars.sidebar', ['sidebarMenus' => $sidebarMenus]);
    }
}
