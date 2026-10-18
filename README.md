# Website bán hàng MVC — PHP thuần

Model và Controller viết bằng PHP thuần, kết nối MySQL qua PDO, giỏ hàng dùng Session. Dự án đang ở giai đoạn backend; khi chưa có View tương ứng, Controller trả JSON để kiểm tra dữ liệu.

## Lấy về và chạy với XAMPP trên Windows

1. Clone repository hoặc tải ZIP rồi giải nén.
2. Cài XAMPP có PHP **8.0 trở lên**.
3. Nhấp đúp **`setup.bat`** ở thư mục gốc.
4. Mở **http://localhost:8000/**.

Script tự tìm XAMPP tại `C:\xampp`, `D:\xampp`, `D:\data` hoặc biến môi trường `XAMPP_PATH`; tạo cấu hình local nếu chưa có; khởi động MySQL nếu cần; tạo CSDL và các bảng còn thiếu; chạy PHP của XAMPP. Không cần cài Composer cho bản tải về này vì phần PHPMailer cần dùng đã kèm trong `lib/PHPMailer/`.

Nếu XAMPP nằm ở chỗ khác hoặc dùng cổng MySQL khác:

```powershell
.\tools\chay_local.ps1 -XamppPath 'E:\xampp' -MySqlPort 3307 -WebPort 8000
```

XAMPP mặc định dùng MySQL port 3306, user `root`, mật khẩu rỗng. Nếu bạn đặt mật khẩu hoặc đổi tên CSDL, sửa `config/database.local.php`. File cấu hình riêng này được Git bỏ qua. Biến `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS` có thể ghi đè cấu hình.

Script chạy PHP bằng server phát triển tích hợp, không cần chép mã nguồn sang `htdocs`. Nếu muốn dùng Apache của XAMPP, đặt thư mục dự án vào `htdocs/phpweb`, bật Apache/MySQL, import SQL theo hướng dẫn dưới rồi mở `http://localhost/phpweb/`.

## Cơ sở dữ liệu trên GitHub

Thư mục **[`database/`](database/)** có file **[`webbanhang_mvc.sql`](database/webbanhang_mvc.sql)** để import trực tiếp bằng phpMyAdmin. File tự tạo CSDL và 10 bảng, không xóa dữ liệu đang có. Chi tiết xem [`database/README.md`](database/README.md).

`sql/schema.sql` là bản chuẩn dành cho script khởi tạo và test. SQL đóng gói chỉ có cấu trúc và tài khoản mẫu, không có dữ liệu cá nhân hoặc thông tin đăng nhập MySQL của người phát triển.

## Kiểm thử và ghép giao diện

```powershell
& 'C:\xampp\php\php.exe' tools/test_luong.php
```

Thay đường dẫn PHP cho đúng máy. Test tự tạo/xóa CSDL tạm riêng, kiểm tra Model, HTTP Controller User, Session, thanh toán, rollback và các thao tác đồng thời; không xóa bảng trong CSDL ứng dụng. Lượt kiểm thử backend hiện tại: **67 PASS, 0 FAIL**.

Hợp đồng các `act`, trường form và dữ liệu truyền sang View nằm tại [`tools/HUONG_DAN.md`](tools/HUONG_DAN.md). Phần View và hai Controller Admin hiện có được giữ nguyên.

## Email

Đã kèm PHPMailer 7.1.1 và giấy phép trong `lib/PHPMailer/`. Có thể dùng Composer với `composer install` nếu muốn quản lý thư viện qua `composer.lock`. Xem [PHPMailer chính thức](https://github.com/PHPMailer/PHPMailer).

Để gửi Gmail thật, đặt `SMTP_USER`, `SMTP_PASS` và tùy chọn `SMTP_FROM`, rồi khởi động lại server PHP. Nếu chưa cấu hình SMTP, hệ thống vẫn lưu đơn, xóa giỏ và lưu bản sao thư vào bảng `email`; kết quả trả về cho biết email chưa gửi ra ngoài. Test không gửi email thật.
