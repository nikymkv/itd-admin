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
        dd($this->handleImage->getImage($path));

    }

    public function save(Request $request)
    {
        if ($request->hasFile('uploadImage')) {
            $this->handleImage->setImage($request->file('uploadImage'));
            $data = $this->handleImage->save();
            
            return \response()->json([
                'success' => $data ? 1 : 0,
                'url' => $data['url'],
            ], 200);
        }
    }

    public function handle(Request $request)
    {
        $path = $request->input('path') ?? '';
        if ( ! empty($path)) {
            $type = $request->input('type') ?? '';
            $option = $request->input('option') ?? '';
            $this->handleImage->getImage($path);
            $this->handleImage->handle($type, $option);
            $this->handleImage->save();
            return back();
        } else {
            abort(404);
        }
    }

 
}
