<?php

namespace IBoot\Core\App\Services;

use IBoot\Core\App\Models\MenuItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class MenuItemService
{
    /**
     * @return Collection|array
     */
    public function getLists(): Collection|array
    {
        return MenuItem::query()
            ->with('children')
            ->orderBy('order')
            ->get();
    }
    /**
     * Get max order now in menu items table
     *
     * @return mixed
     */
    public function getMaxOrderNow(): mixed
    {
        return MenuItem::query()->max('order');
    }

    /**
     * Create new menu
     *
     * @param $input
     * @return Model|Builder
     */
    public function storeMenu($input): Model|Builder
    {
        return MenuItem::query()->create($input);
    }

    /**
     * Remove menu
     *
     * @param $namePackage
     * @return mixed
     */
    public function removeMenu($namePackage): mixed
    {
        return MenuItem::query()
            ->where('name', $namePackage)
            ->with('children')
            ->firstOrFail()
            ->delete();
    }
}
