<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cloudinary\Cloudinary as CloudinaryCore;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CloudinaryModel
{
    protected $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new CloudinaryCore([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
            'url' => ['secure' => true]
        ]);
    }

    public function upload($file, $folder = 'default')
    {
        return Cloudinary::upload($file->getRealPath(), ['folder' => $folder]);
    }

    public function listAssets($folder)
    {
        try {
            $files = $this->cloudinary->adminApi()->assetsByAssetFolder($folder)['resources'] ?? [];
            $folders = $this->cloudinary->adminApi()->subFolders($folder)['folders'] ?? [];

            return [
                'folders' => $folders,
                'files' => $files,
            ];
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }


    public function deleteImage($publicId)
    {
        return Cloudinary::destroy($publicId);
    }

    public function deleteFolder($folder)
    {
        return $this->cloudinary->adminApi()->deleteFolder($folder);
    }

    public function getImageUrl($publicId)
    {
        return Cloudinary::getUrl($publicId);
    }

    public function listSubFolders($parent = '')
    {
        return $this->cloudinary->adminApi()->subFolders($parent)['folders'] ?? [];
    }
}
