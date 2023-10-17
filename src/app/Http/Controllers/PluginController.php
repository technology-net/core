<?php

namespace IBoot\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;
use IBoot\Core\app\Services\PluginService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
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
        $plugins = $this->pluginService->getAllPlugins();

        return view('packages/core::plugins.index', ['plugins' => $plugins]);
    }

    /**
     * Install a package
     *
     * @param Request $request
     * @return string
     */
    public function install(Request $request): string
    {
        $input = $request->all();
        $command = ['composer', 'install', $input->composer_name];

        return $this->installPackage($command);
    }

    /**
     * Uninstall a package
     *
     * @param Request $request
     * @return string
     */
    public function uninstall(Request $request): string
    {
        $input = $request->all();
        $command = ['composer', 'remove', $input->composer_name];

        return $this->installPackage($command);
    }


    /**
     * Install or uninstall logic
     *
     * @param $command
     * @return string
     */
    private function installPackage($command): string
    {
        $projectRoot = base_path();

        $home = getenv('HOME');
        $path = getenv('PATH');

        $process = new Process($command, $projectRoot, [
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
