<?php

namespace IBoot\Core\app\Services;

use IBoot\Core\app\Models\Plugin;
use Illuminate\Database\Eloquent\Collection;

class PluginService
{
    /**
     * List of plugins
     *
     * @return Collection
     */
    public function getAllPlugins(): Collection
    {
        return Plugin::query()->get();
    }
}
