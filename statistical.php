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
$sql = "SELECT MaPhieuChi, GiaThanh, ThoiGian, GhiChu FROM PhieuChi";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$resultPC = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $resultPC[] = $row;
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

    <div class="w-full h-fit flex flex-row mt-[40px] justify-center gap-x-[2%] mb-32">
        <div class="w-[15%] flex flex-col items-center gap-y-10 ">
            <button class="w-full p-2 bg-[#46a9bc96] rounded-md" name="btnListPC" id="btnListPC">
                Danh sách phiếu chi
            </button>
            <button class="w-full p-2 bg-[#46a9bc96] rounded-md" name="btnListPK" id="btnListPK">
                Danh sách phiếu khám
            </button>
        </div>

        <div class="flex flex-col w-[80%] gap-y-10">
            <div id="tablePC" class="w-full block">
                <table>
                    <tr>
                        <th>Mã phiếu chi</th>
                        <th>Giá thành</th>
                        <th>Thời gian</th>
                        <th>Ghi chú</th>
                        <th></th>
                    </tr>
                    <?php foreach ($resultPC as $item): ?>
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
                            <td>
                                <button class="detail-btn" data-id="<?php echo $item['MaPhieuChi'] ?>">Chi tiết</button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </table>
            </div>

            <div id="details-container"></div>

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
        </div>
    </div>

    <script>
        const detailsContainer = document.querySelector('#details-container');

        const btnListPC = document.querySelector('#btnListPC');
        const btnListPK = document.querySelector('#btnListPK');

        const tablePK = document.querySelector('#tablePK');
        const tablePC = document.querySelector('#tablePC');

        btnListPC.addEventListener('click', () => {
            tablePC.style.display = 'block';
            tablePK.style.display = 'none';
            detailsContainer.style.display = 'block';
        })

        btnListPK.addEventListener('click', () => {
            tablePC.style.display = 'none';
            tablePK.style.display = 'block';
            detailsContainer.style.display = 'none';
        })

        document.querySelectorAll('.detail-btn').forEach(button => {
            button.addEventListener('click', async () => {
                try {
                    const id = button.dataset.id;

                    const response = await fetch(`detailsPC.php?id=${id}`);
                    const data = await response.json();

                    detailsContainer.innerHTML = `
                    <table>
                        <tr>
                            <th>Mã phiếu chi</th>
                            <th>Tên vật tư</th>
                            <th>Số lượng</th>
                            <th>Nhà cung cấp</th>
                        </tr>
                        ${data.map(item => `
                        <tr>
                            <td>${item.MaPhieuChi}</td>
                            <td>${item.TenVT}</td>
                            <td>${item.SoLuong}</td>
                            <td>${item.TenNCC}</td>
                        </tr>
                        `).join('')}
                    </table>
                    `;
                } catch (error) {
                    console.error(error);
                }
            });
        });
    </script>
</body>

</html>