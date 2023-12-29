<?php

use Illuminate\Support\Facades\Route;
use IBoot\Core\App\Models\SystemSetting;

if (!function_exists('isSidebarMenuActive')) {
    /**
     * @param $rangeUrlByParent
     * @param $parentName
     * @param $url
     * @return bool
     */
    function isSidebarMenuActive($rangeUrlByParent, $parentName, $url): bool
    {
        if (empty($url) || !Route::has($url)) return false;

        return in_array($url, $rangeUrlByParent[strtolower($parentName)]) && str_contains(url()->full(), route($url));
    }
}

/**
 * @param $string
 * @return bool
 */
if (!function_exists('isJSON'))
{
    function isJSON($string): bool
    {
        return is_string($string) && is_array(json_decode($string, true)) ? true : false;
    }
}

if (!function_exists('convertSize')) {
    function convertSize($item): string
    {
        $childrenCount = $item->children->count();
        if ($item->is_directory && $childrenCount > 0) {

            return $childrenCount > 1 ? $childrenCount.' items' : $childrenCount.' item';
        }

        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $pos = 0;
        while ($item->size >= 1024) {
            $item->size /= 1024;
            $pos++;
        }

        return round($item->size, 2).' '.$units[$pos];
    }
}

if (!function_exists('convertText')) {
    function convertText($input): array|string|null
    {
        $str = trim(mb_strtolower($input));
        $str = preg_replace('/([àáạảãâầấậẩẫăằắặẳẵ])/', 'a', $str);
        $str = preg_replace('/([èéẹẻẽêềếệểễ])/', 'e', $str);
        $str = preg_replace('/([ìíịỉĩ])/', 'i', $str);
        $str = preg_replace('/([òóọỏõôồốộổỗơờớợởỡ])/', 'o', $str);
        $str = preg_replace('/([ùúụủũưừứựửữ])/', 'u', $str);
        $str = preg_replace('/([ỳýỵỷỹ])/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
        $str = preg_replace('/(\s+)/', '-', $str);

        return preg_replace('/\s+?(\S+)?$/', '', substr($str, 0, 241));
    }
}

if (!function_exists('levelOptions')) {
    function levelOptions(): array
    {
        return [
            '1' => trans('packages/core::common.super_high'),
            '2' => trans('packages/core::common.high'),
            '3' => trans('packages/core::common.medium'),
            '4' => trans('packages/core::common.normal'),
        ];
    }
}

if (!function_exists('fileSystemOptions')) {
    function fileSystemOptions(): array
    {
        return [
            'disk_local' => trans('packages/core::common.disk_local'),
            'disk_s3' => trans('packages/core::common.disk_s3'),
            'disk_bunnycdn' => trans('packages/core::common.disk_bunnycdn'),
        ];
    }
}

if (!function_exists('emailConfigOptions')) {
    function emailConfigOptions(): array
    {
        return [
            'smtp' => trans('packages/core::common.smtp'),
            'ses' => trans('packages/core::common.ses'),
        ];
    }
}

if (!function_exists('getPathImage')) {
    function getPathImage($path)
    {
        if (config('filesystems.default') == SystemSetting::BUNNY_CDN) {
            return config('core.media_url') . $path;
        }
        return asset('storage' . $path);
    }
}
