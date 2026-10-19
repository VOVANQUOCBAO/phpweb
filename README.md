# PHPWeb

Website bán hàng theo mô hình **MVC**, viết bằng **PHP thuần**, kết nối **MySQL qua PDO**.

**PHP 8+ cho chạy local** · **PHP 8.1+ khi cài Google API Client/deploy** · **MySQL / MariaDB**

> Giao diện khách hàng và khu vực quản trị MVC cùng đọc/ghi một CSDL MySQL qua Model. CSDL mới có thể nạp danh mục, sản phẩm và dữ liệu thử từ `database/du_lieu_mau.sql`.

## Chạy nhanh

1. Tải mã nguồn và giải nén; máy cần cài XAMPP có PHP 8 trở lên.
2. Nhấp đúp **`setup.bat`**. CSDL và các bảng còn thiếu sẽ được khởi tạo tự động.
3. Mở **http://127.0.0.1:8000/**.

Chạy local không cần cài Composer. Để bật Google Sign-In cần cài dependencies bằng Composer; xem [hướng dẫn triển khai](support/DEPLOYMENT.md). Nếu MySQL có mật khẩu riêng, sửa `support/config/database.local.php`. [Xem cấu hình và cách chạy khác →](support/README.md)

Trang quản trị: **http://127.0.0.1:8000/index.php?khu=admin**. Khi tạo mới, mật khẩu Admin ngẫu nhiên chỉ được in một lần ở cửa sổ setup; không có thông tin đăng nhập mẫu an toàn để dùng trên website công khai.

Sau khi đăng nhập admin, mở **http://127.0.0.1:8000/index.php?khu=admin&act=csdl** để xem trực tiếp các bảng, số bản ghi và dữ liệu mới nhất trong CSDL. Trang chỉ đọc, chỉ dành cho admin; cột mật khẩu/token được ẩn. Mỗi thao tác của user/admin được lưu qua các luồng ứng dụng và xuất hiện khi tải lại bảng tương ứng.

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
| Hosting PHP/MySQL miễn phí và Google Sign-In | [support/DEPLOYMENT.md](support/DEPLOYMENT.md) |

**Kiểm thử:** Chạy `support/tests/test_luong.php` để xem kết quả mới nhất. Bộ test dùng CSDL tạm riêng, giữ nguyên dữ liệu ứng dụng.

**Email:** gửi Gmail thật cần `SMTP_USER` và `SMTP_PASS`; nếu gửi OTP thất bại, mã không được hiển thị ra trình duyệt. Bản sao email của đơn hàng vẫn được lưu trong CSDL.

**Chatbox AI:** khung chat ở footer đã hoạt động với phản hồi mặc định. Để bật AI thật, tạo `support/config/chatbot.local.php` dựa trên `support/config/chatbot.example.php` và điền key API. Nếu không cấu hình hoặc key không hợp lệ, chatbot sẽ tự động dùng logic gợi ý sản phẩm của website.
