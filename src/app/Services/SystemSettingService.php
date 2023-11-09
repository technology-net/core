<?php

namespace IBoot\Core\App\Services;

use IBoot\Core\App\Models\SystemSetting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SystemSettingService
{
    /**
     * @return Collection|array
     */
    public function getLists(): Collection|array
    {
        return SystemSetting::query()->orderBy('created_at', 'desc')->get();
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
    public function createOrUpdateSystemSettings($id, array $inputs = array()): Model|Builder
    {
        return SystemSetting::query()->updateOrCreate(
            ['id' => $id],
            $inputs
        );
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteSystemSettings($id): mixed
    {
        return SystemSetting::query()->where('id', $id)->delete();
    }

    /**
     * @param $id
     * @return Model|Collection|Builder|array|null
     */
    private function findById($id): Model|Collection|Builder|array|null
    {
        return SystemSetting::query()->findOrFail($id);
    }
}
