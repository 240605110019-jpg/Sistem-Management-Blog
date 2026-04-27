<?php
header('Content-Type: application/json');
require 'koneksi.php';

$id = intval($_POST['id'] ?? 0);

if (!$id) {
    echo json_encode(['status' => 'error', 'pesan' => 'ID tidak valid.']);
    exit;
}

// Cek apakah kategori masih digunakan artikel
$cek = $koneksi->prepare("SELECT COUNT(*) AS total FROM artikel WHERE id_kategori = ?");
$cek->bind_param('i', $id);
$cek->execute();
$total = $cek->get_result()->fetch_assoc()['total'];
$cek->close();

if ($total > 0) {
    echo json_encode(['status' => 'error', 'pesan' => 'Kategori masih digunakan artikel dan tidak dapat dihapus.']);
    exit;
}

$stmt = $koneksi->prepare("DELETE FROM kategori_artikel WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'ok', 'pesan' => 'Kategori berhasil dihapus.']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal menghapus kategori.']);
}

$stmt->close();
$koneksi->close();