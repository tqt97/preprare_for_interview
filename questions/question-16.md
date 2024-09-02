Dưới đây là một số đoạn code mẹo và đánh đố để phỏng vấn ứng viên chuyên gia backend web PHP:

**Đoạn code mẹo 1: Tìm lỗi trong đoạn code sau**

```php
function tinhTong($a, $b) {
 $tong = $a + $b;
 return $tong;
}

$a = '10';
$b = 20;
echo tinhTong($a, $b);
```

Câu hỏi: Đoạn code trên có lỗi gì? Và làm thế nào để sửa lỗi đó?

**Đáp án:** Đoạn code trên có lỗi là biến `$a` được khai báo là chuỗi, nhưng trong hàm `tinhTong`, biến `$a` được sử dụng như một số nguyên. Để sửa lỗi này, ta cần chuyển đổi biến `$a` sang số nguyên trước khi thực hiện phép tính.

**Đoạn code mẹo 2: Tối ưu hóa đoạn code sau**

```php
$array = array(1, 2, 3, 4, 5);
$result = array();
foreach ($array as $value) {
 if ($value % 2 == 0) {
 $result[] = $value;
 }
}
echo json_encode($result);
```

Câu hỏi: Đoạn code trên có thể được tối ưu hóa như thế nào?

**Đáp án:** Đoạn code trên có thể được tối ưu hóa bằng cách sử dụng hàm `array_filter` để lọc các phần tử trong mảng.

```php
$array = array(1, 2, 3, 4, 5);
$result = array_filter($array, function($value) {
 return $value % 2 == 0;
});
echo json_encode($result);
```

**Đoạn code mẹo 3: Xử lý lỗi trong đoạn code sau**

```php
function readFile($filename) {
 $content = file_get_contents($filename);
 return $content;
}

$filename = 'file.txt';
echo readFile($filename);
```

Câu hỏi: Đoạn code trên có lỗi gì? Và làm thế nào để xử lý lỗi đó?

**Đáp án:** Đoạn code trên có lỗi là không kiểm tra xem file có tồn tại hay không trước khi đọc nội dung. Để xử lý lỗi này, ta cần kiểm tra xem file có tồn tại hay không trước khi đọc nội dung.

```php
function readFile($filename) {
 if (!file_exists($filename)) {
 throw new Exception("File không tồn tại");
 }
 $content = file_get_contents($filename);
 return $content;
}

$filename = 'file.txt';
try {
 echo readFile($filename);
} catch (Exception $e) {
 echo $e->getMessage();
}
```

**Đoạn code đánh đố 1: Tìm giá trị của biến `$x`**

```php
$x = 5;
$y = &$x;
$y = 10;
echo $x;
```

Câu hỏi: Giá trị của biến `$x` là gì?

**Đáp án:** Giá trị của biến `$x` là 10, vì biến `$y` là tham chiếu đến biến `$x`, nên khi gán giá trị mới cho biến `$y`, giá trị của biến `$x` cũng thay đổi.

**Đoạn code đánh đố 2: Tìm kết quả của đoạn code sau**

```php
$a = array(1, 2, 3);
$b = array(4, 5, 6);
$c = array_merge($a, $b);
echo json_encode($c);
```

Câu hỏi: Kết quả của đoạn code trên là gì?

**Đáp án:** Kết quả của đoạn code trên là `[1, 2, 3, 4, 5, 6]`, vì hàm `array_merge` sẽ hợp nhất hai mảng vào một mảng mới.

**Đoạn code đánh đố 3: Tìm giá trị của biến `$z`**

```php
$x = 5;
$y = 10;
$z = $x + $y;
$z = $z * 2;
echo $z;
```

Câu hỏi: Giá trị của biến `$z` là gì?

**Đáp án:** Giá trị của biến `$z` là 30, vì biến `$z` được gán giá trị bằng phép tính `$x + $y`, sau đó được nhân đôi.
