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
$Quyen = $_SESSION['Quyen'];
?>

<?php
if (isset($_POST['logout'])) {
    session_unset();

    session_destroy();

    header("Location: sign_in.php");
    exit;
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
    <title>Tài khoản</title>
</head>

<body>
    <?php
    include('header.php');
    ?>

    <div class="w-[30%] mt-[50px] p-[20px] flex flex-col justify-center items-center gap-y-5 bg-[#95939496] m-auto rounded-md">
        <div class="text-[32px] font-bold">
            Tài khoản
        </div>

        <div class="flex flex-col gap-y-3">
            <div>
                Tên tài khoản:
                <?php echo $tenTaiKhoan; ?>
            </div>

            <div>
                Quyền hạn:
                <?php echo $Quyen; ?>
            </div>
        </div>

        <form method="post" action="sign_in.php">
            <button class="p-3 bg-[#aba8d9] rounded-md" type="submit" name="logout">Đăng xuất</button>
        </form>
    </div>
</body>

</html>