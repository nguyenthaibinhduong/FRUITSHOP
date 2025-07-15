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

    public function upload($file, $folder = '')
    {
        try {
            return $this->cloudinary->uploadApi()->upload($file->getRealPath(), [
                'folder' => $folder ?: env('CLOUDINARY_FOLDER'),
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
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
    function getPublicIdFromUrl($url, $folder)
    {
        // Bước 1: parse URL để lấy path
        $parsedUrl = parse_url($url, PHP_URL_PATH);

        // Bước 2: Tìm vị trí thư mục trong đường dẫn
        $pos = strpos($parsedUrl, $folder);
        if ($pos === false) {
            return null; // Không tìm thấy folder trong URL
        }

        // Bước 3: Cắt từ vị trí thư mục đến hết và loại bỏ phần mở rộng
        $path = substr($parsedUrl, $pos); // ví dụ: fruit_shop/product/image123.jpg
        $pathWithoutExt = preg_replace('/\.[^.]+$/', '', $path); // loại bỏ .jpg, .png

        return $pathWithoutExt; // Trả về public_id
    }
}
