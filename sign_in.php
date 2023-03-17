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

if (isset($_POST['sign_up'])) {
    header("Location: sign_up.php");
    exit;
}

if (isset($_POST['sign_in'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM taikhoan WHERE TenTk = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && $password == $user['MatKhau']) {
        $_SESSION['logged_in'] = true;
        $_SESSION['TenTK'] = $username;
        $_SESSION['Quyen'] = $user['Quyen'];
        header("Location: index.php");
        exit;
    } else {
        echo "Đăng nhập không thành công. Vui lòng kiểm tra lại tài khoản và mật khẩu!";
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
    <link rel="stylesheet" href="sign_in.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Đăng nhập</title>
</head>

<body>
    <form method="post">
        <div class="LogInBox">
            <div class="text-[30px] font-bold flex justify-center">
                ĐĂNG NHẬP
            </div>

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

            <div class="flex flex-col w-full gap-y-4 items-center mt-5">
                <input type="submit" name="sign_in" class="p-2 bg-[#95a4bd] w-[50%] rounded-md cursor-pointer"
                    value="Đăng nhập">

                <input type="submit" name="sign_up" class="p-2 bg-[#95a4bd] w-[50%] rounded-md cursor-pointer"
                    value="Đăng ký" formaction="#">

            </div>

        </div>
    </form>

</body>

</html>