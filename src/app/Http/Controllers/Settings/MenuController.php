<?php

namespace IBoot\Core\App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use IBoot\Core\App\Http\Requests\MenuRequest;
use IBoot\Core\App\Services\MenuItemService;
use IBoot\Core\App\Services\MenuService;
use Illuminate\Contracts\View\View;
use IBoot\Core\App\Exceptions\ServerErrorException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
class MenuController extends Controller
{
    private MenuService $menuService;
    private MenuItemService $menuItemService;

    public function __construct(
        MenuService $menuService,
        MenuItemService $menuItemService
    )
    {
        $this->menuService = $menuService;
        $this->menuItemService = $menuItemService;
    }

    /**
     * Get menus
     *
     * @param Request $request
     * @return View|string
     */
    public function index(Request $request): View|string
    {
        $menus = $this->menuService->getMenus();

        if ($request->ajax()) {
            return view('packages/core::settings.menus.menus_table', ['menus' => $menus])->render();
        }

        return view('packages/core::settings.menus.index', ['menus' => $menus]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $menuItems = $this->menuItemService->getLists()->whereNull('parent_id');
        $menu = $this->menuService->getById($id);

        return view('packages/core::settings.menus.form', compact('menu', 'menuItems'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MenuRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->menuService->createOrUpdateMenus($id, $request->all());
            DB::commit();

            return responseSuccess(null, trans('plugin/cms::messages.save_success'));
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['file' => __FILE__, 'line' => __LINE__]);
            throw new ServerErrorException(null, trans('plugin/cms::messages.action_error'));
        }
    }
}
