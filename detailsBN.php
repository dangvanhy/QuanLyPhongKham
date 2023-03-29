<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qlbv";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Kết nối đến cơ sở dữ liệu thất bại: ";
    $e->getMessage();
}

if (isset($_GET['id'])) {
    $MaBenhNhan = $_GET['id'];
    $sql = "SELECT MaHoSo, KhachHang.TenKH, MaBN, NgayKham, ChuanDoan FROM hosobenhnhan JOIN KhachHang ON HoSoBenhNhan.MaBN =
    KhachHang.MaKH WHERE MaBN = :maBN";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute(['maBN' => $MaBenhNhan]);
    $result = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = array(
            'MaHoSo' => $row['MaHoSo'],
            'TenKH' => $row['TenKH'],
            'NgayKham' => $row['NgayKham'],
            'ChuanDoan' => $row['ChuanDoan']
        );
    }

    echo json_encode($result);
}