<?php

if (!function_exists('isSidebarMenuActive')) {
    function isSidebarMenuActive($url): bool
    {
        $currentRoute = route($url);
        $currentURL = url()->full();

        return str_starts_with($currentURL, $currentRoute);
    }
}
