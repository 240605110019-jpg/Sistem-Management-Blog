<?php
header('Content-Type: application/json');
require 'koneksi.php';

$id = intval($_POST['id'] ?? 0);

if (!$id) {
    echo json_encode(['status' => 'error', 'pesan' => 'ID tidak valid.']);
    exit;
}

// Cek apakah penulis masih memiliki artikel
$cek = $koneksi->prepare("SELECT COUNT(*) AS total FROM artikel WHERE id_penulis = ?");
$cek->bind_param('i', $id);
$cek->execute();
$total = $cek->get_result()->fetch_assoc()['total'];
$cek->close();

if ($total > 0) {
    echo json_encode(['status' => 'error', 'pesan' => 'Penulis masih memiliki artikel dan tidak dapat dihapus.']);
    exit;
}

// Ambil nama foto
$stmtFoto = $koneksi->prepare("SELECT foto FROM penulis WHERE id = ?");
$stmtFoto->bind_param('i', $id);
$stmtFoto->execute();
$row = $stmtFoto->get_result()->fetch_assoc();
$stmtFoto->close();

$stmt = $koneksi->prepare("DELETE FROM penulis WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    // Hapus file foto jika bukan default
    if ($row && $row['foto'] !== 'default.png' && file_exists('uploads_penulis/' . $row['foto'])) {
        unlink('uploads_penulis/' . $row['foto']);
    }
    echo json_encode(['status' => 'ok', 'pesan' => 'Data penulis berhasil dihapus.']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal menghapus data.']);
}

$stmt->close();
$koneksi->close();