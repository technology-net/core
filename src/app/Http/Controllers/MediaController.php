<?php

namespace IBoot\Core\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use IBoot\Core\App\Exceptions\ServerErrorException;
use IBoot\Core\App\Models\SystemSetting;
use IBoot\Core\App\Services\MediaService;
use IBoot\Core\App\Traits\CommonUploader;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
                'html' => view('packages/core::medias.show_folder', [
                    'media' => $media,
                    'id' => $request->id,
                    'parent' => $request->parent,
                ])->render()
            ]);
        }

        return view('packages/core::medias.index');
    }

    public function show($id): JsonResponse
    {
        $media = $this->mediaService->getAMedia($id);

        return responseSuccess($media);
    }

    /**
     * @param Request $request
     * @return JsonResponse|void
     * @throws ServerErrorException
     */
    public function uploadFiles(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->hasFile('files')) {
                $files = $request->file('files');
                $disk = $this->getDisk();
                $datas = [];
                $now = time();

                foreach ($files as $file) {
                    $image = $this->saveFile($file, '/uploads/', $now);
                    $datas[] = $this->mediaService->newMedia($file, $image, $disk, $request->parent_id, $now);
                }
                $medias = collect($datas)->sortByDesc('created_at')->sortByDesc('id');

                DB::commit();

                return $this->responseHtml($request->all(), $medias->first());
            }
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['file' => __FILE__, 'line' => __LINE__]);
            throw new ServerErrorException(null, trans('packages/core::messages.action_error'));
        }
    }

    public function downloadFile(Request $request)
    {
        $filePath = $this->mediaService->downloadFile($request->all());
        $fileName = basename($filePath);

        if (str_contains($filePath, 'webp')) {
            if (config('filesystems.default') == SystemSetting::BUNNY_CDN) {
                $disk = $this->getDisk();
                $fileContent = Storage::disk($disk)->get($filePath);

                return response()->make($fileContent, 200, [
                    'Content-Type' => 'application/octet-stream',
                    'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                ]);
            }

            return response()->download($filePath);
        } else {
            return response()->make(file_get_contents($filePath), 200, [
                'Content-Type' => 'text/plain',
                'Content-Disposition' => 'inline; filename="' . $fileName .'"',
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ServerErrorException
     */
    public function deleteFiles(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->mediaService->deleteFiles($request->all());
            DB::commit();

            return $this->responseHtml($request->all(), null, trans('packages/core::messages.delete_success'));

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
     * @param null $data
     * @param array $inputs
     * @return JsonResponse
     */
    private function responseHtml(array $inputs = array(), $data = null, $message = null): JsonResponse
    {
        $medias = $this->mediaService->getMedia($inputs['parent_id']);

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => !empty($message) ? $message : trans('packages/core::messages.save_success'),
            'html' => view('packages/core::medias.show_folder', [
                'media' => $medias,
                'id' => $inputs['parent_id'],
                'parent' => $inputs['parent']
            ])->render()
        ]);
    }
}
