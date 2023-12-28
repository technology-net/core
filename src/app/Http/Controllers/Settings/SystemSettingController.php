<?php

namespace IBoot\Core\App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use IBoot\Core\App\Exceptions\ServerErrorException;
use IBoot\Core\App\Http\Middleware\CheckPermission;
use IBoot\Core\App\Services\SystemSettingService;
use IBoot\Core\App\Models\SystemSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class SystemSettingController extends Controller
{
    private SystemSettingService $systemSetting;

    /**
     * @param SystemSettingService $systemSetting
     */
    public function __construct(SystemSettingService $systemSetting) {
        $this->systemSetting = $systemSetting;
        $this->middleware(CheckPermission::using('view system settings'))->only('index');
        $this->middleware(CheckPermission::using('create system settings'))->only('create');
        $this->middleware(CheckPermission::using('delete system settings'))->only('destroy');
    }

    public function index(Request $request)
    {
        $systemSettings = $this->systemSetting->getLists($request->all());
        $filesystemDisk = $this->systemSetting->getFileSystemDisk();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'html' => view('packages/core::settings.system_settings.include._list',  compact('systemSettings', 'filesystemDisk'))->render()
            ]);
        }

        return view('packages/core::settings.system_settings.index', compact('systemSettings', 'filesystemDisk'));
    }

    public function create(): View
    {
        return view('packages/core::settings.system_settings.form');
    }

    /**
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     * @throws ServerErrorException
     */
    public function update(Request $request, string $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->systemSetting->createOrUpdateSystemSettings($id, $request->all());
            DB::commit();

            return responseSuccess(null, trans('packages/core::messages.save_success'));
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['file' => __FILE__, 'line' => __LINE__]);
            throw new ServerErrorException(null, trans('packages/core::messages.action_error'));
        }
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws ServerErrorException
     */
    public function destroy(string $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->systemSetting->deleteSystemSettings($id);
            DB::commit();

            return responseSuccess(null, trans('packages/core::messages.delete_success'));
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['file' => __FILE__, 'line' => __LINE__]);
            throw new ServerErrorException(null, trans('packages/core::messages.action_error'));
        }
    }
}
