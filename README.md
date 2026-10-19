# PHPWeb

Website bán hàng theo mô hình **MVC**, viết bằng **PHP thuần**, kết nối **MySQL qua PDO**.

**PHP 8+** · **MySQL / MariaDB** · **XAMPP** · **PHPMailer**

> Bản hiện tại có giao diện khách hàng và khu vực quản trị MVC; dữ liệu màn hình được đọc/ghi qua Model và MySQL. CSDL mới chỉ có tài khoản quản trị mẫu, các danh mục, sản phẩm và dữ liệu nghiệp vụ cần được nhập qua trang quản trị.

## Chạy nhanh

1. Tải mã nguồn và giải nén; máy cần cài XAMPP có PHP 8 trở lên.
2. Nhấp đúp **`setup.bat`**. CSDL và các bảng còn thiếu sẽ được khởi tạo tự động.
3. Mở **http://127.0.0.1:8000/**.

Không cần cài Composer. Nếu MySQL có mật khẩu riêng, sửa `support/config/database.local.php`. [Xem cấu hình và cách chạy khác →](support/README.md)

Trang quản trị: **http://127.0.0.1:8000/index.php?khu=admin**. Tài khoản mẫu: `admin@local.test` / `password`.

## Cấu trúc

```text
phpweb/
├── controller/     Điều hướng và xử lý yêu cầu
├── model/          Truy vấn dữ liệu và nghiệp vụ
├── view/           Giao diện do nhóm phát triển
├── database/       SQL và hướng dẫn import
├── support/        Cấu hình, thư viện, script và kiểm thử
├── index.php       Điểm vào ứng dụng
└── setup.bat       Khởi động với XAMPP
```

## Tài liệu

| Nội dung | Tài liệu |
| --- | --- |
| Import CSDL bằng phpMyAdmin | [database/README.md](database/README.md) |
| Cấu hình, kiểm thử và ghép View | [support/README.md](support/README.md) |

**Kiểm thử:** 78/78 ca đạt, bao gồm Model, luồng HTTP khách hàng/quản trị, giao diện storefront/checkout, Session, rollback và xử lý đồng thời. Test dùng CSDL tạm riêng, giữ nguyên dữ liệu ứng dụng.

**Email:** có sẵn PHPMailer. Gửi Gmail thật cần `SMTP_USER` và `SMTP_PASS`; khi chưa cấu hình, hệ thống vẫn lưu bản sao thư trong CSDL.

**Chatbox AI:** khung chat ở footer đã hoạt động với phản hồi mặc định. Để bật AI thật, tạo `support/config/chatbot.local.php` dựa trên `support/config/chatbot.example.php` và điền key API. Nếu không cấu hình hoặc key không hợp lệ, chatbot sẽ tự động dùng logic gợi ý sản phẩm của website.
