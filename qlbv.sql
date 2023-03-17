-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 17, 2023 lúc 02:30 PM
-- Phiên bản máy phục vụ: 10.4.22-MariaDB
-- Phiên bản PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `qlbv`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdonthuoc`
--

CREATE TABLE `chitietdonthuoc` (
  `MaDonThuoc` int(11) NOT NULL,
  `MaThuoc` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `MaKH` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `chitietdonthuoc`
--

INSERT INTO `chitietdonthuoc` (`MaDonThuoc`, `MaThuoc`, `SoLuong`, `MaKH`) VALUES
(2, 3, 112, 1),
(3, 1, 21, 2),
(2, 3, 12, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietphieuchi`
--

CREATE TABLE `chitietphieuchi` (
  `MaPhieuChi` int(11) NOT NULL,
  `MaVatTu` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `MaNCC` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `chitietphieuchi`
--

INSERT INTO `chitietphieuchi` (`MaPhieuChi`, `MaVatTu`, `SoLuong`, `MaNCC`) VALUES
(1, 2, 1334, 1),
(2, 4, 1122, 2),
(1, 4, 1223, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donthuoc`
--

CREATE TABLE `donthuoc` (
  `MaDonThuoc` int(11) NOT NULL,
  `NgayLapDon` text NOT NULL,
  `MaNV` int(11) NOT NULL,
  `MaKH` int(11) NOT NULL,
  `GhiChu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `donthuoc`
--

INSERT INTO `donthuoc` (`MaDonThuoc`, `NgayLapDon`, `MaNV`, `MaKH`, `GhiChu`) VALUES
(2, '12/3/2020', 1, 1, ''),
(3, '15/9/2021', 2, 2, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donvitinh`
--

CREATE TABLE `donvitinh` (
  `MaDVT` int(11) NOT NULL,
  `TenDVT` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `donvitinh`
--

INSERT INTO `donvitinh` (`MaDVT`, `TenDVT`) VALUES
(1, 'Chiếc'),
(2, 'Viên'),
(3, 'Hộp'),
(4, 'Vỉ ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `MaKH` int(11) NOT NULL,
  `TenKH` text NOT NULL,
  `GioiTinh` bit(1) NOT NULL,
  `NgaySinh` text NOT NULL,
  `SDT` text NOT NULL,
  `Email` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`MaKH`, `TenKH`, `GioiTinh`, `NgaySinh`, `SDT`, `Email`) VALUES
(1, 'Nguyen Van A', b'1', '2013-03-14', '0123456', 'nguyenvana@gmail.com'),
(2, 'Nguyen Van B', b'1', '2014-03-06', '0123456', 'nguyenvanb@gmail.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhacungcap`
--

CREATE TABLE `nhacungcap` (
  `MaNCC` int(11) NOT NULL,
  `TenNCC` text NOT NULL,
  `DiaChi` text NOT NULL,
  `SDT` text NOT NULL,
  `Email` varchar(64) NOT NULL,
  `NguoiDaiDien` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `nhacungcap`
--

INSERT INTO `nhacungcap` (`MaNCC`, `TenNCC`, `DiaChi`, `SDT`, `Email`, `NguoiDaiDien`) VALUES
(1, 'Nhà cung cấp a', 'Hải Phòng', '0123456', 'nhacungcapa@gmail.com', 'nguyen van a'),
(2, 'Nhà cung cấp b', 'Hải Phòng', '0123456', 'nhacungcapb@gmail.com', 'nguyen van b');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MaNV` int(11) NOT NULL,
  `TenNV` text NOT NULL,
  `GioiTinh` bit(1) NOT NULL,
  `NgaySinh` text NOT NULL,
  `SDT` text NOT NULL,
  `Email` varchar(64) NOT NULL,
  `MaNTT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`MaNV`, `TenNV`, `GioiTinh`, `NgaySinh`, `SDT`, `Email`, `MaNTT`) VALUES
(1, 'Nguyen Van A', b'1', '2013-03-14', '0123456', 'nguyenvana@gmail.com', 1),
(2, 'Nguyen Van B', b'0', '2013-03-11', '0123456', 'nguyenvanb@gmail.com', 2),
(7, 'Nguyen Van C', b'1', '2023-03-29', '0123456', 'nguyenvanc@gmail.com', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhomthuthuat`
--

CREATE TABLE `nhomthuthuat` (
  `MaNTT` int(11) NOT NULL,
  `TenNTT` text NOT NULL,
  `MoTa` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `nhomthuthuat`
--

INSERT INTO `nhomthuthuat` (`MaNTT`, `TenNTT`, `MoTa`) VALUES
(1, 'Phẫu thuật', ''),
(2, 'Implant', ' Đây là nhóm thủ thuật nhằm cải thiện chức năng của răng bằng cách thay thế răng bị mất bằng implant'),
(3, 'Orthodontic', 'Nhóm thủ thuật này được sử dụng để điều chỉnh hàm răng và cải thiện vẻ ngoài của răng'),
(4, 'Endodontic', 'Đây là nhóm thủ thuật nhằm cải thiện chức năng của răng bằng cách xử lý các vấn đề về thần kinh trong răng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieuchi`
--

CREATE TABLE `phieuchi` (
  `MaPhieuChi` int(11) NOT NULL,
  `GiaThanh` bigint(20) NOT NULL,
  `ThoiGian` text NOT NULL,
  `GhiChu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `phieuchi`
--

INSERT INTO `phieuchi` (`MaPhieuChi`, `GiaThanh`, `ThoiGian`, `GhiChu`) VALUES
(1, 12340000, '12-2-2022', ''),
(2, 13450000, '13-2-2022', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieukham`
--

CREATE TABLE `phieukham` (
  `MaPhieuKham` int(11) NOT NULL,
  `ThoiGian` text NOT NULL,
  `MaNV` int(11) NOT NULL,
  `MaKH` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `phieukham`
--

INSERT INTO `phieukham` (`MaPhieuKham`, `ThoiGian`, `MaNV`, `MaKH`) VALUES
(1, '12/12/2022', 1, 1),
(2, '12/11/2022', 2, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `taikhoan`
--

CREATE TABLE `taikhoan` (
  `TenTK` varchar(32) NOT NULL,
  `MatKhau` varchar(32) NOT NULL,
  `Quyen` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `taikhoan`
--

INSERT INTO `taikhoan` (`TenTK`, `MatKhau`, `Quyen`) VALUES
('admin', '123456', 'admin'),
('admin2', '123456', 'employee'),
('test1', '123', 'employee'),
('test2', '123', 'employee'),
('VanHy', '123', 'admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thuoc`
--

CREATE TABLE `thuoc` (
  `MaThuoc` int(11) NOT NULL,
  `TenThuoc` text NOT NULL,
  `MaDVT` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `CongDung` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `thuoc`
--

INSERT INTO `thuoc` (`MaThuoc`, `TenThuoc`, `MaDVT`, `SoLuong`, `CongDung`) VALUES
(1, 'Paracetamol', 4, 120, 'Thuốc giảm đau và hạ sốt'),
(2, 'Aspirin', 4, 124, 'Thuốc giảm đau, hạ sốt và chống viêm'),
(3, 'Amoxicillin', 4, 12, 'Kháng sinh được sử dụng để điều trị nhiễm trùng'),
(4, 'Insulin', 4, 13, 'Hormone được sử dụng để điều trị bệnh đái tháo đường'),
(5, 'Diazepam', 4, 134, 'Thuốc an thần được sử dụng để điều trị lo âu, mất ngủ và co giật');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vattu`
--

CREATE TABLE `vattu` (
  `MaVT` int(11) NOT NULL,
  `TenVT` text NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `DonGia` int(11) NOT NULL,
  `MaDVT` int(11) NOT NULL,
  `MoTa` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `vattu`
--

INSERT INTO `vattu` (`MaVT`, `TenVT`, `SoLuong`, `DonGia`, `MaDVT`, `MoTa`) VALUES
(1, 'Kim tiêm', 134, 20000, 1, 'Là một dụng cụ y tế được sử dụng để tiêm thuốc, tiêm chủng, hoặc lấy mẫu máu.'),
(2, 'Khẩu trang', 12, 20000, 3, 'Là một dụng cụ y tế dùng để bảo vệ đường hô hấp khỏi các hạt bụi, vi khuẩn, virus và các tác nhân gây hại khác trong không khí.'),
(3, 'Găng tay y tế', 431, 100000, 3, 'Là một loại găng tay đặc biệt được thiết kế để đeo khi thực hiện các thủ tục y tế hoặc làm việc với các chất lỏng, chất độc hoặc chất dễ gây nhiễm trùng. '),
(4, 'Tourniquet', 123, 12000, 3, 'Là một loại băng cố định được sử dụng để tạm thời ngăn chặn lưu lượng máu đến một vùng cơ thể cụ thể.');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitietdonthuoc`
--
ALTER TABLE `chitietdonthuoc`
  ADD KEY `MaDonThuoc` (`MaDonThuoc`),
  ADD KEY `MaThuoc` (`MaThuoc`),
  ADD KEY `MaKH` (`MaKH`);

--
-- Chỉ mục cho bảng `chitietphieuchi`
--
ALTER TABLE `chitietphieuchi`
  ADD KEY `MaPhieuChi` (`MaPhieuChi`),
  ADD KEY `MaVatTu` (`MaVatTu`),
  ADD KEY `MaNCC` (`MaNCC`);

--
-- Chỉ mục cho bảng `donthuoc`
--
ALTER TABLE `donthuoc`
  ADD PRIMARY KEY (`MaDonThuoc`),
  ADD KEY `MaNV` (`MaNV`),
  ADD KEY `MaKH` (`MaKH`);

--
-- Chỉ mục cho bảng `donvitinh`
--
ALTER TABLE `donvitinh`
  ADD PRIMARY KEY (`MaDVT`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MaKH`);

--
-- Chỉ mục cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  ADD PRIMARY KEY (`MaNCC`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MaNV`),
  ADD KEY `MaNTT` (`MaNTT`);

--
-- Chỉ mục cho bảng `nhomthuthuat`
--
ALTER TABLE `nhomthuthuat`
  ADD PRIMARY KEY (`MaNTT`);

--
-- Chỉ mục cho bảng `phieuchi`
--
ALTER TABLE `phieuchi`
  ADD PRIMARY KEY (`MaPhieuChi`);

--
-- Chỉ mục cho bảng `phieukham`
--
ALTER TABLE `phieukham`
  ADD PRIMARY KEY (`MaPhieuKham`),
  ADD KEY `MaKH` (`MaKH`),
  ADD KEY `MaNV` (`MaNV`);

--
-- Chỉ mục cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`TenTK`);

--
-- Chỉ mục cho bảng `thuoc`
--
ALTER TABLE `thuoc`
  ADD PRIMARY KEY (`MaThuoc`);

--
-- Chỉ mục cho bảng `vattu`
--
ALTER TABLE `vattu`
  ADD PRIMARY KEY (`MaVT`),
  ADD KEY `MaDVT` (`MaDVT`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `donthuoc`
--
ALTER TABLE `donthuoc`
  MODIFY `MaDonThuoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `donvitinh`
--
ALTER TABLE `donvitinh`
  MODIFY `MaDVT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `MaKH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  MODIFY `MaNCC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `MaNV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `nhomthuthuat`
--
ALTER TABLE `nhomthuthuat`
  MODIFY `MaNTT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `phieuchi`
--
ALTER TABLE `phieuchi`
  MODIFY `MaPhieuChi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `phieukham`
--
ALTER TABLE `phieukham`
  MODIFY `MaPhieuKham` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `thuoc`
--
ALTER TABLE `thuoc`
  MODIFY `MaThuoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `vattu`
--
ALTER TABLE `vattu`
  MODIFY `MaVT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitietdonthuoc`
--
ALTER TABLE `chitietdonthuoc`
  ADD CONSTRAINT `chitietdonthuoc_ibfk_1` FOREIGN KEY (`MaDonThuoc`) REFERENCES `donthuoc` (`MaDonThuoc`),
  ADD CONSTRAINT `chitietdonthuoc_ibfk_3` FOREIGN KEY (`MaThuoc`) REFERENCES `thuoc` (`MaThuoc`),
  ADD CONSTRAINT `chitietdonthuoc_ibfk_4` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`);

--
-- Các ràng buộc cho bảng `chitietphieuchi`
--
ALTER TABLE `chitietphieuchi`
  ADD CONSTRAINT `chitietphieuchi_ibfk_2` FOREIGN KEY (`MaPhieuChi`) REFERENCES `phieuchi` (`MaPhieuChi`),
  ADD CONSTRAINT `chitietphieuchi_ibfk_3` FOREIGN KEY (`MaVatTu`) REFERENCES `vattu` (`MaVT`),
  ADD CONSTRAINT `chitietphieuchi_ibfk_4` FOREIGN KEY (`MaNCC`) REFERENCES `nhacungcap` (`MaNCC`);

--
-- Các ràng buộc cho bảng `donthuoc`
--
ALTER TABLE `donthuoc`
  ADD CONSTRAINT `donthuoc_ibfk_1` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`),
  ADD CONSTRAINT `donthuoc_ibfk_2` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`);

--
-- Các ràng buộc cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `nhanvien_ibfk_2` FOREIGN KEY (`MaNTT`) REFERENCES `nhomthuthuat` (`MaNTT`);

--
-- Các ràng buộc cho bảng `phieukham`
--
ALTER TABLE `phieukham`
  ADD CONSTRAINT `phieukham_ibfk_1` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`),
  ADD CONSTRAINT `phieukham_ibfk_2` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`);

--
-- Các ràng buộc cho bảng `vattu`
--
ALTER TABLE `vattu`
  ADD CONSTRAINT `vattu_ibfk_1` FOREIGN KEY (`MaDVT`) REFERENCES `donvitinh` (`MaDVT`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
