<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qlbv";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST["submit"])) {
        $tenTK = $_POST["username"];
        $matKhau = $_POST["password"];
        $nhapLaiMatKhau = $_POST["rePassword"];
        $quyen = "employee";

        if ($matKhau === $nhapLaiMatKhau) {
            $sql = "INSERT INTO TaiKhoan (TenTK, MatKhau, Quyen) VALUES ('$tenTK', '$matKhau', '$quyen')";
            $conn->exec($sql);
            header("Location: sign_in.php");
            exit();
        } else {
            echo "Mật khẩu nhập lại không khớp";
        }
    } elseif (isset($_POST["cancel"])) {
        header("Location: sign_in.php");
        exit();
    }
} catch (PDOException $e) {
    echo "Kết nối đến cơ sở dữ liệu thất bại: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="sign_in.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Đăng ký</title>
</head>
<body>
    <div class="LogInBox">
        <div class="text-[30px] font-bold flex justify-center">
            ĐĂNG KÝ
        </div>

        <form method="POST">
            <div class="flex flex-col gap-y-1">
                <div>
                    Tên đăng nhập:
                </div>
                <input name="username" class="w-full" type="text">
            </div>

            <div class="flex flex-col gap-y-1">
                <div>
                    Mật khẩu:
                </div>
                <input name="password" class="w-full" type="password">
            </div>

            <div class="flex flex-col gap-y-1">
                <div>
                    Nhập lại mật khẩu:
                </div>
                <input name="rePassword" class="w-full" type="password">
            </div>

            <div class="flex flex-col w-full gap-y-4 items-center mt-5">
                <button name="submit" class="p-2 bg-[#95a4bd] w-[50%] rounded-md">
                    Đăng ký
                </button>

                <button name="cancel" class="p-2 bg-[#95a4bd] w-[50%] rounded-md">
                    Hủy
                </button>
            </div>
        </form>

</body>

</html>