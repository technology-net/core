<?php

namespace IBoot\Core\app\Services;

use IBoot\Core\app\Models\Plugin;

class PluginService
{
    private Plugin $plugin;

    public function __construct(Plugin $plugin)
    {
        $this->plugin = $plugin;
    }

    public function getInstalledPlugins()
    {
        return $this->plugin->where('status', Plugin::STATUS_INSTALLED)->get();
    }

}
