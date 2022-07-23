-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jul 22, 2022 at 02:09 PM
-- Server version: 5.7.32
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `DichVuDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `DICHVU`
--

CREATE TABLE `DICHVU` (
  `MaDV` int(11) NOT NULL,
  `TenDV` varchar(40) NOT NULL,
  `LoaiDV` varchar(40) NOT NULL,
  `DonGia` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `DICHVU`
--

INSERT INTO `DICHVU` (`MaDV`, `TenDV`, `LoaiDV`, `DonGia`) VALUES
(1, 'Vệ sinh máy lạnh 1 HP', 'MAYLANH', 150000),
(2, 'Vệ sinh máy lạnh 2 HP', 'MAYLANH', 200000),
(3, 'Lắp đặt bóng đèn điện 1', 'SUADIEN', 100000),
(4, 'Lắp đặt bóng đèn điện 2', 'SUADIEN', 120000);

-- --------------------------------------------------------

--
-- Table structure for table `DONHANG`
--

CREATE TABLE `DONHANG` (
  `MaDH` int(11) NOT NULL,
  `TenKH` varchar(30) NOT NULL,
  `DienThoai` varchar(11) NOT NULL,
  `DiaChi` varchar(50) NOT NULL,
  `ThoiGianBD` datetime NOT NULL,
  `TrangThai` varchar(10) NOT NULL,
  `ThoiGianKT` datetime NOT NULL,
  `MaDV` int(11) NOT NULL,
  `SoLuong` float NOT NULL,
  `ThanhTien` float NOT NULL,
  `GhiChu` varchar(100) NOT NULL,
  `MaDangKy` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `DONHANG`
--

INSERT INTO `DONHANG` (`MaDH`, `TenKH`, `DienThoai`, `DiaChi`, `ThoiGianBD`, `TrangThai`, `ThoiGianKT`, `MaDV`, `SoLuong`, `ThanhTien`, `GhiChu`, `MaDangKy`) VALUES
(1, 'Nguyễn Văn A', '0912123123', '134 Nguyễn Thị Thập, Quận 7, Hồ Chí Minh', '2022-07-22 08:00:00', 'HOANTAT', '2022-07-22 08:00:00', 1, 2, 300000, 'Vệ sinh 2 máy lạnh Toshiba', '83591356');

-- --------------------------------------------------------

--
-- Table structure for table `TAIKHOAN`
--

CREATE TABLE `TAIKHOAN` (
  `TenTK` varchar(30) NOT NULL,
  `MatKhau` varchar(30) NOT NULL,
  `LoaiTK` int(11) NOT NULL,
  `TinhTrang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `TAIKHOAN`
--

INSERT INTO `TAIKHOAN` (`TenTK`, `MatKhau`, `LoaiTK`, `TinhTrang`) VALUES
('admin', '123456', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `DICHVU`
--
ALTER TABLE `DICHVU`
  ADD PRIMARY KEY (`MaDV`);

--
-- Indexes for table `DONHANG`
--
ALTER TABLE `DONHANG`
  ADD PRIMARY KEY (`MaDH`),
  ADD UNIQUE KEY `MaDangKy` (`MaDangKy`);

--
-- Indexes for table `TAIKHOAN`
--
ALTER TABLE `TAIKHOAN`
  ADD PRIMARY KEY (`TenTK`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `DICHVU`
--
ALTER TABLE `DICHVU`
  MODIFY `MaDV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `DONHANG`
--
ALTER TABLE `DONHANG`
  MODIFY `MaDH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;