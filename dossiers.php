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

<?php
$sql = "SELECT KhachHang.TenKH, NgayKham, ChuanDoan FROM HoSoBenhNhan JOIN KhachHang on 
HoSoBenhNhan.MaBN = KhachHang.MaKH";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$resultHS = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $resultHS[] = $row;
}
?>

<?php
$sql = "SELECT MaKH, TenKH FROM KhachHang";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$resultKH = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $resultKH[] = $row;
}
?>

<?php
if (!empty($_POST['submit'])) {
    $maBN = $_POST['MaBN'];
    $NgayKham = $_POST['NgayKham'];
    $ChuanDoan = $_POST['ChuanDoan'];
    if ($maBN != "" && $NgayKham != "" && $ChuanDoan != "") {
        $sql = "INSERT INTO hosobenhnhan (MaBN, NgayKham, ChuanDoan) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$maBN, $NgayKham, $ChuanDoan]);
        if ($query) {
            header('location: dossiers.php');
        }
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
        <div class="w-[19%] flex flex-col items-center gap-y-10 ">
            <button class="w-full p-2 bg-[#46a9bc96] rounded-md" name="btnList" id="btnList">
                Danh sách hồ sơ
            </button>
            <button class="w-full p-2 bg-[#46a9bc96] rounded-md" name="btnAdd" id="btnAdd">
                Lập hồ sơ mới cho bệnh nhân
            </button>
            <button class="w-full p-2 bg-[#46a9bc96] rounded-md" name="btnAddOld" id="btnAddOld">
                Lập hồ sơ cho bệnh nhân
            </button>
        </div>

        <div id="formAdd" class="w-[78%] hidden">
            <form method="post" class="w-full flex flex-col gap-y-6 bg-[#8e93b7dd] p-8 rounded-md">
                <div class="w-full text-center font-bold text-[28px]">
                    Tạo hồ sơ mới
                </div>
                <div class="flex flex-col gap-y-3">
                    Tên bệnh nhân
                    <select name="MaBN" class="text-[20px] py-1 w-[50%]">
                        <option disabled selected value="">Chọn bênh nhân</option>
                        <?php foreach ($resultKH as $khachhang) { ?>
                            <option value="<?php echo $khachhang['MaKH']; ?>"><?php echo $khachhang['TenKH']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="flex flex-col gap-y-3">
                    <div>
                        Ngày khám
                    </div>
                    <input class="text-[20px] w-[50%]" type="date" name="NgayKham">
                </div>

                <div class="flex flex-col gap-y-3">
                    Chuẩn đoán bệnh
                    <textarea name="ChuanDoan" id="" cols="30" rows="5"
                        class="overflow-y-scroll resize-none p-3"></textarea>
                </div>

                <div class="w-full flex justify-center">
                    <input type="submit" name="submit"
                        class="cursor-pointer bg-[#5A56E8] rounded-md px-10 py-2 w-fit"></input>
                </div>
            </form>
        </div>

        <div id="tableHSOld" class="w-[78%] hidden bg-[#8e93b6dd] p-8">
            <div class="flex flex-col gap-y-3">
                Tên bệnh nhân
                <div class=" text-[20px] py-1 w-[50%] mb-12">
                    <select id="detail-select" class="w-full p-1">
                        <option disabled selected value="">Chọn bênh nhân</option>
                        <?php foreach ($resultKH as $khachhang) { ?>
                            <option value="<?php echo $khachhang['MaKH']; ?>"><?php echo $khachhang['TenKH']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <form method="post" id="formAddOld" class="w-full flex flex-col gap-y-6 rounded-md hidden mb-8">
                <div class="flex flex-col gap-y-3">
                    <div>
                        Ngày khám
                    </div>
                    <input class="text-[20px] w-[50%]" type="date" name="NgayKham">
                </div>

                <div class="flex flex-col gap-y-3">
                    Chuẩn đoán bệnh
                    <textarea name="ChuanDoan" id="" cols="30" rows="5"
                        class="overflow-y-scroll resize-none p-3"></textarea>
                </div>

                <div class="w-full flex justify-center mt-4">
                    <input type="submit" name="submit"
                        class="cursor-pointer bg-[#5A56E8] rounded-md px-10 py-2 w-fit"></input>
                </div>
            </form>

            <div id="details-container"></div>
        </div>


        <div id="tableHS" class="w-[78%] block">
            <table>
                <tr>
                    <th>Tên bệnh nhân</th>
                    <th>Ngày khám</th>
                    <th>Chuẩn đoán bệnh</th>
                </tr>
                <?php foreach ($resultHS as $item): ?>
                    <tr>
                        <td>
                            <?php echo $item['TenKH'] ?>
                        </td>
                        <td>
                            <?php echo $item['NgayKham'] ?>
                        </td>
                        <td>
                            <?php echo $item['ChuanDoan'] ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>
    </div>

    <script>
        const detailsContainer = document.querySelector('#details-container');

        const btnAdd = document.getElementById('btnAdd');
        const btnList = document.getElementById('btnList');
        const btnAddOld = document.getElementById('btnAddOld');
        const formAddOld = document.getElementById('formAddOld');

        const tableHS = document.getElementById('tableHS');
        const tableHSOld = document.getElementById('tableHSOld');
        const formAdd = document.getElementById('formAdd');

        btnList.addEventListener('click', () => {
            tableHS.style.display = 'block';
            formAdd.style.display = 'none';
            tableHSOld.style.display = 'none';
        })

        btnAdd.addEventListener('click', () => {
            tableHS.style.display = 'none';
            formAdd.style.display = 'block';
            tableHSOld.style.display = 'none';
        })

        btnAddOld.addEventListener('click', () => {
            tableHS.style.display = 'none';
            formAdd.style.display = 'none';
            tableHSOld.style.display = 'block';
        })

        document.getElementById("detail-select").addEventListener("change", function () {
            if (this.value != "") {
                document.getElementById("formAddOld").style.display = "block";
            } else {
                document.getElementById("formAddOld").style.display = "none";
            }
        });

        const detailSelect = document.querySelector('#detail-select');
        detailSelect.addEventListener('change', async () => {
            try {
                const id = detailSelect.value;

                const response = await fetch(`detailsBN.php?id=${id}`);
                const data = await response.json();

                detailsContainer.innerHTML = `
                    <div class="my-2">Danh sách hồ sơ cũ</div>

                    <table>
                        <tr>
                            <th>Mã hồ sơ</th>
                            <th>Tên bệnh nhân</th>
                            <th>Ngày khám</th>
                            <th>Chuẩn đoán</th>
                        </tr>
                        ${data.map(item => `
                        <tr>
                            <td>${item.MaHoSo}</td>
                            <td>${item.TenKH}</td>
                            <td>${item.NgayKham}</td>
                            <td>${item.ChuanDoan}</td>
                        </tr>
                        `).join('')}
                    </table>
                    `;
            } catch (error) {
                console.error(error);
            }
        });
    </script>
</body>

</html>