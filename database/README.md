# Cơ sở dữ liệu

`webbanhang_mvc.sql` chứa cấu trúc 10 bảng và tài khoản mẫu của bài MVC. Đây là file SQL có thể đưa lên GitHub; dữ liệu MySQL đang chạy vẫn nằm trên máy của mỗi người.

## Cách nhanh

Chạy `setup.bat` tại thư mục gốc. Script tự khởi tạo CSDL/bảng bằng `sql/schema.sql`, không cần import tay. File `sql/schema.sql` là bản chuẩn để code và test sử dụng; `database/webbanhang_mvc.sql` là bản đóng gói để import trong phpMyAdmin.

## Import qua phpMyAdmin

1. Bật Apache và MySQL trong XAMPP.
2. Mở `http://localhost/phpmyadmin` và chọn Import.
3. Chọn `database/webbanhang_mvc.sql`, bấm Go/Thực hiện.
4. File tự tạo CSDL `webbanhang_mvc` và 10 bảng. Không có lệnh DROP hay TRUNCATE.

Nếu không có quyền tạo CSDL, tạo `webbanhang_mvc` trước, chọn CSDL đó rồi import `sql/schema.sql`.

Máy XAMPP mặc định dùng host `127.0.0.1`, port `3306`, user `root`, mật khẩu rỗng. Cấu hình riêng đặt trong `config/database.local.php` theo file mẫu `config/database.example.php`. Máy đang phát triển dùng port `3307`; cấu hình riêng đó không được đưa lên GitHub.

File SQL không chứa khách hàng, đơn hàng, email thật hoặc mật khẩu kết nối MySQL. Tài khoản nhân viên mẫu có email `admin@local.test`, mật khẩu `password`; mật khẩu được lưu dưới dạng hash. Các bảng nghiệp vụ khác ban đầu rỗng để nhóm tự nhập dữ liệu.

Không đưa thư mục vật lý `xampp/mysql/data` lên GitHub. Khi thay đổi bảng, cập nhật `sql/schema.sql` rồi tạo lại bản đóng gói `database/webbanhang_mvc.sql` với phần đầu CREATE DATABASE/USE tương ứng.
