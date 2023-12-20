<?php

namespace IBoot\Core\App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use IBoot\Core\App\Exceptions\ServerErrorException;
use IBoot\Core\App\Http\Requests\SystemSettingRequest;
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
    }

    /**
     * @return View|string
     */
    public function index(): View|string
    {
        $this->authorize('viewAny', SystemSetting::class);
        $systemSettings = $this->systemSetting->getLists();

        return view('packages/core::settings.system_settings.index', compact('systemSettings'));
    }

    public function create(): View
    {
        $this->authorize('create', SystemSetting::class);
        return view('packages/core::settings.system_settings.form');
    }

    /**
     * @param SystemSettingRequest $request
     * @param string $id
     * @return JsonResponse
     * @throws ServerErrorException
     */
    public function update(SystemSettingRequest $request, string $id): JsonResponse
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
            $this->authorize('delete', SystemSetting::class);
            $this->systemSetting->deleteSystemSettings($id);
            DB::commit();

            return responseSuccess(null, trans('packages/core::messages.delete_success'));
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['file' => __FILE__, 'line' => __LINE__]);
            throw new ServerErrorException(null, trans('packages/core::messages.action_error'));
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws ServerErrorException
     */
    public function editable(Request $request, $id): JsonResponse
    {
        $cleanedJsonString = parseHtmlToJson($request['value']);
        $request['value'] = $cleanedJsonString;

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
     * @param Request $request
     * @return JsonResponse
     * @throws ServerErrorException
     */
    public function deleteAll(Request $request): JsonResponse
    {
        $ids = $request->ids;
        DB::beginTransaction();
        try {
            $this->systemSetting->deleteAllById($ids);
            DB::commit();

            return responseSuccess(null, trans('packages/core::messages.delete_success'));
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['file' => __FILE__, 'line' => __LINE__]);
            throw new ServerErrorException(null, trans('packages/core::messages.action_error'));
        }
    }
}
