<?php

namespace IBoot\Core\App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Exception;
use IBoot\Core\App\Exceptions\ServerErrorException;
use IBoot\Core\App\Services\MediaService;
use IBoot\Core\App\Traits\CommonUploader;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MediaController extends Controller
{
    use CommonUploader;

    private MediaService $mediaService;

    public function __construct(MediaService $mediaService) {
        $this->mediaService = $mediaService;
    }

    /**
     * Get menus
     *
     * @param Request $request
     * @return View|Application|Factory|JsonResponse
     */
    public function index(Request $request): View|Application|Factory|JsonResponse
    {
        if ($request->ajax()) {
            $media = $this->mediaService->getMedia($request->id);

            return response()->json([
                'data' => $media,
                'html' => view('packages/core::settings.media.show_folder', [
                    'media' => $media,
                    'id' => $request->id,
                    'parent' => $request->parent,
                ])->render()
            ]);
        }

        return view('packages/core::settings.media.index');
    }

    public function show($id): JsonResponse
    {
        $media = $this->mediaService->getAMedia($id);

        return responseSuccess($media);
    }

    /**
     * @throws Exception
     */
    public function uploadFiles(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->hasFile('files')) {
                $files = $request->file('files');
                $disk = $this->getDisk();

                foreach ($files as $file) {
                    $image = $this->saveFile($file, '/uploads/');
                    $this->mediaService->newMedia($file, $image, $disk, $request->parent_id);
                }
                DB::commit();

                return $this->responseHtml($request->all());
            }
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
    public function createFolder(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->mediaService->makeFolder($request->all());
            DB::commit();

            return $this->responseHtml($request->all());

        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['file' => __FILE__, 'line' => __LINE__]);
            throw new ServerErrorException(null, trans('packages/core::messages.action_error'));
        }
    }

    /**
     * @param array $inputs
     * @return JsonResponse
     */
    private function responseHtml(array $inputs = array()): JsonResponse
    {
        $medias = $this->mediaService->getMedia($inputs['parent_id']);

        return response()->json([
            'success' => true,
            'message' => trans('packages/core::messages.save_success'),
            'html' => view('packages/core::settings.media.show_folder', [
                'media' => $medias,
                'id' => $inputs['parent_id'],
                'parent' => $inputs['parent']
            ])->render()
        ]);
    }
}
