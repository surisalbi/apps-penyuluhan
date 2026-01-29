<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function index()
    {
        $title = "Upload";

        $like_upload = Upload::select('id','kategori','screenshot','created_at')
        ->where('user_id', auth()->id())
        ->where('kategori', 'like')
        ->orderBy('id', 'desc')
        ->get();

        $comment_upload = Upload::select('id','kategori','screenshot','created_at')
        ->where('user_id', auth()->id())
        ->where('kategori', 'comment')
        ->orderBy('id', 'desc')
        ->get();

        $share_upload = Upload::select('id','kategori','screenshot','created_at')
        ->where('user_id', auth()->id())
        ->where('kategori', 'share')
        ->orderBy('id', 'desc')
        ->get();

        return view('upload.index', compact('title','like_upload','comment_upload','share_upload'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string',
            'screenshot' => 'required|array',
            'screenshot.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $paths = [];

        foreach ($request->file('screenshot') as $file) {
            $filename = uniqid('img_') . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs(
                'uploads/screenshots',
                $filename,
                'public'
            );

            $paths[] = $path;

            // Kalau mau simpan ke DB per file
            
            Upload::create([
                'user_id' => auth()->user()->id,
                'kategori' => $request->kategori,
                'screenshot' => $path,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Upload berhasil',
            'files' => $paths
        ]);
    }

    public function destroy($id)
    {
        // Ambil data upload dari DB
        $upload = Upload::find($id);

        if (!$upload) {
            return response()->json([
                'status' => 'error',
                'message' => 'Foto tidak ditemukan'
            ], 404);
        }

        // Hapus file dari storage (folder public/uploads/screenshots)
        if (Storage::disk('public')->exists($upload->screenshot)) {
            Storage::disk('public')->delete($upload->screenshot);
        }

        // Hapus record dari DB
        $upload->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Foto berhasil dihapus'
        ]);
    }
}
