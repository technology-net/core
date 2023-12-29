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
        if (!empty($key)) {
            $keys = explode(',', $key);
        }
        $isChange = Arr::get($inputs, 'is_change', false);

        $query = SystemSetting::query()->orderBy('id');

        if (!empty($keys)) {
            $query = $query->whereIn('key', $keys)
                ->orWhereNotIn('group_name', [
                    SystemSetting::FILE_SYSTEM, SystemSetting::EMAIL_CONFIG
                ]);

            if (!empty($isChange)) {
                // this code only handle for case key = filesystem_disk
                if (in_array($keys[0], [
                    SystemSetting::BUNNY_CDN, SystemSetting::S3, SystemSetting::LOCAL
                ])) {
                    SystemSetting::query()->where('key', 'filesystem_disk')->update(['value' => $keys[0]]);
                }

                // this code only handle for case key = transport
                if (in_array($keys[1], [
                    SystemSetting::TRANSPORT_SMTP, SystemSetting::TRANSPORT_SES
                ])) {
                    SystemSetting::query()->where('key', 'transport')->update(['value' => $keys[1]]);
                }
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

    public function getFileSystemDisk($value)
    {
        return $this->fistByValue($value);
    }

    private function fistByValue($value)
    {
        return SystemSetting::query()->where('key', $value)->first();
    }
}
