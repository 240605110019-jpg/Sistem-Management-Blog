<?php
header('Content-Type: application/json');
require 'koneksi.php';

$stmt = $koneksi->prepare("SELECT id, nama_depan, nama_belakang, user_name, password, foto FROM penulis ORDER BY id ASC");
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(['status' => 'ok', 'data' => $data]);
$stmt->close();
$koneksi->close();