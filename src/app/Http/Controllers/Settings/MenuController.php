<?php

namespace IBoot\Core\app\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use IBoot\Core\app\Services\MenuService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    private MenuService $menuService;

    public function __construct(MenuService $menuService) {
        $this->menuService = $menuService;
    }
    /**
     * Get menus
     *
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
}
