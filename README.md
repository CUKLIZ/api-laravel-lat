# Laravel API: Sanctum CRUD Posts & Comments

Buat latihan bikin API dari laravel

## 🛠️ Instalasi dan Setup

Install my-project with npm

### 1. Kloning Repositori & Instalasi

```bash
# Kloning repositori ini
git clone https://github.com/CUKLIZ/api-laravel-lat.git
cd api-laravel-lat

# Instal dependensi PHP (Composer)
composer install
```

### 2. Konfigurasi Environment
Buat salinan file `.env` dari `.env.example`:
```bash
cp .env.example .env
```
Buat Application Key:
```bash
php artisan key:generate
```
Edit file `.env` dan atur kredensial database Anda (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
### 3. Migrasi database
Jalankan migrasi untuk membuat tabel `users`, `posts`, `personal_access_tokens` (Sanctum), dan `comments`.
```bash
php artisan migrate
```
### 4. Jalankan Server
```bash
php artisan serve
```
API Anda sekarang berjalan di `http://127.0.0.1:8000/api`.

## 🎯 Dokumentasi Endpoint API
Semua endpoint diakses melalui prefix `/api/`.
### 🔐 Auth
| Metode | Endpoint        | Keterangan                                              |
|--------|-----------------|---------------------------------------------------------|
| POST   | `/api/register` | Mendaftarkan user baru.                                 |
| POST   | `/api/login`    | Login user dan mengembalikan **Bearer Token**.          |
| POST   | `/api/logout`   | Menghapus token user yang sedang login.                 |
| GET    | `/api/user`     | Mendapatkan detail user yang sedang login.              |

---

### 📝 Posts
| Metode   | Endpoint                     | Keterangan                                                               |
|----------|------------------------------|--------------------------------------------------------------------------|
| GET      | `/api/posts`                 | Menampilkan daftar semua post.                                          |
| GET      | `/api/posts/{post_id}`       | Menampilkan detail post beserta komentar dan user.                      |
| POST     | `/api/posts`                 | Membuat post baru. Membutuhkan `title` dan `content`.                   |
| PUT/PATCH| `/api/posts/{post_id}`       | Memperbarui post (Hanya pemilik).                                      |
| DELETE   | `/api/posts/{post_id}`       | Menghapus post (Hanya pemilik).                                        |

---

### 💬 Comments
| Metode | Endpoint                                   | Keterangan                                                            |
|--------|--------------------------------------------|-----------------------------------------------------------------------|
| POST   | `/api/posts/{post_id}/comments`            | Membuat komentar baru pada post tertentu. Membutuhkan `content`.      |
| DELETE | `/api/comments/{comment_id}`              | Menghapus komentar (Hanya pemilik).                                  |

## 💡 Cara Menggunakan Token
Untuk mengakses endpoint yang dilindungi (Sanctum), Anda harus menyertakan token yang diperoleh dari endpoint `/api/login` di setiap permintaan:

#### Header: Authorization: Bearer `<TOKEN_ANDA>`