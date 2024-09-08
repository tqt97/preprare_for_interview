**Eloquent** là ORM (Object-Relational Mapping) được tích hợp sẵn trong Laravel, giúp tương tác với cơ sở dữ liệu một cách thuận tiện thông qua các mô hình (models). Thay vì viết các truy vấn SQL thủ công, Eloquent cho phép bạn sử dụng các phương thức của mô hình để thực hiện các thao tác với cơ sở dữ liệu một cách trực quan và dễ hiểu.

### 1. **Khái niệm Eloquent ORM**
   - Eloquent giúp ánh xạ các bảng trong cơ sở dữ liệu thành các class PHP (model). Mỗi record trong bảng tương ứng với một đối tượng của class model đó.
   - Eloquent hỗ trợ các thao tác cơ bản như tạo, đọc, cập nhật, xóa (CRUD), và cả các quan hệ phức tạp giữa các bảng như `hasOne`, `hasMany`, `belongsTo`, `belongsToMany`.

### 2. **Cơ chế hoạt động của Eloquent**
   - Eloquent sử dụng **Active Record Pattern**, trong đó mỗi mô hình không chỉ đại diện cho một bảng trong cơ sở dữ liệu mà còn có thể thực hiện các thao tác trên chính nó như lưu, cập nhật hoặc xóa dữ liệu.
   - Mỗi lớp model trong Eloquent tương ứng với một bảng trong cơ sở dữ liệu và cung cấp các phương thức truy vấn tự động mà không cần viết SQL.
   
   Ví dụ về cách sử dụng cơ bản của Eloquent:
   ```php
   class User extends Model {
       protected $table = 'users'; // Ánh xạ đến bảng 'users'
   }

   // Lấy tất cả các bản ghi từ bảng 'users'
   $users = User::all();

   // Lấy một bản ghi theo ID
   $user = User::find(1);

   // Tạo một bản ghi mới
   $user = new User;
   $user->name = 'John';
   $user->email = 'john@example.com';
   $user->save(); // Lưu vào bảng 'users'
   ```

### 3. **Các đặc điểm chính của Eloquent**

#### a. **Các thao tác CRUD**
   - **Tạo mới (Create)**:
     Sử dụng Eloquent, bạn có thể tạo một bản ghi mới bằng cách gán giá trị cho các thuộc tính của model và gọi phương thức `save()`:
     ```php
     $user = new User;
     $user->name = 'John Doe';
     $user->email = 'john@example.com';
     $user->save();
     ```

     Hoặc có thể sử dụng phương thức `create()` (yêu cầu phải có `fillable` trong model để bảo mật):
     ```php
     User::create([
         'name' => 'John Doe',
         'email' => 'john@example.com'
     ]);
     ```

   - **Đọc dữ liệu (Read)**:
     Bạn có thể sử dụng các phương thức như `all()`, `find()`, `first()`, `where()` để truy vấn dữ liệu.
     ```php
     // Lấy tất cả các user
     $users = User::all();

     // Lấy user có id bằng 1
     $user = User::find(1);

     // Tìm user theo điều kiện
     $user = User::where('email', 'john@example.com')->first();
     ```

   - **Cập nhật (Update)**:
     Để cập nhật một bản ghi, bạn chỉ cần gán giá trị mới cho các thuộc tính của model và gọi phương thức `save()`:
     ```php
     $user = User::find(1);
     $user->name = 'John Updated';
     $user->save();
     ```

   - **Xóa (Delete)**:
     Eloquent cung cấp các phương thức để xóa dữ liệu, bao gồm `delete()` và `destroy()`:
     ```php
     $user = User::find(1);
     $user->delete(); // Xóa bản ghi với id = 1
     
     // Xóa nhiều bản ghi cùng lúc
     User::destroy([1, 2, 3]);
     ```

#### b. **Quan hệ giữa các bảng (Relationships)**
   Eloquent hỗ trợ định nghĩa các mối quan hệ giữa các model, giúp dễ dàng thực hiện các truy vấn phức tạp mà không cần viết nhiều truy vấn SQL.

   - **One-to-One (Một-Một)**: Ví dụ, mỗi user có một profile:
     ```php
     class User extends Model {
         public function profile() {
             return $this->hasOne(Profile::class);
         }
     }

     // Truy vấn thông qua quan hệ
     $profile = User::find(1)->profile;
     ```

   - **One-to-Many (Một-Nhiều)**: Ví dụ, mỗi user có nhiều bài viết (posts):
     ```php
     class User extends Model {
         public function posts() {
             return $this->hasMany(Post::class);
         }
     }

     // Truy vấn thông qua quan hệ
     $posts = User::find(1)->posts;
     ```

   - **Many-to-Many (Nhiều-Nhiều)**: Ví dụ, một bài viết có nhiều thẻ (tags) và ngược lại:
     ```php
     class Post extends Model {
         public function tags() {
             return $this->belongsToMany(Tag::class);
         }
     }

     // Truy vấn thông qua quan hệ
     $tags = Post::find(1)->tags;
     ```

   - **BelongsTo (Ngược lại của hasOne và hasMany)**: Ví dụ, mỗi bài viết thuộc về một user:
     ```php
     class Post extends Model {
         public function user() {
             return $this->belongsTo(User::class);
         }
     }
     ```

#### c. **Soft Deletes (Xóa mềm)**
   Laravel Eloquent hỗ trợ tính năng "xóa mềm", giúp không xóa vĩnh viễn bản ghi khỏi cơ sở dữ liệu, mà chỉ đánh dấu là đã xóa.

   **Cách sử dụng:**
   - Thêm trait `SoftDeletes` vào model:
     ```php
     use Illuminate\Database\Eloquent\Model;
     use Illuminate\Database\Eloquent\SoftDeletes;

     class Post extends Model {
         use SoftDeletes;
     }
     ```
   - Khi gọi phương thức `delete()`, bản ghi sẽ được đánh dấu là đã xóa nhưng vẫn còn trong cơ sở dữ liệu.
   - Để lấy lại các bản ghi đã xóa, sử dụng phương thức `withTrashed()` hoặc `onlyTrashed()`:
     ```php
     $posts = Post::withTrashed()->get();
     $deletedPosts = Post::onlyTrashed()->get();
     ```

#### d. **Scopes (Phạm vi truy vấn)**
   Scopes là một cách để định nghĩa các truy vấn thường dùng trong một model, giúp mã dễ bảo trì hơn.

   **Cách sử dụng:**
   - Tạo một scope trong model:
     ```php
     class User extends Model {
         public function scopeActive($query) {
             return $query->where('active', 1);
         }
     }
     ```
   - Sử dụng scope trong truy vấn:
     ```php
     $activeUsers = User::active()->get();
     ```

### 4. **Cơ chế Lazy Loading và Eager Loading**
   - **Lazy Loading**: Khi bạn truy xuất một quan hệ giữa các model, Laravel sẽ chỉ truy vấn cơ sở dữ liệu khi bạn thực sự yêu cầu truy cập vào quan hệ đó.
     ```php
     $user = User::find(1);
     $posts = $user->posts; // Chỉ lúc này mới chạy truy vấn để lấy posts
     ```
   
   - **Eager Loading**: Để tránh vấn đề n+1 query, bạn có thể sử dụng eager loading để tải sẵn các quan hệ khi truy vấn model.
     ```php
     $users = User::with('posts')->get(); // Lấy cả users và posts trong cùng một lần truy vấn
     ```

### 5. **Mass Assignment (Gán hàng loạt) và bảo mật**
   Eloquent cho phép gán giá trị hàng loạt cho các thuộc tính thông qua phương thức `create()` hoặc `fill()`. Tuy nhiên, để tránh việc gán giá trị cho các thuộc tính không mong muốn (có thể gây nguy hiểm), bạn cần bảo vệ bằng cách chỉ định các thuộc tính nào có thể được gán bằng cách sử dụng `$fillable` hoặc `$guarded`.

   **Cách sử dụng:**
   ```php
   class User extends Model {
       protected $fillable = ['name', 'email']; // Chỉ cho phép gán các thuộc tính này
   }

   User::create([
       'name' => 'John Doe',
       'email' => 'john@example.com',
       'is_admin' => true // Sẽ bị bỏ qua vì không có trong $fillable
   ]);
   ```

### Kết luận
Eloquent là một phần quan trọng trong Laravel, giúp bạn làm việc với cơ sở dữ liệu một cách dễ dàng, linh hoạt và bảo mật. Nhờ các tính năng mạnh mẽ như quan hệ, scopes, soft deletes và mass assignment protection, Eloquent giúp tăng hiệu suất lập trình và khả năng bảo trì hệ thống.
