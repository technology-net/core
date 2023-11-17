<?php

namespace IBoot\Core\App\Services;

use IBoot\Core\App\Models\Menu;
use IBoot\Core\App\Models\MenuItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class MenuService
{
    /**
     * @return Collection|array
     */
    public function getMenus(): Collection|array
    {
        return Menu::query()->orderBy('created_at', 'desc')->get();
    }

    /**
     * @param int $id
     * @return Model|Collection|Builder|array|null
     */
    public function getById(int $id): Model|Collection|Builder|array|null
    {
        return $this->findById($id);
    }

    /**
     * @param $id
     * @param array $inputs
     * @return Model|Builder
     */
    public function createOrUpdateMenus($id, array $inputs = array()): Model|Builder
    {
        $menuItems = Arr::get($inputs, 'menu_items', []);
        unset($inputs['menu_items']);

        // store menu
        $menu = Menu::query()->updateOrCreate(
            ['id' => $id],
            $inputs
        );
        MenuItem::query()->delete();
        $arrayMenuItems = json_decode($menuItems, true);
        $this->saveMenuItems($menu->id, $arrayMenuItems);

        return $menu;
    }

    /**
     * @param $id
     * @return Model|Collection|Builder|array|null
     */
    private function findById($id): Model|Collection|Builder|array|null
    {
        return Menu::query()->findOrFail($id);
    }

    /**
     * @param $menuId
     * @param $menuItemsData
     * @param $parentId
     * @return void
     */
    private function saveMenuItems($menuId, $menuItemsData, $parentId = null): void
    {
        foreach ($menuItemsData as $key => $item) {
            // Set parent_id to the provided $parentId or use null if not available
            $item['menu_id'] = $menuId;
            $item['parent_id'] = $parentId;
            $item['order'] = $key + 1;

            // Handle the 'children' key recursively
            $children = !empty($item['children']) ? $item['children'] : null;
            unset($item['children']);

            // Update or create the current menu item
            $menuItem = MenuItem::query()->updateOrCreate(
                ['id' => $item['id']],
                $item
            );
            // Recursively save children if available
            if (!empty($children)) {
                $this->saveMenuItems($menuId, $children, $menuItem->id);
            }
        }
    }
}
