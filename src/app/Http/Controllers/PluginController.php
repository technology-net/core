<?php

namespace IBoot\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;
use IBoot\Core\app\Services\PluginService;
use Illuminate\Contracts\View\View;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class PluginController extends Controller
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

        return view('packages/core::plugins.index', ['sidebarItems' => $sidebarItems]);
    }

    public function install(): string
    {
        $projectRoot = base_path();

        $home = getenv('HOME');
        $path = getenv('PATH');

        $process = new Process(['npm', 'i'], $projectRoot, [
            'HOME' => $home,
            'PATH' => $path
        ]);

        $process->run();

        if ($process->isSuccessful()) {
            return $process->getOutput();
        } else {
            throw new ProcessFailedException($process);
        }
    }
}
