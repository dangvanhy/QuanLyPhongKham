<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qlbv";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Kết nối đến cơ sở dữ liệu thất bại: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeId = $_POST["employeeId"];
    $sql = "DELETE FROM nhanvien WHERE MaNV = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$employeeId]);
    if ($stmt->rowCount() > 0) {
        echo "Xóa nhân viên thành công.";
    } else {
        echo "Không tìm thấy nhân viên có mã số " . $employeeId;
    }
}