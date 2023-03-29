<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="flex flex-row bg-[#fff] py-3 items-center justify-between drop-shadow-xl">
        <div class="ml-4 flex flex-row gap-x-4 cursor-pointer items-center">
            <img class="h-[32x] w-[40px]" src="./images/icons8-hospital-64.png" alt="logo">
            <div class="text-[#B0A9F4] font-bold">
                Phòng khám nha khoa
            </div>
        </div>

        <div class="pr-[20px] cursor-pointer font-semibold" onclick="location.href='account.php';">
            <?php echo $tenTaiKhoan; ?>
        </div>
    </div>

    <div class="flex flex-row gap-x-5 justify-center items-center bg-[#fff] py-3 w-[97%] mx-auto rounded-b-lg drop-shadow-2xl mb-12">
        <div class="pr-[20px] text-[#B0A9F4] cursor-pointer" onclick="location.href='index.php';">
            Trang chủ
        </div>

        <div class="pr-[20px] text-[#B0A9F4] cursor-pointer" onclick="location.href='category.php';">
            Danh mục
        </div>

        <div class="pr-[20px] text-[#B0A9F4] cursor-pointer" onclick="location.href='employees.php';">
            Quản lý nhân viên
        </div>

        <div class="pr-[20px] text-[#B0A9F4] cursor-pointer" onclick="location.href='patients.php';">
            Quản lý bệnh nhân
        </div>

        <div class="pr-[20px] text-[#B0A9F4] cursor-pointer" onclick="location.href='dossiers.php';">
            Quản lý khám bệnh
        </div>

        <div class="pr-[20px] text-[#B0A9F4] cursor-pointer" onclick="location.href='statistical.php';">
            Báo cáo thống kê
        </div>
    </div>
</body>

</html>