# Data structures and algorithms

Dưới đây là một số bài toán đánh đố, mẹo, khó, và nâng cao thường được sử dụng để phỏng vấn các chuyên gia lập trình web PHP:

### 1. **Kiểm tra chuỗi đối xứng (Palindrome)**
**Đề bài:** Viết một hàm trong PHP để kiểm tra xem một chuỗi có phải là chuỗi đối xứng (palindrome) hay không. Chuỗi đối xứng là chuỗi mà khi đảo ngược vẫn giống như ban đầu.

**Yêu cầu:** Hàm phải có khả năng bỏ qua các ký tự không phải chữ cái và không phân biệt chữ hoa chữ thường.

**Ví dụ:**

```php
function isPalindrome($string) {
    $string = preg_replace('/[^a-z0-9]/i', '', $string);
    $string = strtolower($string);
    return $string === strrev($string);
}

var_dump(isPalindrome("A man, a plan, a canal, Panama")); // Output: bool(true)
```

### 2. **Đếm số lần xuất hiện của ký tự**
**Đề bài:** Viết một hàm trong PHP để đếm số lần xuất hiện của từng ký tự trong một chuỗi.

**Yêu cầu:** Trả về một mảng trong đó key là ký tự và value là số lần xuất hiện của ký tự đó.

**Ví dụ:**

```php
function countCharacterFrequency($string) {
    $frequency = [];
    foreach (str_split($string) as $char) {
        if (isset($frequency[$char])) {
            $frequency[$char]++;
        } else {
            $frequency[$char] = 1;
        }
    }
    return $frequency;
}

print_r(countCharacterFrequency("hello world"));
// Output: Array ( [h] => 1 [e] => 1 [l] => 3 [o] => 2 [ ] => 1 [w] => 1 [r] => 1 [d] => 1 )
```

### 3. **Xử lý số nguyên lớn**
**Đề bài:** Viết một hàm trong PHP để cộng hai số nguyên lớn (big integers) được biểu diễn dưới dạng chuỗi.

**Yêu cầu:** Không sử dụng bất kỳ thư viện nào hỗ trợ số nguyên lớn, chỉ sử dụng các thao tác chuỗi cơ bản.

**Ví dụ:**

```php
function addBigIntegers($num1, $num2) {
    $result = '';
    $carry = 0;
    $num1 = strrev($num1);
    $num2 = strrev($num2);

    $length = max(strlen($num1), strlen($num2));

    for ($i = 0; $i < $length; $i++) {
        $digit1 = $i < strlen($num1) ? $num1[$i] : 0;
        $digit2 = $i < strlen($num2) ? $num2[$i] : 0;

        $sum = $digit1 + $digit2 + $carry;
        $carry = floor($sum / 10);
        $result .= $sum % 10;
    }

    if ($carry > 0) {
        $result .= $carry;
    }

    return strrev($result);
}

echo addBigIntegers('12345678901234567890', '98765432109876543210');
// Output: 111111111011111111100
```

### 4. **Tìm số nguyên tố trong một phạm vi**
**Đề bài:** Viết một hàm trong PHP để tìm tất cả các số nguyên tố trong một phạm vi cho trước.

**Yêu cầu:** Tối ưu hóa để chạy nhanh với phạm vi lớn.

**Ví dụ:**

```php
function isPrime($num) {
    if ($num <= 1) return false;
    if ($num == 2) return true;
    if ($num % 2 == 0) return false;

    for ($i = 3; $i <= sqrt($num); $i += 2) {
        if ($num % $i == 0) return false;
    }

    return true;
}

function findPrimesInRange($start, $end) {
    $primes = [];
    for ($i = $start; $i <= $end; $i++) {
        if (isPrime($i)) {
            $primes[] = $i;
        }
    }
    return $primes;
}

print_r(findPrimesInRange(10, 50));
// Output: Array ( [0] => 11 [1] => 13 [2] => 17 [3] => 19 [4] => 23 [5] => 29 [6] => 31 [7] => 37 [8] => 41 [9] => 43 [10] => 47 )
```

### 5. **Xử lý chuỗi phức tạp**
**Đề bài:** Viết một hàm trong PHP để loại bỏ các ký tự trùng lặp liên tiếp trong một chuỗi và chỉ giữ lại một ký tự duy nhất.

**Ví dụ:**

```php
function removeDuplicates($string) {
    return preg_replace('/(.)\\1+/', '$1', $string);
}

echo removeDuplicates("aaabbcdddd");
// Output: abcd
```

### 6. **Kiểm tra tính hợp lệ của biểu thức**
**Đề bài:** Viết một hàm trong PHP để kiểm tra tính hợp lệ của một biểu thức toán học có dấu ngoặc đơn, dấu ngoặc vuông và dấu ngoặc nhọn.

**Yêu cầu:** Hàm phải kiểm tra xem các dấu ngoặc được đóng mở đúng thứ tự hay không.

**Ví dụ:**

```php
function isValidExpression($expression) {
    $stack = [];
    $pairs = [
        ')' => '(',
        ']' => '[',
        '}' => '{'
    ];

    foreach (str_split($expression) as $char) {
        if (in_array($char, $pairs)) {
            array_push($stack, $char);
        } elseif (array_key_exists($char, $pairs)) {
            if (array_pop($stack) !== $pairs[$char]) {
                return false;
            }
        }
    }

    return empty($stack);
}

var_dump(isValidExpression("({[()]})")); // Output: bool(true)
var_dump(isValidExpression("({[()]}"));  // Output: bool(false)
```

### 7. **Tìm số con lớn nhất trong mảng**
**Đề bài:** Viết một hàm trong PHP để tìm chuỗi con liên tiếp có tổng lớn nhất trong một mảng số nguyên.

**Yêu cầu:** Tối ưu hóa thuật toán để có độ phức tạp thời gian là O(n).

**Ví dụ:**

```php
function maxSubArraySum($arr) {
    $maxSoFar = $arr[0];
    $currentMax = $arr[0];

    for ($i = 1; $i < count($arr); $i++) {
        $currentMax = max($arr[$i], $currentMax + $arr[$i]);
        $maxSoFar = max($maxSoFar, $currentMax);
    }

    return $maxSoFar;
}

echo maxSubArraySum([-2, 1, -3, 4, -1, 2, 1, -5, 4]);
// Output: 6 (Chuỗi con là [4, -1, 2, 1])
```

### 8. **Xây dựng biểu đồ cây thư mục**
**Đề bài:** Viết một hàm trong PHP để xây dựng một cấu trúc cây thư mục từ một mảng danh sách thư mục và tệp.

**Yêu cầu:** Hàm phải sắp xếp các mục theo đúng cấu trúc thư mục, bao gồm các tệp và thư mục con.

**Ví dụ:**

```php
function buildTree(array $elements, $parentId = 0) {
    $branch = [];

    foreach ($elements as $element) {
        if ($element['parent_id'] == $parentId) {
            $children = buildTree($elements, $element['id']);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
    }

    return $branch;
}

$elements = [
    ['id' => 1, 'name' => 'Root', 'parent_id' => 0],
    ['id' => 2, 'name' => 'Folder A', 'parent_id' => 1],
    ['id' => 3, 'name' => 'Folder B', 'parent_id' => 1],
    ['id' => 4, 'name' => 'File 1', 'parent_id' => 2],
    ['id' => 5, 'name' => 'File 2', 'parent_id' => 3],
];

$tree = buildTree($elements);
print_r($tree);
```

**Giải thích:** Bài toán này kiểm tra khả năng xử lý và xây dựng cấu trúc dữ liệu phức tạp từ dữ liệu phi cấu trúc.

