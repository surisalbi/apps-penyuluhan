<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function index()
    {
        $title = "Upload";

        $like_upload = Upload::select('id','kategori','screenshot')
        ->where('user_id', auth()->id())
        ->where('kategori', 'like')
        ->get();

        $comment_upload = Upload::select('id','kategori','screenshot')
        ->where('user_id', auth()->id())
        ->where('kategori', 'comment')
        ->get();

        $share_upload = Upload::select('id','kategori','screenshot')
        ->where('user_id', auth()->id())
        ->where('kategori', 'share')
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
}
