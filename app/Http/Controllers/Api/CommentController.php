<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Comment;
use function Pest\Laravel\post;

class CommentController extends Controller
{
    public function store(Request $request, Post $post) {
        $request->validate([
            'content' => 'required|string|min:1',
        ]);

        $comment = $post->comments()->create([
            'user_id' => $request->user()->id, // User yang sedang login
            'post_id' => $post->id, // ID Post yang dikomentari
            'content' => $request->input('content'),
        ]);

        return response()->json($comment, 201);
    }

    public function destroy(Request $request, Comment $comment)
    {
        // 1. Otorisasi (Cek Kepemilikan)
        // Jika user yang login BUKAN pemilik komentar, berikan 403
        if ($request->user()->id !== $comment->user_id) {
            return response()->json(['message' => 'Unauthorized. Anda bukan pemilik komentar ini.'], 403);
        }

        // 2. Hapus Komentar
        $comment->delete();
        
        // 3. Respon Sukses
        return response()->json(['message' => 'Komentar berhasil dihapus'], 200); 
    }
}
