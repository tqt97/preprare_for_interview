Eloquent và Query Builder đều là các công cụ mạnh mẽ trong Laravel để tương tác với cơ sở dữ liệu, nhưng chúng có những đặc điểm khác nhau về hiệu năng, cách sử dụng, và tính linh hoạt. Dưới đây là sự so sánh giữa Eloquent và Query Builder cùng với các ví dụ về cách sử dụng của từng công cụ.

### 1. **Tổng quan**
- **Eloquent** là ORM (Object-Relational Mapping) trong Laravel, nó đại diện cho mỗi bảng trong cơ sở dữ liệu dưới dạng một mô hình (model) và làm việc với các đối tượng PHP. Eloquent rất phù hợp cho các thao tác với dữ liệu liên quan đến đối tượng, hỗ trợ các quan hệ giữa các bảng như One-to-One, One-to-Many, Many-to-Many.
  
- **Query Builder** là một API cung cấp cách thức truy vấn cơ sở dữ liệu sử dụng các phương thức PHP mà không cần viết SQL trực tiếp. Nó linh hoạt, hiệu quả và không phụ thuộc vào mô hình ORM.

### 2. **So sánh chi tiết**

| **Đặc điểm**          | **Eloquent**                                                  | **Query Builder**                                            |
|-----------------------|---------------------------------------------------------------|-------------------------------------------------------------|
| **Cấu trúc**           | ORM, làm việc với các đối tượng mô hình                        | API cung cấp các phương thức xây dựng truy vấn              |
| **Hiệu năng**          | Chậm hơn khi thực hiện các truy vấn đơn giản, đặc biệt với dữ liệu lớn | Nhanh hơn, tốt cho các truy vấn phức tạp hoặc dữ liệu lớn   |
| **Dễ sử dụng**         | Dễ sử dụng cho các thao tác CRUD và quan hệ giữa các bảng     | Cần viết thủ công nhiều hơn nhưng linh hoạt hơn             |
| **Làm việc với đối tượng** | Tự động ánh xạ giữa đối tượng và cơ sở dữ liệu                  | Trả về kết quả dạng mảng (array) thay vì đối tượng           |
| **Tính mở rộng**       | Hỗ trợ quan hệ giữa các bảng, tích hợp tốt với các mô hình    | Tập trung vào truy vấn thuần túy, không hỗ trợ quan hệ      |
| **Truy vấn phức tạp**  | Khó tùy chỉnh các truy vấn phức tạp                           | Linh hoạt hơn khi xử lý các truy vấn phức tạp               |

### 3. **Khi nào nên sử dụng?**
- **Eloquent**:
  - Khi bạn cần làm việc với các quan hệ giữa các bảng như One-to-One, One-to-Many, Many-to-Many.
  - Khi mô hình hóa dữ liệu và ánh xạ trực tiếp các bản ghi cơ sở dữ liệu thành các đối tượng.
  - Khi cần xây dựng các ứng dụng nhanh chóng mà không cần quá nhiều tối ưu hóa về hiệu năng.
  
- **Query Builder**:
  - Khi bạn cần thực hiện các truy vấn phức tạp và tối ưu hóa hiệu năng.
  - Khi dữ liệu rất lớn và các thao tác liên quan đến hàng loạt bản ghi.
  - Khi bạn chỉ cần lấy dữ liệu mà không cần ánh xạ đối tượng (chẳng hạn như với các báo cáo hoặc xử lý dữ liệu lớn).

### 4. **Ví dụ minh họa**

#### a. **Eloquent Example** (CRUD cơ bản và quan hệ)
```php
// Tạo mới một user
$user = new User;
$user->name = 'John Doe';
$user->email = 'john@example.com';
$user->save();

// Lấy tất cả user
$users = User::all();

// Tìm user theo ID
$user = User::find(1);

// Cập nhật user
$user->name = 'Updated Name';
$user->save();

// Xóa user
$user->delete();

// Quan hệ: Lấy tất cả bài viết của một user
$user = User::find(1);
$posts = $user->posts; // Lấy bài viết bằng quan hệ One-to-Many
```

#### b. **Query Builder Example**
```php
use Illuminate\Support\Facades\DB;

// Tạo mới một user
DB::table('users')->insert([
    'name' => 'John Doe',
    'email' => 'john@example.com'
]);

// Lấy tất cả user
$users = DB::table('users')->get();

// Tìm user theo ID
$user = DB::table('users')->where('id', 1)->first();

// Cập nhật user
DB::table('users')->where('id', 1)->update([
    'name' => 'Updated Name'
]);

// Xóa user
DB::table('users')->where('id', 1)->delete();

// Truy vấn phức tạp với Join
$results = DB::table('posts')
    ->join('users', 'users.id', '=', 'posts.user_id')
    ->select('posts.*', 'users.name as author')
    ->get();
```

### 5. **Hiệu năng**
- **Eloquent**: Do phải ánh xạ kết quả truy vấn thành đối tượng, Eloquent có thể chậm hơn trong các truy vấn với dữ liệu lớn. Mỗi bản ghi được trả về dưới dạng một đối tượng và việc ánh xạ dữ liệu này tốn tài nguyên hơn so với Query Builder.
  
- **Query Builder**: Trực tiếp truy vấn và trả về dữ liệu dưới dạng mảng (array), không cần ánh xạ thành đối tượng. Điều này giúp Query Builder nhanh hơn đáng kể trong các trường hợp cần truy vấn nhiều dữ liệu hoặc các thao tác phức tạp.

### 6. **Quan hệ giữa các bảng**
- **Eloquent** cung cấp các phương thức mạnh mẽ để làm việc với các quan hệ, chẳng hạn như `hasOne`, `hasMany`, `belongsTo`, `belongsToMany`. Điều này giúp việc truy xuất và quản lý dữ liệu liên quan giữa các bảng rất dễ dàng.
  
- **Query Builder** không hỗ trợ trực tiếp các quan hệ giữa các bảng. Để thực hiện các truy vấn quan hệ, bạn cần sử dụng các câu lệnh `JOIN` hoặc viết các truy vấn phức tạp hơn.

### 7. **Lựa chọn khi nào sử dụng**
- **Eloquent** là lựa chọn tốt khi:
  - Bạn làm việc với các mô hình dữ liệu phức tạp và cần ánh xạ giữa bảng và đối tượng.
  - Ứng dụng cần sử dụng các quan hệ giữa các bảng, hoặc khi bạn cần quản lý các bản ghi đơn giản.

- **Query Builder** là lựa chọn tốt khi:
  - Bạn cần tối ưu hóa truy vấn cho hiệu năng, đặc biệt khi xử lý các truy vấn lớn hoặc phức tạp.
  - Bạn không cần ánh xạ đối tượng, mà chỉ cần dữ liệu dưới dạng mảng để xử lý trực tiếp.

---

Tóm lại, **Eloquent** rất phù hợp cho các ứng dụng nhỏ hoặc vừa, nơi mà tính dễ hiểu và khả năng mở rộng quan hệ là cần thiết. Trong khi đó, **Query Builder** sẽ là lựa chọn tốt hơn khi bạn cần truy vấn hiệu quả với dữ liệu lớn hoặc các thao tác phức tạp.
