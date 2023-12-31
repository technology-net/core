<?php

namespace IBoot\Core\App\View\Components;

use Closure;
use IBoot\Core\App\Models\Menu;
use IBoot\Core\App\Models\MenuItem;
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
            ->whereHas('menu', function ($query) {
                $query->where('menu_type', Menu::TYPE_IS_SIDE_BAR);
            })->get();

        $rangeUrlByParent = $this->getUrlNestedChildren($sidebarMenus);

        return view('packages/core::components.sidebars.sidebar',
            [
                'sidebarMenus' => $sidebarMenus,
                'rangeUrlByParent' => $rangeUrlByParent
            ]
        );
    }

    /**
     * @param $menuItems
     * @return array
     */
    private function getUrlNestedChildren($menuItems): array
    {
        $result = [];

        foreach ($menuItems as $menuItem) {
            $result[strtolower($menuItem->name)] = $this->getUrlNestedEachChild($menuItem);
        }

        return $result;
    }

    /**
     * @param $menuItem
     * @param array $urlNestedMenuItems
     * @return array
     */
    private function getUrlNestedEachChild($menuItem, array $urlNestedMenuItems = []): array
    {
        if(!empty($menuItem->url)) {
            $urlNestedMenuItems = [
                $menuItem->url
            ];
        }

        foreach ($menuItem->children as $childMenuItem){
            $childMenu = self::getUrlNestedEachChild($childMenuItem, $urlNestedMenuItems);
            $urlNestedMenuItems = array_merge($urlNestedMenuItems, $childMenu);
        }

        return $urlNestedMenuItems;
    }
}
