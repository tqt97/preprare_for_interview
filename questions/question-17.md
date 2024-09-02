Phỏng vấn ứng viên chuyên gia backend web PHP yêu cầu kiểm tra kiến thức và kỹ năng về lập trình PHP, cấu trúc dữ liệu, xử lý dữ liệu, an toàn, và các kỹ thuật tối ưu hóa. Dưới đây là một số đoạn code mẹo và đánh đố mà bạn có thể sử dụng để đánh giá ứng viên:

### Đoạn code mẹo

1. **Singleton Pattern**
   ```php
   class Singleton {
       private static $instance;

       private function __construct() {}

       public static function getInstance() {
           if (!self::$instance) {
               self::$instance = new Singleton();
           }
           return self::$instance;
       }
   }

   $instance = Singleton::getInstance();
   ```

2. **Dependency Injection**
   ```php
   class Database {
       public function connect() {
           // Connect to database
       }
   }

   class User {
       private $db;

       public function __construct(Database $db) {
           $this->db = $db;
       }

       public function getUser($id) {
           $this->db->connect();
           // Fetch user
       }
   }

   $database = new Database();
   $user = new User($database);
   ```

3. **Error Handling**
   ```php
   function divide($a, $b) {
       if ($b == 0) {
           throw new Exception("Division by zero");
       }
       return $a / $b;
   }

   try {
       echo divide(10, 0);
   } catch (Exception $e) {
       echo 'Caught exception: ',  $e->getMessage(), "\n";
   }
   ```

### Đánh đố

1. **Bài toán FizzBuzz**
   ```php
   for ($i = 1; $i <= 100; $i++) {
       if ($i % 3 == 0 && $i % 5 == 0) {
           echo "FizzBuzz\n";
       } elseif ($i % 3 == 0) {
           echo "Fizz\n";
       } elseif ($i % 5 == 0) {
           echo "Buzz\n";
       } else {
           echo "$i\n";
       }
   }
   ```

2. **Reverse a String**
   ```php
   function reverseString($str) {
       return strrev($str);
   }

   echo reverseString("Hello World");
   ```

3. **Sorting an Array**
   ```php
   $arr = [3, 1, 4, 1, 5, 9, 2, 6, 5, 3, 5];
   sort($arr);
   print_r($arr);
   ```

4. **Sanitizing User Input**
   ```php
   function sanitizeInput($data) {
       return htmlspecialchars(strip_tags(trim($data)));
   }

   $input = "<script>alert('Hello')</script>";
   echo sanitizeInput($input);
   ```

5. **Database Connection (PDO)**
   ```php
   try {
       $dsn = 'mysql:host=localhost;dbname=testdb';
       $username = 'root';
       $password = '';
       $options = array(
           PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
           PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
       );
       $pdo = new PDO($dsn, $username, $password, $options);
       echo "Connected successfully";
   } catch (PDOException $e) {
       echo 'Connection failed: ' . $e->getMessage();
   }
   ```

### Đánh giá

- **Hiểu biết về các mẫu thiết kế (Design Patterns)**
- **Kiến thức về các nguyên tắc SOLID**
- **Kỹ năng xử lý lỗi và ngoại lệ**
- **Kiến thức về an toàn và làm sạch dữ liệu đầu vào**
- **Kiến thức về kết nối và tương tác với cơ sở dữ liệu**

Những đoạn code và đánh đố này sẽ giúp bạn đánh giá kỹ năng và kiến thức của ứng viên trong lĩnh vực backend web PHP.
