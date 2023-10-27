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
