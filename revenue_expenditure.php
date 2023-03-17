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
?>

<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: sign_in.php');
    exit;
}

if (!isset($_SESSION['TenTK'])) {
    header('Location: sign_in.php');
    exit;
}

$tenTaiKhoan = $_SESSION['TenTK'];
?>

<?php
$sql = "SELECT MaPhieuChi, GiaThanh, ThoiGian, GhiChu FROM PhieuChi";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
}
?>

<?php
if (isset($_POST['MaPhieuChi'])) {
    $MaPhieuChi = $_POST['MaPhieuChi'];
    $sql = "SELECT MaPhieuChi, VatTu.TenVT, ChiTietPhieuChi.SoLuong, NhaCungCap.TenNCC FROM ChiTietPhieuChi join VatTu on 
            ChiTietPhieuChi.MaVatTu = VatTu.MaVT join NhaCungCap on ChiTietPhieuChi.MaNCC = NhaCungCap.MaNCC WHERE MaPhieuChi = :ma";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute(['ma' => $MaPhieuChi]);
    $resultCTPC = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $resultCTPC[] = $row;
    }
}
?>

<?php
$sql = "SELECT MaPhieuKham, ThoiGian, NhanVien.TenNV, KhachHang.TenKH FROM PhieuKham JOIN NhanVien on PhieuKham.MaNV = NhanVien.MaNV
JOIN KhachHang on PhieuKham.MaKH = KhachHang.MaKH";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$resultPK = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $resultPK[] = $row;
}
?>

<?php
$sql = "SELECT MaDonThuoc, NgayLapDon, NhanVien.TenNV, KhachHang.TenKH, GhiChu FROM DonThuoc JOIN NhanVien on 
DonThuoc.MaNV = NhanVien.MaNV JOIN KhachHang on donthuoc.MaKH = khachhang.MaKH";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$resultDT = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $resultDT[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Quản lý Phòng khám nha khoa</title>
</head>

<body>
    <?php
    include('header.php');
    ?>


    <div class="w-full h-fit flex flex-row mt-[20px] gap-x-[2%]">
        <div class="w-[15%] flex flex-col items-center gap-y-10">
            <button class="w-[200px] p-2 bg-[#46a9bc96] rounded-md" name="btnPC" id="btnPC">
                Hiển thị danh sách phiếu chi
            </button>

            <button class="w-[200px] p-2 bg-[#46a9bc96] rounded-md" name="btnPK" id="btnPK">
                Hiển thị danh sách phiếu khám
            </button>

            <button class="w-[200px] p-2 bg-[#46a9bc96] rounded-md" name="btnDT" id="btnDT">
                Hiển thị danh sách đơn thuốc
            </button>
        </div>

        <div class="w-[82%]">
            <div id="tablePC" class="w-full block">
                <table>
                    <tr>
                        <th>Mã phiếu chi</th>
                        <th>Tổng tiền</th>
                        <th>Thời gian</th>
                        <th>Ghi chú</th>
                    </tr>
                    <?php foreach ($result as $item): ?>
                        <tr>
                            <td>
                                <?php echo $item['MaPhieuChi'] ?>
                            </td>
                            <td>
                                <?php echo $item['GiaThanh'] ?>
                            </td>
                            <td>
                                <?php echo $item['ThoiGian'] ?>
                            </td>
                            <td>
                                <?php echo $item['GhiChu'] ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </table>
            </div>

            <div id="tableCTPC" class="w-full hidden">
                <table>
                    <tr>
                        <th>Mã phiếu chi</th>
                        <th>Tên vật tư</th>
                        <th>Số lượng</th>
                        <th>Tên nhà cung cấp</th>
                    </tr>
                    <?php foreach ($resultCTPC as $item): ?>
                        <tr>
                            <td>
                                <?php echo $item['MaPhieuChi'] ?>
                            </td>
                            <td>
                                <?php echo $item['TenVT'] ?>
                            </td>
                            <td>
                                <?php echo $item['SoLuong'] ?>
                            </td>
                            <td>
                                <?php echo $item['TenNCC'] ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </table>
            </div>

            <div id="tablePK" class="w-full hidden">
                <table>
                    <tr>
                        <th>Mã phiếu khám</th>
                        <th>Thời gian</th>
                        <th>Tên nhân viên</th>
                        <th>Tên khách hàng</th>
                    </tr>
                    <?php foreach ($resultPK as $item): ?>
                        <tr>
                            <td>
                                <?php echo $item['MaPhieuKham'] ?>
                            </td>
                            <td>
                                <?php echo $item['ThoiGian'] ?>
                            </td>
                            <td>
                                <?php echo $item['TenNV'] ?>
                            </td>
                            <td>
                                <?php echo $item['TenKH'] ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </table>
            </div>

            <div id="tableDT" class="w-full hidden">
                <table>
                    <tr>
                        <th>Mã đơn thuốc</th>
                        <th>Thời gian</th>
                        <th>Tên nhân viên</th>
                        <th>Tên khách hàng</th>
                        <th>Ghi chú</th>
                    </tr>
                    <?php foreach ($resultDT as $item): ?>
                        <tr>
                            <td>
                                <?php echo $item['MaDonThuoc'] ?>
                            </td>
                            <td>
                                <?php echo $item['NgayLapDon'] ?>
                            </td>
                            <td>
                                <?php echo $item['TenNV'] ?>
                            </td>
                            <td>
                                <?php echo $item['TenKH'] ?>
                            </td>
                            <td>
                                <?php echo $item['GhiChu'] ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </table>
            </div>
        </div>
    </div>

    <script>
        const btnPC = document.getElementById('btnPC');
        const btnPK = document.getElementById('btnPK');
        const btnDT = document.getElementById('btnDT');

        btnPC.addEventListener('click', () => {
            tablePC.style.display = 'block';
            tablePK.style.display = 'none';
            tableDT.style.display = 'none';
        })

        btnPK.addEventListener('click', () => {
            tablePK.style.display = 'block';
            tablePC.style.display = 'none';
            tableDT.style.display = 'none';
        })

        btnDT.addEventListener('click', () => {
            tablePK.style.display = 'none';
            tablePC.style.display = 'none';
            tableDT.style.display = 'block';
        })
    </script>
</body>

</html>