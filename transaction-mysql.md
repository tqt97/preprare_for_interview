### Cơ chế Transaction trong MySQL

**Transaction** (giao dịch) trong MySQL là một tập hợp các thao tác SQL được thực hiện như một đơn vị, đảm bảo tính toàn vẹn của dữ liệu. Một transaction có thể bao gồm nhiều câu lệnh như INSERT, UPDATE, DELETE, và được đảm bảo rằng tất cả các câu lệnh này hoặc được thực hiện hoàn toàn, hoặc không được thực hiện chút nào.

Transaction được sử dụng để xử lý các thao tác đồng thời và bảo vệ dữ liệu khỏi sự thay đổi không mong muốn. Để thực hiện điều này, transaction tuân theo 4 tính chất quan trọng gọi là **ACID**:

### 1. **ACID trong Transaction**

- **Atomicity (Tính nguyên tử)**: Một transaction phải được thực hiện hoàn toàn hoặc không thực hiện chút nào. Nếu một phần của transaction thất bại, tất cả các thay đổi trước đó đều phải được hoàn nguyên (rollback).
  
- **Consistency (Tính nhất quán)**: Sau khi transaction hoàn tất, dữ liệu phải nhất quán. Điều này có nghĩa là các ràng buộc và quy tắc của cơ sở dữ liệu vẫn được duy trì.

- **Isolation (Tính độc lập)**: Mỗi transaction được thực hiện một cách độc lập. Giao dịch đang thực hiện sẽ không bị ảnh hưởng bởi các giao dịch khác, ngay cả khi chúng xảy ra đồng thời.

- **Durability (Tính bền vững)**: Sau khi một transaction được commit, thay đổi phải được ghi vĩnh viễn vào cơ sở dữ liệu, ngay cả khi xảy ra sự cố hệ thống sau đó.

### 2. **Cách sử dụng Transaction trong MySQL**

Để sử dụng transaction trong MySQL, bạn thường làm theo các bước sau:

1. **Bắt đầu transaction**: Dùng lệnh `START TRANSACTION` hoặc `BEGIN`.
2. **Thực hiện các thao tác SQL**: Chèn, cập nhật, hoặc xóa dữ liệu.
3. **Commit transaction**: Dùng lệnh `COMMIT` để xác nhận và ghi các thay đổi vào cơ sở dữ liệu.
4. **Rollback transaction (nếu có lỗi)**: Nếu có lỗi xảy ra trong transaction, sử dụng lệnh `ROLLBACK` để khôi phục lại trạng thái ban đầu của cơ sở dữ liệu.

### 3. **Ví dụ Transaction trong MySQL**

Giả sử bạn có hai tài khoản ngân hàng và bạn muốn chuyển tiền từ tài khoản A sang tài khoản B. Quá trình này cần phải thực hiện như một transaction để đảm bảo rằng số tiền chỉ được chuyển khi cả hai thao tác thành công (trừ tiền từ A và cộng tiền vào B).

#### Tạo bảng cho ví dụ:

```sql
CREATE TABLE accounts (
    account_id INT PRIMARY KEY,
    balance DECIMAL(10, 2)
);

INSERT INTO accounts (account_id, balance) VALUES (1, 1000.00), (2, 500.00);
```

#### Thực hiện transaction:

```sql
-- Bắt đầu transaction
START TRANSACTION;

-- Trừ tiền từ tài khoản A
UPDATE accounts SET balance = balance - 200 WHERE account_id = 1;

-- Cộng tiền vào tài khoản B
UPDATE accounts SET balance = balance + 200 WHERE account_id = 2;

-- Kiểm tra nếu số dư tài khoản A không bị âm
SELECT balance FROM accounts WHERE account_id = 1;

-- Nếu số dư hợp lệ, commit transaction
COMMIT;
```

Nếu trong quá trình thực hiện, hệ thống phát hiện ra lỗi (ví dụ như số dư của tài khoản A không đủ), bạn có thể thực hiện `ROLLBACK` để quay trở lại trạng thái trước khi transaction bắt đầu.

```sql
-- Nếu có lỗi, rollback transaction
ROLLBACK;
```

### 4. **Isolation Levels (Mức độ cách ly của Transaction)**

MySQL hỗ trợ nhiều mức độ cách ly khác nhau, quyết định cách các transaction ảnh hưởng đến nhau khi chạy đồng thời. Có 4 mức cách ly chính:

1. **Read Uncommitted**: Một transaction có thể đọc dữ liệu chưa được commit từ transaction khác, gây ra hiện tượng "dirty read". Đây là mức cách ly thấp nhất.
2. **Read Committed**: Một transaction chỉ có thể đọc dữ liệu đã được commit bởi transaction khác. Tuy nhiên, dữ liệu có thể thay đổi trong suốt quá trình transaction (hiện tượng "non-repeatable read").
3. **Repeatable Read**: Transaction sẽ nhìn thấy cùng một dữ liệu trong suốt quá trình thực hiện, ngay cả khi có transaction khác thay đổi dữ liệu (đây là mức cách ly mặc định của MySQL).
4. **Serializable**: Mức cách ly cao nhất, đảm bảo rằng các transaction được thực hiện tuần tự. Điều này đảm bảo tính toàn vẹn cao nhất nhưng cũng có thể gây giảm hiệu suất.

#### Thiết lập mức độ cách ly:

```sql
-- Đặt mức độ cách ly
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;
```

### 5. **Sử dụng Transaction trong PHP với MySQLi hoặc PDO**

**MySQLi**:

```php
$mysqli = new mysqli("localhost", "user", "password", "database");

$mysqli->begin_transaction();

try {
    $mysqli->query("UPDATE accounts SET balance = balance - 200 WHERE account_id = 1");
    $mysqli->query("UPDATE accounts SET balance = balance + 200 WHERE account_id = 2");
    $mysqli->commit(); // Xác nhận transaction
} catch (Exception $e) {
    $mysqli->rollback(); // Khôi phục lại nếu có lỗi
    throw $e;
}
```

**PDO**:

```php
$pdo = new PDO("mysql:host=localhost;dbname=database", "user", "password");

$pdo->beginTransaction();

try {
    $pdo->exec("UPDATE accounts SET balance = balance - 200 WHERE account_id = 1");
    $pdo->exec("UPDATE accounts SET balance = balance + 200 WHERE account_id = 2");
    $pdo->commit(); // Xác nhận transaction
} catch (Exception $e) {
    $pdo->rollback(); // Khôi phục lại nếu có lỗi
    throw $e;
}
```

### 6. **Lợi ích của Transaction**

- **Tính toàn vẹn của dữ liệu**: Các thao tác được thực hiện hoàn toàn hoặc không thực hiện chút nào, đảm bảo dữ liệu không bị lỗi hoặc không nhất quán.
- **Xử lý lỗi dễ dàng**: Trong trường hợp có lỗi, bạn có thể khôi phục cơ sở dữ liệu về trạng thái trước khi thực hiện transaction.
- **Đồng thời an toàn**: Các transaction đồng thời có thể chạy mà không ảnh hưởng đến dữ liệu của nhau nhờ cơ chế cách ly.

### 7. **Kết luận**

Transaction là một công cụ mạnh mẽ trong MySQL để đảm bảo tính nhất quán và an toàn cho dữ liệu. Nó giúp bảo vệ dữ liệu trong các trường hợp có nhiều thao tác liên tiếp, đặc biệt quan trọng khi thao tác với các hệ thống quan trọng như tài chính, giao dịch ngân hàng.
