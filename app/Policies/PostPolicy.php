<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Tentukan apakah user bisa mengupdate model Post.
     * @param User $user User yang sedang login
     * @param Post $post Post yang akan diupdate
     */
    public function update(User $user, Post $post): bool
    {
        // User yang sedang login harus memiliki ID yang sama dengan user_id dari Post
        return $user->id === $post->user_id;
    }

    /**
     * Tentukan apakah user bisa menghapus model Post.
     * Logikanya sama dengan update: hanya pemilik yang bisa menghapus.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
}
