<?php

if (!function_exists('isSidebarMenuActive')) {
    function isSidebarMenuActive($url): bool
    {
        if (empty($url)) return false;

        $currentRoute = route($url);
        $currentURL = url()->full();

        return str_starts_with($currentURL, $currentRoute);
    }
}
