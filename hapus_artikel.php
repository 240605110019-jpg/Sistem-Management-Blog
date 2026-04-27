<?php
header('Content-Type: application/json');
require 'koneksi.php';

$id = intval($_POST['id'] ?? 0);

if (!$id) {
    echo json_encode(['status' => 'error', 'pesan' => 'ID tidak valid.']);
    exit;
}

// Ambil nama gambar
$stmtGambar = $koneksi->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmtGambar->bind_param('i', $id);
$stmtGambar->execute();
$row = $stmtGambar->get_result()->fetch_assoc();
$stmtGambar->close();

$stmt = $koneksi->prepare("DELETE FROM artikel WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    // Hapus file gambar dari server
    if ($row && file_exists('uploads_artikel/' . $row['gambar'])) {
        unlink('uploads_artikel/' . $row['gambar']);
    }
    echo json_encode(['status' => 'ok', 'pesan' => 'Artikel berhasil dihapus.']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal menghapus artikel.']);
}

$stmt->close();
$koneksi->close();