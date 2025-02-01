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

### **Tahap 2: Authentication & Validasi Form**
- **Implementasi pagination** untuk membagi data menjadi beberapa halaman.
- **Tambahkan fitur pencarian** berdasarkan nama atau email.
- **Implementasi sorting data** (ascending/descending) berdasarkan kolom tertentu.
- **Perbaiki tampilan tabel** agar lebih user-friendly.

### **Tahap 3: Upload File & Role-Based Access Control (RBAC)**
- **Tambahkan kolom** `profile_picture` di tabel `users`.
- **Implementasi fitur upload foto profil.**
- **Validasi ukuran dan tipe file** yang diupload.
- **Tambahkan sistem role (Admin dan User)** dengan hak akses yang berbeda.
- **Batasi akses CRUD** berdasarkan role pengguna.

### **Tahap 4: Export/Import Data & Notifikasi**
- **Export Data**: Pengguna dapat mengekspor data pengguna ke format CSV.
- **Import Data**: Pengguna dapat mengimpor data pengguna dari file CSV.
- **Notifikasi**: Tampilkan pesan sukses atau error saat melakukan operasi.

### **Tahap 5: Responsive Design & API Endpoint**
- **Perbaiki tampilan aplikasi**: agar responsive menggunakan framework CSS seperti Bootstrap atau Tailwind CSS.
- **Buat RESTful API** untuk aplikasi CRUD.
- Implementasi **endpoint** seperti:
    - `GET /api/users` untuk mengambil data.
    - `POST /api/users` untuk menambah data.
    - `PUT /api/users/{id}` untuk mengupdate data.
    - `DELETE /api/users/{id}` untuk menghapus data.

### **Tahap 6: Unit Testing & Logging**
- **Unit Testing**: Menambahkan pengujian unit menggunakan PHPUnit untuk memastikan kualitas kode.
    - **Test Case untuk CRUD**: Melakukan pengujian terhadap operasi CRUD (Create, Read, Update, Delete).
    - **Test Case untuk Login & Registrasi**: Menguji alur login dan registrasi pengguna.
  
- **Logging**: Menambahkan fitur pencatatan aktivitas sistem.
    - **Log Aktivitas**: Semua login, logout, dan aksi penting dicatat dalam file log untuk memudahkan debugging dan pemantauan aktivitas.
    - **File Log**: Log disimpan dalam file `logs/login.log` dengan informasi timestamp dan pesan aktivitas.

---

## Teknologi yang Digunakan 🛠️

- **PHP**: Untuk logika server-side dan operasi database.
- **MySQL**: Sebagai sistem manajemen database.
- **HTML**: Untuk struktur tampilan web.
- **CSS**: Untuk mempercantik tampilan antarmuka.
- **PHPUnit**: Untuk unit testing aplikasi.
- **Logging**: Menyimpan log aktivitas ke file untuk audit dan debugging.

---

## Cara Menjalankan Project 🖥️

### Persyaratan
- PHP (versi 7.0 atau lebih baru)
- MySQL
- Web server (seperti XAMPP, WAMP, atau Laragon)
- PHPUnit untuk pengujian

### Langkah-Langkah
1. **Clone Repository**:
   ```bash
   git clone https://github.com/username/nama-repository.git
   ```

2. **Buat Database**:
   - Buat database baru di MySQL dengan nama `crud_example`.
   - Jalankan query berikut untuk membuat tabel `users`:
      ```sql
   CREATE TABLE `users` (
   `id` int NOT NULL,
   `name` varchar(100) NOT NULL,
   `email` varchar(100) NOT NULL,
   `password` varchar(255) NOT NULL,
   `role` enum('admin','user') DEFAULT 'user',
   `profile_picture` varchar(255) DEFAULT NULL
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

6. **Unit Testing**:
   - Install PHPUnit jika belum terpasang.
   - Jalankan pengujian unit dengan perintah:
     ```bash
     phpunit tests/CrudTest.php
     ```

7. **Logging**:
   - Semua aktivitas login dan aksi penting akan tercatat di file log `logs/login.log`.

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