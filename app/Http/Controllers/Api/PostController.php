<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $post = Post::with('user')->get();
        return response()->json($post);
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = Post::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'content' => $request->input('content'),
        ]);

        // Ini adalah sumber status 201 Created
        return response()->json($post, 201); 
    }

    public function show(Post $post)
    {
        return response()->json($post->load('user', 'comments.user'));
    }

    public function update(Request $request, Post $post)
    {
        // Cek Otorisasi: Hanya pemilik post yang bisa mengupdate
        if ($request->user()->id !== $post->user_id) {
            return response()->json(['message' => 'Unauthorized. Anda bukan pemilik post ini.'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update($request->only('title', 'content'));
        return response()->json($post); 
    }

    public function destroy(Request $request, Post $post)
    {
        // Cek Otorisasi: Hanya pemilik post yang bisa menghapus
        if ($request->user()->id !== $post->user_id) {
            return response()->json(['message' => 'Unauthorized. Anda bukan pemilik post ini.'], 403);
        }

        $post->delete();
        // Status 200 atau 204 adalah standar untuk DELETE.
        return response()->json(['message' => 'Post deleted successfully'], 200); 
    }
}
