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

        return in_array($url, $rangeUrlByParent[strtolower($parentName)]) && route($url) === url()->full();
    }
}
