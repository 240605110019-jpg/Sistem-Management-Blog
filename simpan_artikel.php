<?php
header('Content-Type: application/json');
require 'koneksi.php';

$judul       = trim($_POST['judul'] ?? '');
$id_penulis  = intval($_POST['id_penulis'] ?? 0);
$id_kategori = intval($_POST['id_kategori'] ?? 0);
$isi         = trim($_POST['isi'] ?? '');

if (!$judul || !$id_penulis || !$id_kategori || !$isi) {
    echo json_encode(['status' => 'error', 'pesan' => 'Semua field wajib diisi.']);
    exit;
}

if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['status' => 'error', 'pesan' => 'Gambar artikel wajib diunggah.']);
    exit;
}

$tmp  = $_FILES['gambar']['tmp_name'];
$size = $_FILES['gambar']['size'];

if ($size > 2 * 1024 * 1024) {
    echo json_encode(['status' => 'error', 'pesan' => 'Ukuran file maksimal 2 MB.']);
    exit;
}

$finfo   = new finfo(FILEINFO_MIME_TYPE);
$mime    = $finfo->file($tmp);
$allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

if (!in_array($mime, $allowed)) {
    echo json_encode(['status' => 'error', 'pesan' => 'Tipe file tidak diizinkan.']);
    exit;
}

$ext    = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
$gambar = uniqid('artikel_') . '.' . $ext;
move_uploaded_file($tmp, 'uploads_artikel/' . $gambar);

// Generate hari_tanggal
date_default_timezone_set('Asia/Jakarta');
$hari   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
$bulan  = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
           7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
$now       = new DateTime();
$nama_hari = $hari[$now->format('w')];
$tanggal   = $now->format('j');
$nama_bulan = $bulan[(int)$now->format('n')];
$tahun     = $now->format('Y');
$jam       = $now->format('H:i');
$hari_tanggal = "$nama_hari, $tanggal $nama_bulan $tahun | $jam";

$stmt = $koneksi->prepare("INSERT INTO artikel (id_penulis, id_kategori, judul, isi, gambar, hari_tanggal) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param('iissss', $id_penulis, $id_kategori, $judul, $isi, $gambar, $hari_tanggal);

if ($stmt->execute()) {
    echo json_encode(['status' => 'ok', 'pesan' => 'Artikel berhasil disimpan.']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal menyimpan artikel.']);
}

$stmt->close();
$koneksi->close();