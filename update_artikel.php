<?php
header('Content-Type: application/json');
require 'koneksi.php';

$id          = intval($_POST['id'] ?? 0);
$judul       = trim($_POST['judul'] ?? '');
$id_penulis  = intval($_POST['id_penulis'] ?? 0);
$id_kategori = intval($_POST['id_kategori'] ?? 0);
$isi         = trim($_POST['isi'] ?? '');

if (!$id || !$judul || !$id_penulis || !$id_kategori || !$isi) {
    echo json_encode(['status' => 'error', 'pesan' => 'Field wajib tidak boleh kosong.']);
    exit;
}

// Ambil gambar lama
$stmtLama = $koneksi->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmtLama->bind_param('i', $id);
$stmtLama->execute();
$lama = $stmtLama->get_result()->fetch_assoc();
$stmtLama->close();

if (!$lama) {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak ditemukan.']);
    exit;
}

$gambar = $lama['gambar'];

if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
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

    // Hapus gambar lama
    if (file_exists('uploads_artikel/' . $gambar)) {
        unlink('uploads_artikel/' . $gambar);
    }

    $ext    = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
    $gambar = uniqid('artikel_') . '.' . $ext;
    move_uploaded_file($tmp, 'uploads_artikel/' . $gambar);
}

$stmt = $koneksi->prepare("UPDATE artikel SET id_penulis=?, id_kategori=?, judul=?, isi=?, gambar=? WHERE id=?");
$stmt->bind_param('iisssi', $id_penulis, $id_kategori, $judul, $isi, $gambar, $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'ok', 'pesan' => 'Artikel berhasil diperbarui.']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal memperbarui artikel.']);
}

$stmt->close();
$koneksi->close();