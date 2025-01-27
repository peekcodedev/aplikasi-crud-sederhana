# Aplikasi CRUD Sederhana 🚀

Aplikasi CRUD (Create, Read, Update, Delete) sederhana yang dibangun menggunakan **PHP**, **MySQL**, **HTML**, dan **CSS**. Project ini cocok untuk pemula yang ingin belajar dasar-dasar pengembangan web dan operasi database.

---

## Fitur yang Sudah Ditambahkan ✨

### **Tahap 1: Authentication & Validasi Form**
- **Registrasi Pengguna**: Pengguna dapat mendaftar dengan nama, email, dan password.
- **Login Pengguna**: Pengguna dapat login menggunakan email dan password.
- **Validasi Form**: Validasi input di sisi server dan client.
- **Dashboard**: Halaman setelah login berhasil.
- **Logout**: Pengguna dapat logout dari aplikasi.

---

## Teknologi yang Digunakan 🛠️

- **PHP**: Untuk logika server-side dan operasi database.
- **MySQL**: Sebagai sistem manajemen database.
- **HTML**: Untuk struktur tampilan web.
- **CSS**: Untuk mempercantik tampilan antarmuka.

---

## Cara Menjalankan Project 🖥️

### Persyaratan
- PHP (versi 7.0 atau lebih baru)
- MySQL
- Web server (seperti XAMPP, WAMP, atau Laragon)

### Langkah-Langkah
1. **Clone Repository**:
   ```bash
   git clone https://github.com/username/nama-repository.git
   ```
2. **Buat Database**:
   - Buat database baru di MySQL dengan nama `crud_example`.
   - Jalankan query berikut untuk membuat tabel `users`:
     ```sql
     CREATE TABLE users (
         id INT AUTO_INCREMENT PRIMARY KEY,
         name VARCHAR(100) NOT NULL,
         email VARCHAR(100) NOT NULL UNIQUE,
         password VARCHAR(255) NOT NULL
     );
     ```
3. **Simpan Project**:
   - Letakkan folder project di dalam direktori web server (misalnya, `htdocs` untuk XAMPP).
4. **Konfigurasi Database**:
   - Buka file `config.php` dan sesuaikan dengan detail database kamu:
     ```php
     $host = 'localhost';
     $dbname = 'crud_example';
     $username = 'root';
     $password = '';
     ```
5. **Akses Aplikasi**:
   - Buka browser dan akses `http://localhost/nama-folder-project/index.php`.

---

## Screenshot 📸

### Halaman Registrasi
![Halaman Registrasi](screenshots/register.png)

### Halaman Login
![Halaman Login](screenshots/login.png)

### Halaman Dashboard
![Halaman Dashboard](screenshots/dashboard.png)

---

## Kontribusi 🤝

Jika kamu ingin berkontribusi pada project ini, silakan ikuti langkah-langkah berikut:
1. Fork repository ini.
2. Buat branch baru (`git checkout -b fitur-baru`).
3. Commit perubahan kamu (`git commit -m 'Menambahkan fitur baru'`).
4. Push ke branch (`git push origin fitur-baru`).
5. Buat Pull Request.

---

## Lisensi 📜

Project ini dilisensikan di bawah [MIT License](LICENSE).

---

Dibuat dengan ❤️ oleh Muhammad Ulin Nuha.  
Jangan lupa kasih ⭐ jika project ini membantu kamu!
