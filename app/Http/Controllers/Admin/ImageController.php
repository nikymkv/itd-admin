<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Services\Admin\HandleImageService;

class ImageController extends Controller
{
    protected $handleImage;

    public function __construct(HandleImageService $handleImage)
    {
        $this->handleImage = $handleImage;
    }

    public function show()
    {
        return view('admin.image.show');
    }

    public function getImage($path)
    {
        $url = $this->handleImage->getImageUrl($path);
        $this->sendResponse(['url' => $url], 200);
    }

    public function save(Request $request)
    {
        if ($request->hasFile('uploadImage')) {
            $this->handleImage->setImage($request->file('uploadImage'));
            $data = $this->handleImage->save();
            if ($data) {
                $this->sendResponse($data, $data['http_code']);
            } else {
                $this->sendResponse($data, $data['http_code']);
            }
        } else {
            $this->sendResponse([
                'success' => 0,
                'error_msg' => 'Input file is empty!',
            ], 400);
        }
    }

    public function handle(Request $request)
    {
        $path = $request->input('path') ?? '';
        if ( ! empty($path)) {
            $type = $request->input('type') ?? '';
            $option = $request->input('option') ?? '';
            $this->handleImage->setImageByPath($path);
            $this->handleImage->handle($type, $option);
            $data = $this->handleImage->save();
            $this->sendResponse($data, $data['http_code']);
        } else {
            abort(404);
        }
    }

    protected function sendResponse($data, $code)
    {
        return response()->json($data, $code);
    }
}
