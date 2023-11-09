<?php

if (!function_exists('isSidebarMenuActive')) {
    /**
     * @param $rangeUrlByParent
     * @param $parentName
     * @param $url
     * @return bool
     */
    function isSidebarMenuActive($rangeUrlByParent, $parentName, $url): bool
    {
        if (empty($url)) return false;

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

/**
 * @param $jsonString
 * @return string
 */
if (!function_exists('renderJsonAsHtml'))
{
    function renderJsonAsHtml($jsonString): string
    {
        $data = json_decode($jsonString);
        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            return "Invalid JSON";
        }

        return json_encode($data, JSON_PRETTY_PRINT);
    }
}

/**
 * @param $html
 * @return array|string|string[]
 */
if (!function_exists('parseHtmlToJson'))
{
    function parseHtmlToJson($html) {
        return str_replace(["\n", "\t", "\r", " "], "", $html);
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
