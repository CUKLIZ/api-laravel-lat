<?php

namespace App\Providers;

// Tambahkan use statement untuk Policy dan Model
use App\Models\Post;
use App\Policies\PostPolicy; 

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Pemetaan model ke policy untuk aplikasi.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Daftarkan PostPolicy di sini
        Post::class => PostPolicy::class,
    ];

    /**
     * Daftarkan layanan otorisasi aplikasi.
     */
    public function boot(): void
    {
        //
    }
}
