### Sao lưu gia tăng (Incremental Backup) trong MySQL bằng Binary Logs

**Sao lưu gia tăng** là quá trình chỉ sao lưu những thay đổi đã xảy ra kể từ lần sao lưu trước. Trong MySQL, phương pháp này được thực hiện bằng cách sử dụng **binary logs** để ghi lại tất cả các thao tác thay đổi dữ liệu (INSERT, UPDATE, DELETE, etc.). Khi cần khôi phục dữ liệu, ta sử dụng bản sao lưu toàn bộ (full backup) và áp dụng các bản sao lưu gia tăng (binary logs) để cập nhật những thay đổi mới nhất.

### Các bước triển khai sao lưu gia tăng bằng Binary Logs:

#### Bước 1: Bật Binary Logging trên MySQL

Để bật **binary logs**, bạn cần cấu hình tệp cấu hình MySQL (`my.cnf` hoặc `my.ini` tùy hệ điều hành) như sau:

```ini
[mysqld]
server-id = 1                # Đặt ID cho máy chủ, giá trị phải là duy nhất nếu có replication
log_bin = /var/log/mysql/mysql-bin  # Đường dẫn lưu trữ binary log
expire_logs_days = 7         # Thời gian lưu trữ binary log (7 ngày)
binlog_format = ROW          # Định dạng binary log. Có thể là ROW, STATEMENT hoặc MIXED (ROW là tốt nhất cho sao lưu gia tăng)
```

Sau khi chỉnh sửa, khởi động lại MySQL:

```bash
sudo service mysql restart
```

#### Bước 2: Tạo bản sao lưu toàn bộ

Trước khi thực hiện sao lưu gia tăng, cần tạo một bản sao lưu toàn bộ đầu tiên. Sử dụng lệnh `mysqldump`:

```bash
mysqldump -u root -p --all-databases --single-transaction --flush-logs --master-data=2 > /backup/full_backup.sql
```

**Giải thích các tùy chọn:**
- `--all-databases`: Sao lưu tất cả các cơ sở dữ liệu.
- `--single-transaction`: Đảm bảo rằng bản sao lưu nhất quán (không khóa bảng trong quá trình sao lưu).
- `--flush-logs`: Tạo một binary log mới để theo dõi các thay đổi tiếp theo.
- `--master-data=2`: Ghi thông tin về vị trí binary log vào bản sao lưu để thuận tiện cho việc khôi phục.

#### Bước 3: Sao lưu các binary logs

Sau khi bật binary logs, MySQL sẽ tự động ghi lại các thay đổi vào các tệp binary log. Để thực hiện sao lưu gia tăng, bạn cần lưu trữ các tệp binary log này.

Ví dụ, để sao lưu các binary logs, bạn có thể sao chép chúng sang thư mục sao lưu:

```bash
cp /var/log/mysql/mysql-bin.* /backup/incremental/
```

Lưu ý: Mỗi khi có một binary log mới được tạo ra, bạn cần sao chép chúng để đảm bảo rằng dữ liệu sao lưu đầy đủ.

#### Bước 4: Khôi phục từ bản sao lưu toàn bộ và binary logs

Khi cần khôi phục dữ liệu, bạn có thể làm theo các bước sau:

1. **Khôi phục bản sao lưu toàn bộ**:

```bash
mysql -u root -p < /backup/full_backup.sql
```

2. **Áp dụng binary logs để khôi phục các thay đổi**:
   - Trước khi áp dụng binary logs, kiểm tra file binary log và vị trí từ bản sao lưu toàn bộ (`/backup/full_backup.sql`) đã chứa thông tin về file binary log đầu tiên và vị trí bắt đầu.

   Ví dụ, nếu `full_backup.sql` ghi nhận rằng nó dừng tại file `mysql-bin.000001`, bạn có thể khôi phục các binary logs từ file đó trở đi:

```bash
mysqlbinlog /backup/incremental/mysql-bin.000001 | mysql -u root -p
mysqlbinlog /backup/incremental/mysql-bin.000002 | mysql -u root -p
```

### Giải thích các bước:

- **mysqldump**: Tạo bản sao lưu toàn bộ cơ sở dữ liệu vào một tệp SQL.
- **Binary Logs**: Theo dõi các thay đổi (INSERT, UPDATE, DELETE) trong thời gian thực và ghi chúng vào các tệp nhị phân.
- **mysqlbinlog**: Công cụ để đọc và áp dụng các tệp binary logs trở lại MySQL nhằm khôi phục các thay đổi đã xảy ra sau khi bản sao lưu toàn bộ được tạo.

### Quy trình tổng quan:

1. **Tạo bản sao lưu toàn bộ** lần đầu tiên với `mysqldump`.
2. **Theo dõi và sao lưu các binary logs** trong suốt quá trình vận hành.
3. Khi cần khôi phục, **khôi phục từ bản sao lưu toàn bộ**, sau đó **áp dụng các binary logs** để cập nhật các thay đổi tiếp theo.

### Lưu ý:
- Việc lưu trữ binary logs cần được quản lý cẩn thận để tránh tốn quá nhiều dung lượng lưu trữ.
- Sử dụng `expire_logs_days` để tự động xóa các binary logs cũ sau một thời gian nhất định.
