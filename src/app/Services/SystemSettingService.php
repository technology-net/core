<?php

namespace IBoot\Core\App\Services;

use IBoot\Core\App\Models\SystemSetting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class SystemSettingService
{
    public function getLists(array $inputs = array())
    {
        $key = Arr::get($inputs, 'key', '');
        $isChange = Arr::get($inputs, 'is_change', false);

        $query = SystemSetting::query()->orderBy('created_at', 'desc');

        if (!empty($key)) {
            $query = $query->where('key', $key)
                ->orWhere('group_name', '!=', SystemSetting::FILE_SYSTEM);

            if (!empty($isChange)) {
                SystemSetting::query()->where('key', 'filesystem_disk')->update(['value' => $key]);
            }
        }

        return $query->get()->groupBy('group_name');
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

    public function getFileSystemDisk()
    {
        return SystemSetting::query()->where('key', 'filesystem_disk')->first();
    }
}
