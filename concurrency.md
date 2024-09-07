### Xử lý Concurrency (Đồng thời) trong PHP và MySQL

**Concurrency** (đồng thời) trong các hệ thống cơ sở dữ liệu liên quan đến việc xử lý nhiều giao dịch hoặc yêu cầu từ nhiều người dùng khác nhau trong cùng một thời điểm. Trong MySQL, khi nhiều transaction hoặc query cùng truy cập vào dữ liệu đồng thời, các vấn đề như **dirty read**, **non-repeatable read**, và **phantom read** có thể xảy ra. Để xử lý những vấn đề này, chúng ta cần hiểu và áp dụng các cơ chế concurrency control hiệu quả.

### 1. **Vấn đề thường gặp khi xử lý đồng thời**

- **Dirty Read**: Một transaction đọc dữ liệu chưa được commit từ transaction khác.
- **Non-repeatable Read**: Một transaction đọc dữ liệu tại thời điểm khác nhau trong cùng một transaction và nhận được các giá trị khác nhau.
- **Phantom Read**: Khi một transaction thấy các bản ghi đã được chèn/xóa bởi một transaction khác trong khi đang thực hiện.

### 2. **Isolation Levels (Mức độ cách ly)**

MySQL hỗ trợ 4 mức độ cách ly cho các transaction, giúp xử lý các vấn đề đồng thời:
1. **Read Uncommitted**: Cho phép đọc dữ liệu chưa được commit, dễ gặp lỗi **dirty read**.
2. **Read Committed**: Chỉ cho phép đọc dữ liệu đã được commit, tránh lỗi **dirty read**, nhưng có thể gặp **non-repeatable read**.
3. **Repeatable Read** (mặc định): Tránh được **non-repeatable read**, nhưng có thể gặp **phantom read**.
4. **Serializable**: Mức độ cách ly cao nhất, tránh tất cả các vấn đề trên nhưng có thể gây giảm hiệu suất.

Bạn có thể cấu hình mức cách ly này trong MySQL với lệnh:

```sql
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;
```

### 3. **Cơ chế Lock (Khóa) trong MySQL**

MySQL hỗ trợ các loại khóa để đảm bảo tính toàn vẹn dữ liệu khi có nhiều transaction thực hiện đồng thời:

- **Table Lock**: Khóa toàn bộ bảng.
  - `LOCK TABLES table_name WRITE;` — Khóa bảng để ghi (các transaction khác không thể đọc hoặc ghi).
  - `LOCK TABLES table_name READ;` — Khóa bảng để đọc (các transaction khác chỉ có thể đọc).
  
- **Row Lock**: Khóa từng dòng cụ thể (thường sử dụng trong InnoDB).
  - `SELECT ... FOR UPDATE;` — Khóa các dòng được truy vấn để ngăn các transaction khác sửa đổi cho đến khi transaction hiện tại hoàn tất.
  
Ví dụ:

```sql
START TRANSACTION;
SELECT balance FROM accounts WHERE account_id = 1 FOR UPDATE;
-- Thực hiện các thao tác khác
COMMIT;
```

Lệnh `FOR UPDATE` đảm bảo rằng các dòng được đọc sẽ bị khóa cho đến khi transaction hoàn tất, tránh các thay đổi không mong muốn từ các transaction khác.

### 4. **Cơ chế xử lý đồng thời trong PHP**

Khi làm việc với PHP và MySQL, việc xử lý đồng thời thường liên quan đến các vấn đề như **cập nhật trạng thái**, **thực hiện các giao dịch ngân hàng**, hoặc **quản lý lượng truy cập lớn**. Để đảm bảo an toàn và nhất quán trong quá trình xử lý đồng thời, bạn có thể áp dụng các kỹ thuật sau.

#### Sử dụng Transaction trong PHP

**PDO với Transaction**:

```php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=test', 'user', 'password');
    $pdo->beginTransaction();

    // Thực hiện câu lệnh SQL với khóa dòng
    $stmt = $pdo->prepare("SELECT balance FROM accounts WHERE account_id = :id FOR UPDATE");
    $stmt->execute(['id' => 1]);

    // Các thao tác tiếp theo
    $stmt = $pdo->prepare("UPDATE accounts SET balance = balance - 100 WHERE account_id = :id");
    $stmt->execute(['id' => 1]);

    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack(); // Nếu có lỗi, rollback transaction
    throw $e;
}
```

**MySQLi với Transaction**:

```php
$mysqli = new mysqli("localhost", "user", "password", "test");

$mysqli->begin_transaction();

try {
    // Khóa dòng bằng SELECT FOR UPDATE
    $result = $mysqli->query("SELECT balance FROM accounts WHERE account_id = 1 FOR UPDATE");

    // Thực hiện các thao tác khác
    $mysqli->query("UPDATE accounts SET balance = balance - 100 WHERE account_id = 1");

    $mysqli->commit(); // Commit transaction
} catch (Exception $e) {
    $mysqli->rollback(); // Nếu có lỗi, rollback transaction
    throw $e;
}
```

### 5. **Optimistic Locking (Khóa lạc quan)**

Optimistic locking là phương pháp kiểm tra dữ liệu trước khi cập nhật để đảm bảo rằng dữ liệu chưa bị thay đổi bởi một transaction khác. Điều này thường được thực hiện bằng cách sử dụng một **cột version** trong bảng để theo dõi các thay đổi.

Ví dụ, thêm một cột `version` vào bảng `accounts`:

```sql
ALTER TABLE accounts ADD COLUMN version INT DEFAULT 1;
```

Khi cập nhật dữ liệu, bạn kiểm tra phiên bản trước khi thực hiện:

```php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=test', 'user', 'password');
    $pdo->beginTransaction();

    // Lấy version và kiểm tra
    $stmt = $pdo->prepare("SELECT balance, version FROM accounts WHERE account_id = :id");
    $stmt->execute(['id' => 1]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row['version'] != $expected_version) {
        throw new Exception('Data has been modified by another transaction.');
    }

    // Cập nhật nếu version khớp
    $stmt = $pdo->prepare("UPDATE accounts SET balance = balance - 100, version = version + 1 WHERE account_id = :id AND version = :version");
    $stmt->execute(['id' => 1, 'version' => $row['version']]);

    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    throw $e;
}
```

### 6. **Deadlock và Cách Xử Lý**

**Deadlock** xảy ra khi hai transaction cùng khóa các tài nguyên mà transaction kia cần và cả hai đều chờ đợi lẫn nhau. Khi gặp deadlock, MySQL sẽ chọn một transaction để rollback. 

Để giảm nguy cơ deadlock, bạn có thể:
- **Giảm thời gian giữ khóa**: Chỉ giữ khóa khi cần thiết và commit sớm.
- **Thực hiện thao tác theo cùng thứ tự**: Đảm bảo các transaction thực hiện thao tác trên các bảng và dòng theo cùng một thứ tự.
- **Bắt lỗi deadlock**: Khi gặp deadlock, bạn cần retry transaction.

Ví dụ, bắt lỗi deadlock trong PHP:

```php
try {
    $pdo->beginTransaction();
    
    // Thực hiện các thao tác
    $pdo->commit();
} catch (PDOException $e) {
    if ($e->getCode() == '40001') { // Deadlock error code
        // Retry transaction
    } else {
        throw $e;
    }
}
```

### 7. **Kết luận**

Xử lý đồng thời trong PHP và MySQL là một khía cạnh phức tạp, đòi hỏi bạn phải sử dụng các cơ chế như **Transaction**, **Locking** (khóa), và **Isolation Levels** một cách hiệu quả. Các kỹ thuật như **Optimistic Locking** và **Deadlock Handling** giúp đảm bảo tính toàn vẹn của dữ liệu trong môi trường nhiều transaction đồng thời.
