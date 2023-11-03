<?php

namespace IBoot\Core\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use IBoot\Core\App\Exceptions\ServerErrorException;
use IBoot\Core\App\Models\Plugin;
use IBoot\Core\App\Services\MenuItemService;
use IBoot\Core\App\Services\PluginService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class PluginController extends Controller
{
    private PluginService $pluginService;
    private MenuItemService $menuItemService;

    public function __construct(PluginService $pluginService, MenuItemService $menuItemService)
    {
        $this->pluginService = $pluginService;
        $this->menuItemService = $menuItemService;
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
     * @return JsonResponse
     * @throws ServerErrorException
     */
    public function install(Request $request): JsonResponse
    {
        $input = $request->all();
        $menuItem = json_decode($input['menu_items'], true);
        $namePackage = $input['name_package'];
        $pluginId = $input['plugin_id'];

        try {
            DB::beginTransaction();
            $command = ['composer', 'install', $input->composer_name];
            $this->installPackage($command);
            $this->storeMenuItems($menuItem, null, $namePackage);
            $this->pluginService->updateStatusPlugin($pluginId, Plugin::STATUS_INSTALLED);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new ServerErrorException(null,
                trans('packages/core::messages.install_package_fail', ['package' => $namePackage]));
        }

        return responseSuccess(null,
            trans('packages/core::messages.install_package_success', ['package' => $namePackage]));
    }

    /**
     * Store menu items
     *
     * @param $menuItem
     * @param $parentId
     * @param $namePackage
     * @return void
     * @throws ServerErrorException
     */
    public function storeMenuItems($menuItem, $parentId, $namePackage): void
    {
        if ($menuItem !== null) {
            $maxOrderNow = $this->menuItemService->getMaxOrderNow();
            $input = [
                'menu_id' => 1,
                'name' => $menuItem['name'],
                'icon' => $menuItem['icon'],
                'parent_id' => $parentId,
                'order' => $maxOrderNow + 1,
                'slug' => $menuItem['slug'],
            ];

            $newMenuItem = $this->menuItemService->storeMenu($input);

            if (!$newMenuItem) {
                throw new ServerErrorException(null, trans('packages/core::messages.something_went_wrong'));
            }
        }

        if (!empty($menuItem['children'])) {
            foreach ($menuItem['children'] as $child) {
                $this->storeMenuItems($child, $newMenuItem->id, $namePackage);
            }
        }
    }

    /**
     * Uninstall a package
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ServerErrorException
     */
    public function uninstall(Request $request): JsonResponse
    {
        $input = $request->all();
        $namePackage = $input['name_package'];
        $pluginId = $input['plugin_id'];

        try {
            DB::beginTransaction();
            $command = ['composer', 'remove', $input->composer_name];
            $this->installPackage($command);
            $this->menuItemService->removeMenu($namePackage);
            $this->pluginService->updateStatusPlugin($pluginId, Plugin::STATUS_UNINSTALLED);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new ServerErrorException(null,
                trans('packages/core::messages.uninstall_package_fail', ['package' => $namePackage]));
        }

        return responseSuccess(null,
            trans('packages/core::messages.uninstall_package_success', ['package' => $namePackage]));
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
