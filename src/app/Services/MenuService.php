<?php

namespace IBoot\Core\App\Services;

use IBoot\Core\App\Models\Menu;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MenuService
{
    /**
     * Get list of menu
     *
     * @return LengthAwarePaginator
     */
    public function getMenus(): LengthAwarePaginator
    {
        return Menu::query()->orderBy('created_at', 'desc')
            ->paginate(config('core.pagination'));
    }
}
