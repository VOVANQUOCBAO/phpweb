-- Ban dong goi de import truc tiep bang phpMyAdmin.
-- Cau truc va tai khoan mau; khong co du lieu khach hang/don hang that.
CREATE DATABASE IF NOT EXISTS webbanhang_mvc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE webbanhang_mvc;
-- Chon CSDL trong phpMyAdmin truoc khi import, hoac chay support/scripts/khoitao_csdl.php.
-- Script chi tao bang con thieu, khong xoa bang hay du lieu dang co.

CREATE TABLE IF NOT EXISTS danhmuc (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ten_danhmuc VARCHAR(150) NOT NULL,
  mo_ta TEXT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS sanpham (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ma_sp VARCHAR(50) NOT NULL UNIQUE,
  ten_sp VARCHAR(255) NOT NULL,
  id_danhmuc INT NOT NULL,
  gia DECIMAL(12,2) NOT NULL,
  so_luong_goc INT NOT NULL,
  so_luong_ton INT NOT NULL,
  hinh VARCHAR(255) NULL,
  mo_ta TEXT NULL,
  ngay_tao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  han_su_dung DATE NULL,
  CONSTRAINT fk_sp_dm FOREIGN KEY (id_danhmuc) REFERENCES danhmuc(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS khachhang (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ho_ten VARCHAR(150) NOT NULL,
  ten_dang_nhap VARCHAR(100) NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  google_sub VARCHAR(255) NULL UNIQUE,
  sdt VARCHAR(20) NULL,
  mat_khau VARCHAR(255) NOT NULL,
  ngay_sinh DATE NULL,
  hang ENUM('Silver','Gold','Diamond') NOT NULL DEFAULT 'Silver',
  diem INT NOT NULL DEFAULT 0,
  trang_thai TINYINT NOT NULL DEFAULT 1,
  so_lan_huy INT NOT NULL DEFAULT 0,
  so_lan_bom INT NOT NULL DEFAULT 0,
  so_lan_tra INT NOT NULL DEFAULT 0,
  ngay_dang_ky DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS nhanvien (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ho_ten VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  mat_khau VARCHAR(255) NOT NULL,
  vai_tro VARCHAR(50) NOT NULL DEFAULT 'NhanVien',
  trang_thai TINYINT NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS danhgia (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_sanpham INT NOT NULL,
  id_khachhang INT NOT NULL,
  so_sao TINYINT NOT NULL,
  noi_dung TEXT NOT NULL,
  trang_thai TINYINT NOT NULL DEFAULT 1,
  ngay_tao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_dg_sp FOREIGN KEY (id_sanpham) REFERENCES sanpham(id),
  CONSTRAINT fk_dg_kh FOREIGN KEY (id_khachhang) REFERENCES khachhang(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS voucher (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ma_code VARCHAR(50) NOT NULL UNIQUE,
  loai ENUM('tien','phantram','mienship') NOT NULL,
  gia_tri DECIMAL(12,2) NOT NULL DEFAULT 0,
  so_luong INT NOT NULL DEFAULT 0,
  ngay_bd DATE NOT NULL,
  ngay_kt DATE NOT NULL,
  hang_ap_dung VARCHAR(20) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS khuyenmai (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ten_km VARCHAR(150) NOT NULL,
  loai ENUM('sanpham','danhmuc') NOT NULL,
  id_sanpham INT NULL,
  id_danhmuc INT NULL,
  phan_tram DECIMAL(5,2) NOT NULL DEFAULT 0,
  ngay_bd DATE NOT NULL,
  ngay_kt DATE NOT NULL,
  ghi_chu VARCHAR(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS donhang (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_khachhang INT NOT NULL,
  tong_tien DECIMAL(12,2) NOT NULL,
  phi_ship DECIMAL(12,2) NOT NULL DEFAULT 0,
  ma_voucher VARCHAR(50) NULL,
  dia_chi VARCHAR(255) NOT NULL,
  sdt VARCHAR(20) NOT NULL,
  trang_thai VARCHAR(50) NOT NULL DEFAULT 'Chờ xác nhận',
  ly_do_huy TEXT NULL,
  ngay_dat DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  ngay_cap_nhat DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_dh_kh FOREIGN KEY (id_khachhang) REFERENCES khachhang(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS chitietdonhang (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_donhang INT NOT NULL,
  id_sanpham INT NOT NULL,
  so_luong INT NOT NULL,
  don_gia DECIMAL(12,2) NOT NULL,
  CONSTRAINT fk_ct_dh FOREIGN KEY (id_donhang) REFERENCES donhang(id),
  CONSTRAINT fk_ct_sp FOREIGN KEY (id_sanpham) REFERENCES sanpham(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS email (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_khachhang INT NOT NULL,
  tieu_de VARCHAR(255) NOT NULL,
  noi_dung TEXT NOT NULL,
  ngay_gui DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  loai VARCHAR(50) NOT NULL DEFAULT 'hethong',
  CONSTRAINT fk_em_kh FOREIGN KEY (id_khachhang) REFERENCES khachhang(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
