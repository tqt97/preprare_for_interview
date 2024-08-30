# Object-Oriented Programming (OOP)

>Object-Oriented Programming (OOP) là một mô hình lập trình dựa trên khái niệm "đối tượng" (object). Mỗi đối tượng là một thực thể trong thế giới thực và có thể có các thuộc tính (attributes) và hành vi (behaviors). OOP giúp lập trình viên mô phỏng các khái niệm trong thế giới thực vào trong chương trình của họ, làm cho mã nguồn dễ hiểu và dễ bảo trì hơn.Object-Oriented Programming (OOP)

### 1. Khái niệm cơ bản
#### 1.1 Class (Lớp)
Class là một bản thiết kế hoặc mẫu cho các đối tượng. Nó định nghĩa các thuộc tính (properties) và phương thức (methods) mà các đối tượng thuộc lớp đó sẽ có.
Ví dụ, bạn có thể tạo một lớp Car để mô phỏng các thuộc tính và hành vi của một chiếc xe.
```php
class Car {
    public $color;
    public $brand;

    public function drive() {
        echo "Driving...";
    }
}
```
#### 1.2 Object (Đối tượng)
Object là một thể hiện cụ thể của một lớp. Khi bạn tạo một đối tượng từ lớp, bạn đang tạo ra một phiên bản cụ thể của lớp đó với các giá trị cụ thể cho các thuộc tính.
Ví dụ, bạn có thể tạo một đối tượng Car có màu đỏ và thuộc hiệu Toyota.

```php
$myCar = new Car();
$myCar->color = "Red";
$myCar->brand = "Toyota";
$myCar->drive(); // Output: Driving...
```

#### 1.3 Encapsulation (Đóng gói)
Encapsulation là quá trình đóng gói dữ liệu và các phương thức xử lý dữ liệu đó trong một đối tượng. Điều này giúp bảo vệ dữ liệu khỏi bị truy cập hoặc sửa đổi từ bên ngoài.
Bạn có thể ẩn các thuộc tính của một đối tượng bằng cách sử dụng các từ khóa như private hoặc protected, và cung cấp các phương thức getter và setter để truy cập hoặc sửa đổi dữ liệu.

```php
class Car {
    private $color;
    private $brand;

    public function getColor() {
        return $this->color;
    }

    public function setColor($color) {
        $this->color = $color;
    }
}
```
#### 1.4 Inheritance (Kế thừa)
Inheritance cho phép một lớp mới (subclass) kế thừa các thuộc tính và phương thức của một lớp hiện có (superclass). Điều này giúp tái sử dụng mã nguồn và tạo ra các lớp chuyên biệt hơn.
Ví dụ, bạn có thể tạo lớp ElectricCar kế thừa từ lớp Car và thêm thuộc tính batteryCapacity.

```php
class ElectricCar extends Car {
    public $batteryCapacity;

    public function charge() {
        echo "Charging...";
    }
}
```

#### 1.5 Polymorphism (Đa hình)
Polymorphism cho phép các đối tượng từ các lớp khác nhau có thể được xử lý thông qua cùng một giao diện (interface). Điều này có nghĩa là một phương thức có thể có các hành vi khác nhau tùy thuộc vào lớp mà nó đang hoạt động.
Ví dụ, phương thức drive có thể hoạt động khác nhau đối với Car và ElectricCar.

```php
class Car {
    public function drive() {
        echo "Driving a car...";
    }
}

class ElectricCar extends Car {
    public function drive() {
        echo "Driving an electric car...";
    }
}

$car = new Car();
$car->drive(); // Output: Driving a car...

$electricCar = new ElectricCar();
$electricCar->drive(); // Output: Driving an electric car...
```

### 2. Lợi ích của OOP
- Dễ bảo trì và mở rộng: Bằng cách đóng gói các thuộc tính và hành vi trong các lớp, bạn có thể dễ dàng bảo trì và mở rộng mã nguồn mà không ảnh hưởng đến các phần khác của chương trình.

- Tái sử dụng mã nguồn: Kế thừa cho phép bạn tái sử dụng mã nguồn hiện có và thêm chức năng mới mà không phải viết lại từ đầu.

- Lập trình hướng đối tượng phản ánh thế giới thực: Điều này giúp lập trình viên mô hình hóa các khái niệm phức tạp của thế giới thực một cách trực quan hơn.

- Dễ hiểu hơn: Vì mã nguồn được tổ chức theo các đối tượng giống như trong thực tế, nên dễ hiểu hơn đối với người khác đọc hoặc duy trì mã.
### 3. Ví dụ minh họa
Hãy xem một ví dụ đơn giản về hệ thống quản lý sinh viên. Bạn có thể có một lớp Person mô tả các thuộc tính chung như tên và tuổi. Sau đó, bạn có thể có lớp Student và Teacher kế thừa từ lớp Person, với các thuộc tính và phương thức riêng biệt.
```php
class Person {
    protected $name;
    protected $age;

    public function __construct($name, $age) {
        $this->name = $name;
        $this->age = $age;
    }

    public function introduce() {
        echo "Hi, I'm $this->name and I'm $this->age years old.";
    }
}

class Student extends Person {
    private $studentID;

    public function __construct($name, $age, $studentID) {
        parent::__construct($name, $age);
        $this->studentID = $studentID;
    }

    public function introduce() {
        parent::introduce();
        echo " I'm a student with ID $this->studentID.";
    }
}

class Teacher extends Person {
    private $subject;

    public function __construct($name, $age, $subject) {
        parent::__construct($name, $age);
        $this->subject = $subject;
    }

    public function introduce() {
        parent::introduce();
        echo " I teach $this->subject.";
    }
}

$student = new Student("John", 20, "S12345");
$student->introduce(); // Output: Hi, I'm John and I'm 20 years old. I'm a student with ID S12345.

$teacher = new Teacher("Alice", 35, "Math");
$teacher->introduce(); // Output: Hi, I'm Alice and I'm 35 years old. I teach Math.
```

Trong ví dụ này, Student và Teacher đều kế thừa từ Person, nhưng mỗi lớp lại có thêm các thuộc tính và hành vi riêng biệt. Điều này cho thấy sức mạnh của OOP trong việc tổ chức mã nguồn và xử lý các đối tượng phức tạp.