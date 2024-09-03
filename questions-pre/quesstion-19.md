Để phỏng vấn ứng viên chuyên gia backend web PHP, bạn có thể sử dụng các đoạn code mẹo và đánh đố sau để đánh giá kỹ năng và kiến thức của họ. Dưới đây là một số ví dụ:

### Đoạn code mẹo

#### 1. Tối ưu hóa mã vòng lặp

```php
// Đoạn code ban đầu
for ($i = 0; $i < count($array); $i++) {
    echo $array[$i];
}

// Đoạn code tối ưu
$count = count($array);
for ($i = 0; $i < $count; $i++) {
    echo $array[$i];
}
```

**Lý do:** Việc tính toán `count($array)` trong mỗi lần lặp sẽ tốn thời gian. Lưu kết quả của `count($array)` trong một biến sẽ tăng tốc độ vòng lặp.

#### 2. Sử dụng `foreach` thay vì `for`

```php
// Đoạn code ban đầu
for ($i = 0; $i < count($array); $i++) {
    echo $array[$i];
}

// Đoạn code tối ưu
foreach ($array as $item) {
    echo $item;
}
```

**Lý do:** `foreach` thường dễ đọc hơn và thực thi nhanh hơn so với `for` trong một số trường hợp.

### Đánh đố

#### 1. Xử lý lỗi và ngoại lệ

```php
try {
    // Mã có thể gây ra lỗi
    $result = 10 / 0;
} catch (DivisionByZeroError $e) {
    echo "Caught DivisionByZeroError: " . $e->getMessage();
} catch (Exception $e) {
    echo "Caught Exception: " . $e->getMessage();
}
```

**Câu hỏi:** Hãy giải thích cách PHP xử lý lỗi và ngoại lệ trong đoạn code trên.

#### 2. Sử dụng PDO để truy vấn cơ sở dữ liệu

```php
<?php
$dsn = 'mysql:host=localhost;dbname=testdb';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id');
    $stmt->execute(['id' => 1]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    print_r($user);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
```

**Câu hỏi:** Hãy giải thích cách sử dụng PDO để truy vấn cơ sở dữ liệu và tại sao nên sử dụng PDO thay vì các phương pháp khác như `mysql_query`.

#### 3. Sử dụng Composer để quản lý thư viện

```php
{
    "require": {
        "monolog/monolog": "^2.0"
    }
}
```

**Câu hỏi:** Hãy giải thích cách sử dụng Composer để quản lý thư viện trong dự án PHP.

#### 4. Sử dụng Sessions và Cookies

```php
// Khởi tạo session
session_start();

// Lưu giá trị vào session
$_SESSION['username'] = 'john_doe';

// Lấy giá trị từ session
echo 'Username: ' . $_SESSION['username'];

// Đặt cookie
setcookie('username', 'john_doe', time() + (86400 * 30), "/");

// Lấy giá trị từ cookie
echo 'Username: ' . $_COOKIE['username'];
```

**Câu hỏi:** Hãy giải thích sự khác biệt giữa Sessions và Cookies và khi nào nên sử dụng chúng.

### Câu hỏi phỏng vấn

1. **Câu hỏi về OOP:**
   - Hãy giải thích các nguyên tắc OOP (Object-Oriented Programming) trong PHP.
   - Viết một lớp PHP có các thuộc tính và phương thức, bao gồm cả constructor và destructor.

2. **Câu hỏi về RESTful API:**
   - Hãy giải thích cách xây dựng một RESTful API bằng PHP.
   - Viết một đoạn code PHP để xử lý yêu cầu GET và trả về dữ liệu dưới dạng JSON.

3. **Câu hỏi về bảo mật:**
   - Hãy giải thích cách bảo vệ ứng dụng PHP khỏi các cuộc tấn công SQL Injection và XSS (Cross-Site Scripting).
   - Viết một đoạn code PHP để mã hóa mật khẩu sử dụng bcrypt.

Bằng cách sử dụng các đoạn code mẹo và đánh đố trên, bạn có thể đánh giá kỹ năng và kiến thức của ứng viên chuyên gia backend web PHP một cách hiệu quả.
