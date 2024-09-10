**Repository Pattern** trong Laravel giúp tách biệt logic truy xuất dữ liệu ra khỏi các lớp nghiệp vụ như controller hoặc service, giúp code dễ bảo trì, kiểm thử và mở rộng hơn. Dưới đây là cách triển khai **Repository Pattern** vào một dự án thực tế trong Laravel với giải thích và code chi tiết.

### Khi nào nên sử dụng Repository Pattern?
- Khi bạn muốn tách biệt truy xuất dữ liệu khỏi logic nghiệp vụ.
- Khi có nhiều nguồn dữ liệu khác nhau (cơ sở dữ liệu, API bên ngoài) nhưng cần một API thống nhất để truy xuất dữ liệu.
- Khi cần dễ dàng thay đổi hoặc mở rộng cách thức truy xuất dữ liệu mà không ảnh hưởng đến lớp controller hoặc service.

### Triển khai Repository Pattern vào dự án quản lý sản phẩm

#### Bước 1: Tạo Interface cho Repository

Tạo một Interface định nghĩa các phương thức cho việc truy xuất dữ liệu sản phẩm.

```php
<?php

namespace App\Repositories;

interface ProductRepositoryInterface
{
    public function getAll();
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
```

**Giải thích**:
- Interface định nghĩa các phương thức cơ bản như: lấy tất cả sản phẩm, tìm sản phẩm theo ID, tạo, cập nhật và xóa sản phẩm.

#### Bước 2: Tạo lớp Repository cụ thể

Tạo một lớp `ProductRepository` triển khai các phương thức từ interface và sử dụng Eloquent để tương tác với cơ sở dữ liệu.

```php
<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function findById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $product = $this->findById($id);
        $product->update($data);
        return $product;
    }

    public function delete(int $id)
    {
        $product = $this->findById($id);
        return $product->delete();
    }
}
```

**Giải thích**:
- Lớp `ProductRepository` thực hiện các phương thức được định nghĩa trong `ProductRepositoryInterface` bằng cách sử dụng model Eloquent (`Product`).
- Trong trường hợp không tìm thấy sản phẩm, `findOrFail()` sẽ ném ra một ngoại lệ `ModelNotFoundException`.

#### Bước 3: Đăng ký Repository trong Service Provider

Để Laravel biết phải sử dụng repository nào khi gặp Interface tương ứng, ta bind interface với repository cụ thể trong một Service Provider.

Tạo Service Provider:

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\ProductRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }

    public function boot()
    {
        //
    }
}
```

Sau đó, thêm `RepositoryServiceProvider` vào file `config/app.php`:

```php
'providers' => [
    // Các service providers khác...
    App\Providers\RepositoryServiceProvider::class,
],
```

**Giải thích**:
- Ta sử dụng `bind()` để liên kết `ProductRepositoryInterface` với `ProductRepository`. Khi Laravel cần sử dụng `ProductRepositoryInterface`, nó sẽ tự động tạo ra một instance của `ProductRepository`.

#### Bước 4: Sử dụng Repository trong Controller

Controller sẽ gọi các phương thức trong repository để thao tác với dữ liệu.

```php
<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $products = $this->productRepository->getAll();
        return response()->json($products);
    }

    public function show($id)
    {
        $product = $this->productRepository->findById($id);
        return response()->json($product);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $product = $this->productRepository->create($data);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $product = $this->productRepository->update($id, $data);
        return response()->json($product);
    }

    public function destroy($id)
    {
        $this->productRepository->delete($id);
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
```

**Giải thích**:
- **Dependency Injection**: `ProductRepositoryInterface` được inject vào controller qua constructor, giúp controller không cần quan tâm chi tiết cách truy xuất dữ liệu.
- **Validation**: Request được xác thực trước khi gửi đến repository để tạo hoặc cập nhật sản phẩm.

#### Bước 5: Kiểm thử Repository

Bằng cách sử dụng Interface, ta có thể dễ dàng mock repository để kiểm thử controller mà không cần truy xuất cơ sở dữ liệu thật.

```php
public function test_it_returns_all_products()
{
    $productRepoMock = Mockery::mock(ProductRepositoryInterface::class);
    $productRepoMock->shouldReceive('getAll')->andReturn([/* Dữ liệu giả */]);

    $this->app->instance(ProductRepositoryInterface::class, $productRepoMock);

    $response = $this->get('/products');
    $response->assertStatus(200);
}
```

**Giải thích**:
- **Mockery** được sử dụng để mock `ProductRepositoryInterface`. Khi controller gọi đến phương thức `getAll()`, nó sẽ trả về dữ liệu giả mà không truy xuất cơ sở dữ liệu thực tế.

### Bước 6: Mở rộng Repository

Với Repository Pattern, ta có thể dễ dàng mở rộng logic truy xuất dữ liệu mà không ảnh hưởng đến controller.

Giả sử ta cần thêm tính năng lọc sản phẩm theo giá. Chỉ cần thêm phương thức `getByPriceRange()` vào repository.

```php
public function getByPriceRange($min, $max)
{
    return $this->model->whereBetween('price', [$min, $max])->get();
}
```

Sau đó, sử dụng phương thức này trong controller:

```php
public function filterByPrice(Request $request)
{
    $min = $request->query('min_price');
    $max = $request->query('max_price');
    
    $products = $this->productRepository->getByPriceRange($min, $max);
    return response()->json($products);
}
```

### Tóm tắt
- **Repository Pattern** giúp tách biệt logic truy xuất dữ liệu ra khỏi controller, làm cho code dễ bảo trì, kiểm thử và mở rộng hơn.
- **Interface** giúp tạo ra một API chung cho việc truy xuất dữ liệu, giúp dễ dàng thay đổi cách thức truy xuất dữ liệu mà không ảnh hưởng đến các lớp nghiệp vụ.
- **Controller** chỉ cần gọi các phương thức trong repository, đảm bảo sự rõ ràng và trách nhiệm đơn nhất.

Trong dự án thực tế, **Repository Pattern** đặc biệt hữu ích khi cần tái sử dụng logic truy xuất dữ liệu, xử lý logic phức tạp hoặc làm việc với nhiều nguồn dữ liệu khác nhau.
