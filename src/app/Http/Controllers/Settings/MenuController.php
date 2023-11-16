<?php

namespace IBoot\Core\App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use IBoot\Core\App\Services\MenuItemService;
use IBoot\Core\App\Services\MenuService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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
}
