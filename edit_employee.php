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

if (!isset($_GET['id'])) {
    header('Location:employees.php');
    exit;
}
?>

<?php
$id = $_GET['id'];

$sql = "SELECT MaNV, TenNV, GioiTinh, NgaySinh, SDT, Email, NhanVien.MaNTT, NhomThuThuat.TenNTT FROM NhanVien join NhomThuThuat on NhanVien.MaNTT 
= NhomThuThuat.MaNTT WHERE MaNV = $id";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
}
?>

<?php
$sql = "SELECT MaNTT, TenNTT FROM NhomThuThuat";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$resultNTT = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $resultNTT[] = $row;
}
?>

<?php
$id = $_GET['id'];

if (isset($_POST['submit'])) {
    $tenNV = $_POST['tenNV'];
    $gioiTinh = $_POST['gioiTinh'];
    $ngaySinh = $_POST['ngaySinh'];
    $sdt = $_POST['sdt'];
    $email = $_POST['email'];
    $maNTT = $_POST['maNTT'];

    $sql = "UPDATE NhanVien SET TenNV = ?, GioiTinh = ?, NgaySinh = ?, SDT = ?, Email = ?, MaNTT = ? WHERE MaNV = ?";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$tenNV, $gioiTinh, $ngaySinh, $sdt, $email, $maNTT, $id]);

    if ($result) {
        header('Location: employees.php');
        exit;
    } else {
        echo "Có lỗi xảy ra khi cập nhật thông tin nhân viên.";
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

    <div id="formNV" class="w-[80%] mx-auto bg-[#8e93b7dd] rounded-md">
        <div class="w-fit m-auto font-bold text-[32px]">
            Sửa nhân viên
        </div>

        <form method="post" class="w-full rounded-md flex flex-col gap-y-5 p-2 items-center">
            <div class="flex flex-row gap-x-2 w-full justify-between px-2">
                <div class="flex flex-col w-[48%] gap-y-5">
                    <div>
                        Tên nhân viên
                        <input type="text" name="tenNV" class="w-full text-[20px] mt-3"
                            value="<?php echo $result[0]['TenNV']; ?>">
                    </div>
                    <div>
                        Giới tính
                        <div class="mt-3 flex flex-row gap-x-5">
                            <div>
                                <input class="text-[20px]" type="radio" value="1" name="gioiTinh" <?php if ($result[0]['GioiTinh'] == 1) {
                                    echo 'checked';
                                } ?>>
                                Nam
                            </div>

                            <div>
                                <input class="text-[20px]" type="radio" value="0" name="gioiTinh" <?php if ($result[0]['GioiTinh'] == 0) {
                                    echo 'checked';
                                } ?>>
                                Nữ
                            </div>

                        </div>
                    </div>

                    <div class="flex flex-col gap-y-3">
                        Ngày sinh
                        <input class="text-[20px]" type="date" name="ngaySinh"
                            value="<?php echo $result[0]['NgaySinh']; ?>">
                    </div>
                </div>

                <div class="flex flex-col w-[48%] gap-y-5">
                    <div class="flex flex-col gap-y-3">
                        <div>
                            Số điện thoại
                        </div>
                        <input type="text" name="sdt" class="w-full text-[20px]"
                            value="<?php echo $result[0]['SDT']; ?>">
                    </div>

                    <div class="flex flex-col gap-y-3">
                        Email
                        <input type="text" name="email" class="w-full text-[20px]"
                            value="<?php echo $result[0]['Email']; ?>">
                    </div>

                    <div class="flex flex-col gap-y-3">
                        Nhóm thủ thuật
                        <select name="maNTT" class="text-[20px] py-1">
                            <?php foreach ($resultNTT as $item): ?>
                                <option value="<?php echo $item['MaNTT'] ?>" <?php if ($item['MaNTT'] == $result[0]['MaNTT']) {
                                       echo 'selected';
                                   } ?>>
                                    <?php echo $item['TenNTT'] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex gap-x-[20px]">
                <input class="mt-[10px] w-[200px] p-2 bg-[#46a9bc96] rounded-md cursor-pointer" name="submit"
                    type="submit" value="Sửa">

                <input class="mt-[10px] w-[200px] p-2 bg-[#46a9bc96] rounded-md cursor-pointer" type="button"
                    value="Hủy" onclick="window.location.href='employees.php'">
            </div>
        </form>
    </div>

</body>

</html>