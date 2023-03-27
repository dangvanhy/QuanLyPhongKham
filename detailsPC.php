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
    $MaPhieuChi = $_GET['id'];
    $sql = "SELECT ChiTietPhieuChi.MaPhieuChi, VatTu.TenVT, ChiTietPhieuChi.SoLuong, NhaCungCap.TenNCC FROM ChiTietPhieuChi JOIN VatTu ON 
            ChiTietPhieuChi.MaVatTu = VatTu.MaVT JOIN NhaCungCap ON ChiTietPhieuChi.MaNCC = NhaCungCap.MaNCC WHERE MaPhieuChi = :ma";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute(['ma' => $MaPhieuChi]);
    $resultCTPC = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $resultCTPC[] = array(
            'MaPhieuChi' => $row['MaPhieuChi'],
            'TenVT' => $row['TenVT'],
            'SoLuong' => $row['SoLuong'],
            'TenNCC' => $row['TenNCC']
        );
    }

    echo json_encode($resultCTPC);
}