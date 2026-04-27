<?php
header('Content-Type: application/json');
require 'koneksi.php';

$stmt = $koneksi->prepare("
    SELECT a.id, a.judul, a.gambar, a.hari_tanggal,
           p.nama_depan, p.nama_belakang,
           k.nama_kategori
    FROM artikel a
    JOIN penulis p ON a.id_penulis = p.id
    JOIN kategori_artikel k ON a.id_kategori = k.id
    ORDER BY a.id ASC
");
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(['status' => 'ok', 'data' => $data]);
$stmt->close();
$koneksi->close();