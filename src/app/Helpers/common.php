<?php

if (!function_exists('isSidebarMenuActive')) {
    function isSidebarMenuActive($url): bool
    {
        return route($url) == url()->full();
    }
}
