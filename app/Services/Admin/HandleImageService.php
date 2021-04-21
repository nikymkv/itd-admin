<?php
namespace App\Services\Admin;

use Intervention\Image\ImageManagerStatic as Image;
use Storage;

class HandleImageService
{
    protected $image;
    protected $imagePath;
    protected $imageName;
    protected $imageExt;
    protected $storageDisk;
    protected $watermarkPath;

    public function __construct()
    {
        $this->storageDisk = env('STORAGE_DISK');
        $this->watermarkPath = env('WATERMARK_PATH');
    }
    
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

    public function save($quality = null)
    {
        $quality = $quality ?? config('QUALITY_IMAGE');
        $storagePath = $this->getStoragePath();
        $this->imageName = time() . uniqid();
        $this->imageExt = $this->getExtension();
        $this->imagePath = $storagePath . $this->imageName . '.' . $this->imageExt;

        if ($this->image->save($this->imagePath, $quality)) {
            $hash = md5_file($this->imagePath);
            return [
                'success' => 1,
                'path' => $storagePath,
                'hash' => $hash,
                'url' => Storage::disk($this->storageDisk)->url($this->imageName . '.' . $this->imageExt),
                'filesize' => $this->image->filesize(),
                'http_code' => 200,
            ];
        } else {
            return [
                'success' => 0,
                'error_msg' => 'Failed to save image',
                'http_code' => 501,
            ];
        }
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

    public function setImageByPath($path)
    {
        if ( ! Storage::disk($this->storageDisk)->exists($path)) {
            abort('404');
        } else {
            $this->image = Image::make(Storage::disk($this->storageDisk)->path($path));
        }
    }

    public function getImageUrl($path)
    {
        if ( ! Storage::disk($this->storageDisk)->exists($path)) {
            abort('404');
        } else {
            return Storage::disk($this->storageDisk)->url($path);
        }
    }

    protected function crop($option)
    {
        $originalWidth = $this->image->width();
        $originalHeight = $this->image->height();
        if ($originalWidth < $option['width'] + $option['x'] || $originalHeight < $option['height'] + $option['y']) {
            abort(422);
        }

        $this->image->crop(
            $option['width'],
            $option['height'],
            $option['x'],
            $option['y']
        );
        return $this->save(100);
    }

    protected function compress($option)
    {
        return $this->save($option['quality']);
    }

    protected function watermark($option)
    {
        $watermarkPath = $this->getWatermark();
        $this->image
            ->insert($watermarkPath, 'bottom-right', 10, 10);
        return $this->save(100);
    }

    protected function resize($option)
    {
        $this->image->resize($option['width'], $option['height'], function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        return $this->save(100);
    }

    protected function changeOrientation($option)
    {
        $this->image->rotate(90);
        return $this->save(100);
    }

    protected function getWatermark()
    {
        $fullPath = $this->getStoragePath() . $this->watermarkPath;
        return Image::make($fullPath)->fit(50);
    }

    protected function getStoragePath()
    {
        return Storage::disk($this->storageDisk)
            ->getAdapter()
            ->getPathPrefix();
    }
}