<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CloudinaryModel;

class CloudinaryController extends Controller
{
    protected $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new CloudinaryModel();
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
            'folder' => 'nullable|string'
        ]);

        $result = $this->cloudinary->upload($request->file('image'), $request->folder);

        return response()->json([
            'public_id' => $result->getPublicId(),
            'url' => $result->getSecurePath()
        ]);
    }

    public function listAssets(Request $request)
    {
        $folder = $request->path ?? env('CLOUDINARY_FOLDER'); // nếu không có path thì mặc định là thư mục gốc

        $data = $this->cloudinary->listAssets($folder);
        $folders = $data['folders'] ?? [];
        $files = $data['files'] ?? [];

        return view('admin.media.index', compact('folders', 'files', 'folder'));
    }
    public function getAssets(Request $request)
    {
        $folder = $request->path ?? env('CLOUDINARY_FOLDER'); // nếu không có path thì mặc định là thư mục gốc

        $data = $this->cloudinary->listAssets($folder);
        $folders = $data['folders'] ?? [];
        $files = $data['files'] ?? [];
        return response()->json([
            'folder' => $folder,
            'folders' => $folders,
            'files' => $files
        ]);
    }

    public function deleteImage(Request $request)
    {
        $request->validate(['public_id' => 'required|string']);
        $result = $this->cloudinary->deleteImage($request->public_id);
        return response()->json(['result' => $result]);
    }

    public function deleteFolder($folder)
    {
        try {
            $result = $this->cloudinary->deleteFolder($folder);
            return response()->json(['result' => $result]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getImageUrl($publicId)
    {
        $url = $this->cloudinary->getImageUrl($publicId);
        return response()->json(['url' => $url]);
    }

    public function listSubFolders($parent = '')
    {
        try {
            $folders = $this->cloudinary->listSubFolders($parent);
            return response()->json(['folders' => $folders]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
