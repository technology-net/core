<?php

namespace IBoot\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;
use IBoot\Core\app\Services\PluginService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class HomeController extends Controller
{
    private PluginService $pluginService;

    public function __construct(PluginService $pluginService)
    {
        $this->pluginService = $pluginService;
    }

    /**
     * Get layout
     *
     * @return View
     */
    public function index(): View
    {
        $sidebarItems = $this->pluginService->getInstalledPlugins();

        return view('packages/core::layouts.admin', ['sidebarItems' => $sidebarItems]);
    }
}
