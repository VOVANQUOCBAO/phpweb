# Chạy và ghép View cho bài MVC PHP

Mã nguồn dự án nằm trong thư mục `phpweb-main` bên trong. Dự án dùng PHP thuần, PDO và MySQL đi kèm XAMPP ở `D:\data`. Hai Controller Admin và toàn bộ View được giữ nguyên.

## Chạy trên máy hiện tại

Mở PowerShell tại thư mục mã nguồn và chạy:

```powershell
.\tools\chay_local.ps1
```

Mở `http://localhost:8000/controller/index.php`. Script chạy PHP của XAMPP bằng server phát triển tích hợp và MySQL của XAMPP ở cổng **3307**. Dịch vụ MariaDB cài riêng đang chiếm cổng 3306. Script không cài dịch vụ Windows hay đổi cấu hình Apache/XAMPP toàn cục. Các tiến trình chạy nền; script in PID để có thể dừng bằng `Stop-Process -Id <PID>` khi xong.

Cấu hình hiện tại: host `127.0.0.1`, port `3307`, CSDL `webbanhang_mvc`, user `root`, mật khẩu rỗng. Thay đổi trong `config/database.local.php` khi đổi máy; lấy mẫu từ `database.example.php`. File local không đưa vào Git. Các biến môi trường `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS` được ưu tiên hơn file local.

Khởi tạo bảng bằng `D:\data\php\php.exe tools/khoitao_csdl.php`. SQL chỉ tạo bảng còn thiếu và tài khoản mẫu còn thiếu, giữ nguyên dữ liệu cũ. Có thể tạo CSDL utf8mb4 trong phpMyAdmin, chọn CSDL rồi import `sql/schema.sql`; kết nối phải trỏ đúng MySQL XAMPP ở cổng 3307.

## Kiểm tra luồng dữ liệu

```powershell
& 'D:\data\php\php.exe' tools/test_luong.php
```

Test tự tạo CSDL tên `webbanhang_mvc_test_<chuỗi ngẫu nhiên>`, tạo dữ liệu thử, chạy HTTP với các cookie Session riêng và chạy các tiến trình đồng thời. Cuối lượt test sẽ xóa riêng CSDL vừa tạo và kiểm tra số bản ghi CSDL ứng dụng vẫn giữ nguyên. Script chỉ chạy bằng CLI. Báo cáo nằm ở `tools/ketqua_test.json`; mã thoát 0 nghĩa là mọi kiểm tra đều đạt.

Các nhóm kiểm tra: CRUD, đăng ký/đăng nhập/khóa tài khoản, giỏ hàng, giá khuyến mãi/voucher/phí ship, thanh toán, rollback, hủy đơn/hoàn kho, bom/trả hàng, một chiều trạng thái, điểm/hạng, doanh thu, đánh giá, hộp thư, quyền sở hữu đơn, đăng xuất và cạnh tranh tồn kho/voucher/hoàn kho/điểm. Có một ca cố ý làm INSERT chi tiết lỗi để chứng minh rollback; thông báo `Test rollback` trong log là dự kiến.

## Hợp đồng Controller User với View

Mọi thao tác gọi `controller/index.php?act=...` (cũng nhận `case`). Dữ liệu form là các trường đơn, không phải mảng. Giỏ Session có dạng `[id_sanpham => so_luong]`. Các View chỉ đọc biến do `render()` đưa vào; không cần query SQL. Khi View chưa tồn tại, Controller trả JSON có cùng các trường.

| act | Dữ liệu gửi | View / biến chính |
| --- | --- | --- |
| `trangchu`, `timkiem` | GET `q`, `id_danhmuc`, `sapxep=moi/cu`, `trang`, `moi_trang` | `trangchu.php`: `ds_danhmuc`, `ds_sanpham`, `sp_moi`, `sp_km`, `trang`, `moi_trang`, `tong_sanpham`, `con_tiep` |
| `dangky` | POST `ho_ten`, `email`, `mat_khau`, `ngay_sinh` (YYYY-MM-DD, tùy chọn) | `dangky.php` |
| `dangnhap` | POST `email`, `mat_khau` | `dangnhap.php`; thành công lưu `user` vào Session và chuyển về trang chủ |
| `dangxuat` | GET | Xóa Session user và giỏ, đổi Session ID, chuyển về trang chủ |
| `chitiet` | GET `id` | `chitiet_sanpham.php`: `chitiet`, `ds_danhgia` |
| `themdanhgia` | POST `id_sanpham`, `so_sao` (1–5), `noi_dung` | `chitiet_sanpham.php`: cùng cấu trúc như xem chi tiết |
| `giohang` | GET | `giohang.php`: `giohang` gồm `items` và `tong` |
| `themgiohang`, `suagiohang`, `xoagiohang` | `id`, `sl` (thêm mặc định 1; sửa 0 để xóa dòng) | `giohang.php`; `sl` phải là số nguyên, không âm hoặc vượt tồn |
| `thanhtoan` | GET xem giỏ; POST `dia_chi`, `sdt`, `ma_voucher` (tùy chọn) | `thanhtoan.php`: `giohang`, `user`; thành công thêm `ok`, `id_don`, `donhang`, `email_result` |
| `lichsumuahang` | GET | `lichsu_muahang.php`: `ds_donhang` |
| `huydonhang` | `id`, POST `ly_do` | `lichsu_muahang.php`: `ds_donhang`; chỉ chủ đơn và đơn Chờ xác nhận |
| `khieunai` | POST `id`, `noi_dung` | `lichsu_muahang.php`: lưu thư loại `khieunai` |
| `theodoidonhang` | GET `id` | `theodoi_donhang.php`: `donhang` có `chitiet`, `timeline` |
| `hopthu` | GET | `hopthu.php`: `ds_thu` của khách đang đăng nhập |

Các trang có `thongBao` và `loi` (null khi không có). `sp_moi`, `sp_km` và `ds_sanpham` đều là danh sách sản phẩm, có `gia_goc`, `gia_km`, `het_hang`. `sp_km` không phải danh sách chương trình khuyến mãi. Nút Xem thêm tăng `trang`, giữ nguyên bộ lọc, dùng `con_tiep` để biết còn dữ liệu.

Mỗi item giỏ có `id`, `ma_sp`, `ten_sp`, `hinh`, `gia`, `so_luong`, `ton`, `thanh_tien`, `het_hang`. Tổng giỏ là tổng hàng sau khuyến mãi, chưa tính voucher và phí ship. Giá luôn được tính lại phía server khi đặt hàng. Nếu nhiều chương trình khuyến mãi trùng nhau, lấy phần trăm cao nhất.

Trạng thái đơn: Chờ xác nhận → Xác nhận đơn hàng → Đang giao → Đã giao → Thành công. Đang giao có nhánh Bom hàng/Trả hàng; Chờ xác nhận có nhánh Đã hủy. Model khóa bản ghi trong giao dịch để trừ kho, hoàn kho và cộng điểm đúng một lần. Hoàn kho không vượt `so_luong_goc`. Hủy đơn không hoàn lượt voucher (PDF không yêu cầu hoàn lượt).

Quy ước có thể chỉnh trong Model: phí ship 30.000đ; mỗi 1.000đ tổng đơn thành công được 1 điểm; Gold từ 500 điểm, Diamond từ 2.000 điểm; Gold/Diamond miễn ship. Voucher gán hạng chỉ dùng cho đúng hạng đó. PDF không ấn định các ngưỡng này.

## Email Gmail SMTP

Đã cài PHPMailer bằng Composer, khóa phiên bản trong `composer.lock`. Khi chuyển máy dùng `composer install`. Thư viện gửi mail này không phải framework MVC. Tài liệu: [PHPMailer chính thức](https://github.com/PHPMailer/PHPMailer).

Đặt biến môi trường `SMTP_USER` (Gmail), `SMTP_PASS` (mật khẩu ứng dụng), tùy chọn `SMTP_FROM`, rồi khởi động lại server PHP. Không ghi mật khẩu vào mã nguồn. SMTP dùng `smtp.gmail.com`, port 587, STARTTLS, timeout 10 giây.

Khi chưa cấu hình Gmail hoặc gửi thất bại, đơn vẫn được lưu, giỏ đã xóa và bản sao thư vẫn nằm trong bảng `email`. Kết quả `email_result.smtp.ok` cho biết trạng thái gửi ra ngoài. Test chủ động vô hiệu hóa SMTP để không gửi email thật. Việc gửi Gmail thật cần tài khoản và thông tin SMTP của bạn; chưa được kiểm chứng bằng hộp thư thật.
