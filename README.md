# Sistem-Management-Blog
Sistem Manajemen Blog (CMS) adalah aplikasi web berbasis PHP yang dirancang untuk memudahkan pengelolaan konten blog secara terpusat. Aplikasi ini memungkinkan administrator untuk mengelola data penulis, artikel, dan kategori artikel dalam satu antarmuka yang bersih dan responsif, tanpa perlu melakukan reload halaman berulang kali.
Teknologi yang digunakan:
Aplikasi dibangun menggunakan PHP sebagai bahasa pemrograman sisi server, MySQL sebagai sistem manajemen basis data, serta JavaScript dengan pendekatan asynchronous menggunakan Fetch API untuk komunikasi data secara real-time antara frontend dan backend.
Fitur utama:
Kelola Penulis: Administrator dapat menambah, mengedit, dan menghapus data penulis. Setiap penulis memiliki nama depan, nama belakang, username unik, password yang dienkripsi menggunakan algoritma bcrypt, serta foto profil. Jika foto tidak diunggah, sistem secara otomatis menampilkan gambar avatar default.
Kelola Artikel: Administrator dapat mengelola artikel blog lengkap dengan judul, isi, gambar, kategori, penulis, serta tanggal dan waktu publikasi yang dibuat otomatis oleh server menggunakan timezone Asia/Jakarta.
Kelola Kategori: Administrator dapat menambah, mengedit, dan menghapus kategori artikel. Kategori yang masih digunakan oleh artikel tidak dapat dihapus untuk menjaga integritas data.
Keamanan:
Seluruh operasi database menggunakan prepared statements untuk mencegah SQL injection. Validasi tipe file menggunakan fungsi finfo dari sisi server, ukuran file dibatasi maksimal 2 MB, output di-sanitasi dengan htmlspecialchars(), dan folder upload dilindungi dengan .htaccess untuk mencegah eksekusi file PHP berbahaya.
Struktur antarmuka:
Aplikasi terdiri dari satu halaman utama (index.php) dengan layout tiga bagian yaitu header di atas, navigasi di kiri, dan area konten di kanan sehingga navigasi antar menu terasa mulus dan cepat tanpa perpindahan halaman.
