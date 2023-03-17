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
$sql = "SELECT Thuoc.TenThuoc, DonViTinh.TenDVT, Thuoc.SoLuong, Thuoc.CongDung FROM Thuoc JOIN DonViTinh ON Thuoc.MaDVT = DonViTinh.MaDVT";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
}
?>

<?php
$sql = "SELECT MaDVT, TenDVT FROM DonViTinh";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$resultDVT = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $resultDVT[] = $row;
}
?>

<?php
$sql = "SELECT MaVT, TenVT, SoLuong, DonGia, DonViTinh.TenDVT, MoTa FROM VatTu JOIN DonViTinh ON VatTu.MaDVT = DonViTinh.MaDVT";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$resultVT = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $resultVT[] = $row;
}
?>

<?php
$sql = "SELECT MaNTT, TenNTT, MoTa FROM NhomThuThuat";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$resultNTT = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $resultNTT[] = $row;
}
?>

<?php
$sql = "SELECT MaNCC, TenNCC, DiaChi, SDT, Email, NguoiDaiDien FROM NhaCungCap";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$resultNCC = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $resultNCC[] = $row;
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
            <button class="w-[200px] p-2 bg-[#46a9bc96] rounded-md" id="btnThuoc">
                Thuốc
            </button>

            <button class="w-[200px] p-2 bg-[#46a9bc96] rounded-md" id="btnVatTu">
                Vật tư
            </button>

            <button class="w-[200px] p-2 bg-[#46a9bc96] rounded-md" id="btnNTT">
                Nhóm thủ thuật
            </button>

            <button class="btn-donvitinh w-[200px] p-2 bg-[#46a9bc96] rounded-md" id="btnDVT">
                Đơn vị tính
            </button>

            <button class="w-[200px] p-2 bg-[#46a9bc96] rounded-md" id="btnNCC">
                Nhà cung cấp
            </button>
        </div>

        <div id="tableThuoc" class="w-[82%] block">
            <table>
                <tr>
                    <th>Tên thuốc</th>
                    <th>Đơn vị tính</th>
                    <th>Số lượng</th>
                    <th>Công dụng</th>
                </tr>
                <?php foreach ($result as $item): ?>
                    <tr>
                        <td>
                            <?php echo $item['TenThuoc'] ?>
                        </td>
                        <td>
                            <?php echo $item['TenDVT'] ?>
                        </td>
                        <td>
                            <?php echo $item['SoLuong'] ?>
                        </td>
                        <td>
                            <?php echo $item['CongDung'] ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>

        <div id="tableDonvitinh" class="w-[82%] hidden">
            <table>
                <tr>
                    <th>Mã đơn vị tính</th>
                    <th>Tên đơn vị tính</th>
                </tr>
                <?php foreach ($resultDVT as $item): ?>
                    <tr>
                        <td>
                            <?php echo $item['MaDVT'] ?>
                        </td>
                        <td>
                            <?php echo $item['TenDVT'] ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>

        <div id="tableVatTu" class="w-[82%] hidden">
            <table>
                <tr>
                    <th>Mã vật tư</th>
                    <th>Tên vật tư</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Tên đơn vị tính</th>
                    <th>Mô tả</th>
                </tr>
                <?php foreach ($resultVT as $item): ?>
                    <tr>
                        <td>
                            <?php echo $item['MaVT'] ?>
                        </td>
                        <td>
                            <?php echo $item['TenVT'] ?>
                        </td>
                        <td>
                            <?php echo $item['SoLuong'] ?>
                        </td>
                        <td>
                            <?php echo $item['DonGia'] ?>
                        </td>
                        <td>
                            <?php echo $item['TenDVT'] ?>
                        </td>
                        <td>
                            <?php echo $item['MoTa'] ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>

        <div id="tableNTT" class="w-[82%] hidden">
            <table>
                <tr>
                    <th>Mã nhóm thủ thuật</th>
                    <th>Tên nhóm thủ thuật</th>
                    <th>Mô tả</th>
                </tr>
                <?php foreach ($resultNTT as $item): ?>
                    <tr>
                        <td>
                            <?php echo $item['MaNTT'] ?>
                        </td>
                        <td>
                            <?php echo $item['TenNTT'] ?>
                        </td>
                        <td>
                            <?php echo $item['MoTa'] ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>

        <div id="tableNCC" class="w-[82%] hidden">
            <table>
                <tr>
                    <th>Mã nhà cung cấp</th>
                    <th>Tên nhà cung cấp</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Người đại diện</th>
                </tr>
                <?php foreach ($resultNCC as $item): ?>
                    <tr>
                        <td>
                            <?php echo $item['MaNCC'] ?>
                        </td>
                        <td>
                            <?php echo $item['TenNCC'] ?>
                        </td>
                        <td>
                            <?php echo $item['DiaChi'] ?>
                        </td>
                        <td>
                            <?php echo $item['SDT'] ?>
                        </td>
                        <td>
                            <?php echo $item['Email'] ?>
                        </td>
                        <td>
                            <?php echo $item['NguoiDaiDien'] ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>
    </div>

    <script>
        const btnThuoc = document.getElementById('btnThuoc');
        const btnDVT = document.getElementById('btnDVT');
        const btnVatTu = document.getElementById('btnVatTu');
        const btnNTT = document.getElementById('btnNTT');
        const btnNCC = document.getElementById('btnNCC');

        const tableThuoc = document.getElementById('tableThuoc');
        const tableDVT = document.getElementById('tableDonvitinh');
        const tableVatTu = document.getElementById('tableVatTu');
        const tableNTT = document.getElementById('tableNTT');
        const tableNCC = document.getElementById('tableNCC');

        btnThuoc.addEventListener('click', () => {
            tableThuoc.style.display = 'block';
            tableDVT.style.display = 'none';
            tableVatTu.style.display = 'none';
            tableNTT.style.display = 'none';
            tableNCC.style.display = 'none';
        });

        btnDVT.addEventListener('click', () => {
            tableThuoc.style.display = 'none';
            tableDVT.style.display = 'block';
            tableVatTu.style.display = 'none';
            tableNTT.style.display = 'none';
            tableNCC.style.display = 'none'
        });

        btnVatTu.addEventListener('click', () => {
            tableThuoc.style.display = 'none';
            tableDVT.style.display = 'none';
            tableVatTu.style.display = 'block';
            tableNTT.style.display = 'none';
            tableNCC.style.display = 'none'
        });

        btnNTT.addEventListener('click', () => {
            tableThuoc.style.display = 'none';
            tableDVT.style.display = 'none';
            tableVatTu.style.display = 'none';
            tableNTT.style.display = 'block';
        });

        btnNCC.addEventListener('click', () => {
            tableThuoc.style.display = 'none';
            tableDVT.style.display = 'none';
            tableVatTu.style.display = 'none';
            tableNTT.style.display = 'none';
            tableNCC.style.display = 'block'
        });
    </script>
</body>

</html>