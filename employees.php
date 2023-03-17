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
$sql = "SELECT TenNV, GioiTinh, NgaySinh, SDT, Email, NhomThuThuat.TenNTT FROM NhanVien join NhomThuThuat on NhanVien.MaNTT = NhomThuThuat.MaNTT";
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
if (!empty($_POST['submit'])) {
    $tenNV = $_POST['tenNV'];
    $gioiTinh = $_POST['gioiTinh'];
    $ngaySinh = $_POST['ngaySinh'];
    $sdt = $_POST['sdt'];
    $email = $_POST['email'];
    $maNTT = $_POST['maNTT'];
    if ($tenNV != "" && $gioiTinh != "" && $ngaySinh != "" && $sdt != "" && $email != "" && $maNTT != "") {
        $sql = "INSERT INTO nhanvien (TenNV, GioiTinh, NgaySinh, SDT, Email, MaNTT) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$tenNV, $gioiTinh, $ngaySinh, $sdt, $email, $maNTT]);
        if($query) {
            header('location: employees.php');
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

    <div class="w-full h-fit flex flex-row mt-[20px] gap-x-[2%]">
        <div class="w-[15%] flex flex-col items-center gap-y-10">
            <button class="w-[200px] p-2 bg-[#46a9bc96] rounded-md" name="btnAdd" id="btnAdd">
                Thêm nhân viên
            </button>

            <button class="w-[200px] p-2 bg-[#46a9bc96] rounded-md" name="btnList" id="btnList">
                Hiển thị danh sách
            </button>
        </div>

        <div id="tableNV" class="w-[82%] block">
            <table>
                <tr>
                    <th>Tên nhân viên</th>
                    <th>Giới tính</th>
                    <th>Ngày sinh</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Tên nhóm thủ thuật</th>
                </tr>
                <?php foreach ($result as $item): ?>
                    <tr>
                        <td>
                            <?php echo $item['TenNV'] ?>
                        </td>
                        <td>
                            <?php if ($item['GioiTinh'] === "1") {
                                echo "Nam";
                            } else {
                                echo "Nữ";
                            }
                            ?>
                        </td>
                        <td>
                            <?php echo $item['NgaySinh'] ?>
                        </td>
                        <td>
                            <?php echo $item['SDT'] ?>
                        </td>
                        <td>
                            <?php echo $item['Email'] ?>
                        </td>
                        <td>
                            <?php echo $item['TenNTT'] ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>

        <div id="formNV" class="w-[50%] hidden bg-[#8e93b7dd] rounded-md">
            <div class="w-fit m-auto font-bold text-[32px]">
                Thêm nhân viên
            </div>

            <form method="post" class="w-full rounded-md flex flex-col gap-y-5 p-2 items-center">
                <div class="flex flex-row gap-x-2 w-full justify-between px-2">
                    <div class="flex flex-col w-[48%] gap-y-5">
                        <div>
                            Tên nhân viên
                            <input type="text" name="tenNV" class="w-full text-[20px] mt-3">
                        </div>

                        <div>
                            Giới tính
                            <div class="mt-3 flex flex-row gap-x-5">
                                <div>
                                    <input class="text-[20px]" type="radio" value="1" name="gioiTinh">
                                    Nam
                                </div>

                                <div>
                                    <input class="text-[20px]" type="radio" value="0" name="gioiTinh">
                                    Nữ
                                </div>

                            </div>
                        </div>

                        <div class="flex flex-col gap-y-3">
                            Ngày sinh
                            <input class="text-[20px]" type="date" name="ngaySinh">
                        </div>
                    </div>

                    <div class="flex flex-col w-[48%] gap-y-5">
                        <div class="flex flex-col gap-y-3">
                            <div>
                                Số điện thoại
                            </div>
                            <input type="text" name="sdt" class="w-full text-[20px]">
                        </div>

                        <div class="flex flex-col gap-y-3">
                            Email
                            <input type="text" name="email" class="w-full text-[20px]">
                        </div>

                        <div class="flex flex-col gap-y-3">
                            Nhóm thủ thuật
                            <select name="maNTT" class="text-[20px] py-1">
                                <?php foreach ($resultNTT as $item): ?>
                                    <option value="<?php echo $item['MaNTT'] ?>">
                                        <?php echo $item['TenNTT'] ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>
                <input class="mt-[10px] w-fit p-2 bg-[#46a9bc96] rounded-md cursor-pointer" name="submit" type="submit"
                    value="Thêm mới">
            </form>
        </div>
    </div>

    <script>
        const btnAdd = document.getElementById('btnAdd');
        const btnList = document.getElementById('btnList');

        const tableNV = document.getElementById('tableNV');
        const formNV = document.getElementById('formNV');

        btnList.addEventListener('click', () => {
            tableNV.style.display = 'block';
            formNV.style.display = 'none';
        })

        btnAdd.addEventListener('click', () => {
            tableNV.style.display = 'none';
            formNV.style.display = 'block';
        })
    </script>
</body>

</html>