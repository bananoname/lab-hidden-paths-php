# Hidden Paths: Fuzz & Find

**Author:** BanaNoName
---

## 1. Mục tiêu của Lab

Trong môi trường thực tế, nhiều endpoint và tài nguyên nhạy cảm không được hiển thị công khai qua giao diện chính. Thay vào đó, chúng được “ẩn” phía sau các đường dẫn đặc biệt, cơ chế xác thực gián tiếp hoặc kỹ thuật lọc đơn giản. Bài lab này mô phỏng lại các tình huống như vậy để học viên thực hành kỹ thuật phát hiện và khai thác.

Người học sẽ được trang bị và thực hành các kỹ năng sau:
- Fuzzing URL: sử dụng công cụ như FFUF để tìm các endpoint ẩn (ví dụ /admin, /private, /api/v1/internal) không có liên kết rõ ràng.
- Fuzzing file mở rộng: phát hiện file backup như .bak, .old, .php~ bị bỏ quên và chứa thông tin nhạy cảm.
- Bypass header: tiếp cận khu vực quản trị thông qua giả mạo header như X-Forwarded-For, mô phỏng lỗi cấu hình phổ biến trong thực tế.
- Tìm file cấu hình ẩn: ví dụ config.php trong folder nội bộ, từ đó truy xuất thông tin nhạy cảm như secret, token.
- Khai thác JWT: đăng nhập để lấy JWT, decode và tìm cách sử dụng token để truy cập các vùng giới hạn.
- Phân tích file sitemap, robots.txt: tìm dấu vết endpoint bị “cấm dò” để dẫn đến các tài nguyên bị ẩn.
- Hiểu và tận dụng cơ chế bảo vệ bằng .htaccess: tránh bị block, hoặc tìm cách khai thác từ các file mồi bị rò.

Mỗi bước sẽ dẫn dắt học viên dần dần tiếp cận các flag, nâng cao tư duy phân tích hệ thống từ góc nhìn tấn công.
---

## 2. Môi trường

- PHP 8.1 + Apache trên Docker
- Domain nội bộ: `http://secureportal.local:8080`

### Cấu trúc thư mục chính:
```
public/          - Giao diện chính
api/v1/          - API lộ/lén
admin/           - Trang quản trị bảo vệ bằng header
private/         - Trang yêu cầu JWT
flags/           - Flag ẩn, bị cấm truy cập trực tiếp
```

---

## 3. Hướng dẫn sử dụng

### Bước 1: Cài đặt domain nội bộ
Thêm vào file `/etc/hosts` (Linux/macOS) hoặc `C:\Windows\System32\drivers\etc\hosts`:
```
127.0.0.1 secureportal.local
```

### Bước 2: Khởi động lab
```bash
docker-compose up --build
```

### Bước 3: Truy cập giao diện
Truy cập: [http://secureportal.local:8080](http://secureportal.local:8080)

- Đăng nhập với bất kỳ tài khoản mẫu được cấp trong `auth.php`
- Khám phá chức năng, thử truy cập trái phép để xác định vùng cần fuzz

---

## 4. Hướng dẫn Fuzz

### Fuzz URL (ẩn trong `robots.txt`, `sitemap.xml`, và các folder nghi ngờ)
```bash
ffuf -u http://secureportal.local:8080/FUZZ -w wordlist.txt
```

### Fuzz file backup, extension lộ:
```bash
ffuf -u http://secureportal.local:8080/hidden/indexFUZZ -w extensions.txt -e .bak,.old,.php~
```

### Fuzz header bypass (Admin):
```bash
ffuf -u http://secureportal.local:8080/admin/admin.php -H "X-Forwarded-For: FUZZ" -w bypass-ips.txt
```

### Fuzz endpoint API
```bash
ffuf -u http://secureportal.local:8080/api/v1/FUZZ -w endpoints.txt
```

---

## 5. Gợi ý cho học viên

- Đọc kỹ mã lỗi HTTP (403, 401, 500...) để xác định manh mối
- Kết hợp `.htaccess`, `robots.txt`, `index.bak`, `jwt` để lần ra logic hệ thống
- Dò JWT bằng cách đăng nhập rồi decode payload và fuzz tiếp với token hợp lệ
- Một số flag yêu cầu kết hợp nhiều kỹ thuật để truy xuất: fuzz + bypass + JWT

---

Chúc bạn chinh phục được toàn bộ flag của lab Hidden Paths!
