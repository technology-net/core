<?php

namespace IBoot\Core\App\Services;

use IBoot\Core\App\Models\Menu;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
     * @return Model|Collection|Builder|array|null
     */
    private function findById($id): Model|Collection|Builder|array|null
    {
        return Menu::query()->findOrFail($id);
    }
}
