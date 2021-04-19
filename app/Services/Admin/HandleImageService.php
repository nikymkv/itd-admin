<?php
namespace App\Services\Admin;

use Intervention\Image\ImageManagerStatic as Image;
use Storage;

class HandleImageService
{
    protected $image;
    

    public function handle($type, $option)
    {
        switch ($type) {
            case 'crop':
                $this->crop($option);
                break;
            case 'compress':
                $this->compress($option);
                break;
            case 'watermark':
                $this->watermark($option);
                break;
            case 'resize':
                $this->resize($option);
                break;
            case 'changeOrientation':
                $this->changeOrientation($option);
                break;
        }
    }

    public function save()
    {
        $filename = time() . \uniqid();
        $ext = $this->getExtension();
        $storagePath = $filename . '.' . $ext;
        if (Storage::disk('public')->put($storagePath, $this->image->encode($ext, 100))) {
            $hash = md5_file(storage_path('app/public/' . $storagePath));
            return [
                'path' => $storagePath,
                'hash' => $hash,
                'url' => Storage::disk('public')->url($storagePath),
            ];
        }

        return [];
    }

    protected function getExtension()
    {
        $extension = '';
        switch($this->image->mime()) {
            case 'image/jpeg':
                $extension = 'jpeg';
                break;
            case 'image/jpg':
                $extension = 'jpg';
                break;
            case 'image/png':
                $extension = 'png';
                break;
            case 'image/gif':
                $extension = 'gif';
                break;
        }

        return $extension;
    }

    public function setImage($image)
    {
        $this->image = Image::make($image);
    }

    public function getImage($path)
    {
        if ( ! Storage::disk('public')->exists($path)) {
            abort('404');
        } else {
            $url = Storage::disk('public')->url($path);
            $path = Storage::disk('public')->path($path);
            $this->image = Image::make($path);
            return $url;
            // return $path;
        }
    }

    protected function crop($option)
    {
        dd('crop');
    }

    protected function compress($option)
    {
        dump($this->image->filesize(), $option['quality'], $this->getExtension());
        $this->image = $this->image->encode($this->getExtension(), (int)$option['quality']);
        dd($this->image->filesize());
    }

    protected function watermark($option)
    {
        dump('watermark');
    }

    protected function resize($option)
    {
        dump('resize');
    }

    protected function changeOrientation($option)
    {
        dump('changeOrientation');
    }


}