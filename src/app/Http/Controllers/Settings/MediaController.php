<?php

namespace IBoot\Core\App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Exception;
use IBoot\Core\App\Services\MediaService;
use IBoot\Core\App\Traits\CommonUploader;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
                'html' => view('packages/core::settings.media.show_folder', ['media' => $media, 'id' => $request->id])->render()
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
    public function uploadFiles(Request $request): JsonResponse
    {
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            $folderPath = '/uploads';

            foreach ($files as $file) {
                $fileName = time() . '_' . convertText($file->getClientOriginalName());

                $this->mediaService->newMedia($file, $fileName, $folderPath, $request->parent_id);

                $this->saveFile($file, $fileName, $folderPath);
            }

            return responseSuccess(null, 'Tải lên thành công');
        }
    }
}
