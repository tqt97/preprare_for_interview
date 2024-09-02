Dưới đây là một số đoạn code mẹo và đánh đố để phỏng vấn ứng viên chuyên gia backend web PHP:

**Đoạn code mẹo 1: Kiểm tra kiến thức về biến và kiểu dữ liệu**

```php
$a = '5';
$b = 5;
if ($a == $b) {
 echo "Đúng";
} else {
 echo "Sai";
}
```

Câu hỏi: Đoạn code trên sẽ in ra kết quả gì? Tại sao?

**Đáp án:** Đoạn code trên sẽ in ra kết quả "Đúng" vì trong PHP, khi so sánh một chuỗi với một số nguyên, chuỗi sẽ được chuyển đổi thành số nguyên và so sánh.

**Đoạn code mẹo 2: Kiểm tra kiến thức về mảng và vòng lặp**

```php
$array = array(1, 2, 3, 4, 5);
foreach ($array as &$value) {
 $value *= 2;
}
print_r($array);
```

Câu hỏi: Đoạn code trên sẽ in ra kết quả gì? Tại sao?

**Đáp án:** Đoạn code trên sẽ in ra kết quả `Array ( [0] => 2 [1] => 4 [2] => 6 [3] => 8 [4] => 10 )` vì trong PHP, khi sử dụng tham chiếu `&` trong vòng lặp `foreach`, giá trị của biến sẽ được thay đổi trực tiếp trong mảng.

**Đoạn code mẹo 3: Kiểm tra kiến thức về hàm và phạm vi biến**

```php
function test() {
 $a = 5;
 function inner() {
 echo $a;
 }
 inner();
}
test();
```

Câu hỏi: Đoạn code trên sẽ in ra kết quả gì? Tại sao?

**Đáp án:** Đoạn code trên sẽ không in ra kết quả gì vì biến `$a` không được định nghĩa trong phạm vi của hàm `inner()`. Để sửa lỗi này, cần sử dụng từ khóa `use` để truyền biến `$a` vào hàm `inner()`.

**Đoạn code mẹo 4: Kiểm tra kiến thức về cơ sở dữ liệu**

```php
$conn = mysqli_connect("localhost", "username", "password", "database");
if (!$conn) {
 die("Kết nối thất bại: " . mysqli_connect_error());
}
$sql = "SELECT * FROM users WHERE id = '1' OR '1' = '1'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
 while($row = mysqli_fetch_assoc($result)) {
 echo $row["username"];
 }
}
```

Câu hỏi: Đoạn code trên có an toàn không? Tại sao?

**Đáp án:** Đoạn code trên không an toàn vì nó dễ bị tấn công SQL Injection. Để sửa lỗi này, cần sử dụng prepared statement hoặc tham số hóa truy vấn.

**Đoạn code mẹo 5: Kiểm tra kiến thức về thiết kế mẫu**

```php
class Singleton {
 private static $instance;
 private function __construct() {}
 public static function getInstance() {
 if (!self::$instance) {
 self::$instance = new self();
 }
 return self::$instance;
 }
}
```

Câu hỏi: Đoạn code trên là một ví dụ về thiết kế mẫu gì? Tại sao?

**Đáp án:** Đoạn code trên là một ví dụ về thiết kế mẫu Singleton. Singleton là một thiết kế mẫu creational cho phép chỉ tạo một thể hiện của một lớp và cung cấp một điểm truy cập toàn cục đến thể hiện đó.
