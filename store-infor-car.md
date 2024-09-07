Các trang thương mại điện tử thường sử dụng một số kỹ thuật để lưu trữ thông tin giỏ hàng sao cho dữ liệu vẫn tồn tại ngay cả khi người dùng đã tắt trình duyệt và mở lại, bao gồm:

### 1. **Lưu trữ giỏ hàng bằng **Local Storage**:
   - **Cách hoạt động**: Thông tin giỏ hàng được lưu trữ trực tiếp trên trình duyệt của người dùng bằng Local Storage. Dữ liệu này sẽ tồn tại ngay cả khi người dùng đóng trình duyệt và mở lại.
   - **Ưu điểm**: Dễ triển khai và không phụ thuộc vào trạng thái đăng nhập của người dùng. Thông tin có thể lưu trữ mà không cần gửi lên server, giúp tiết kiệm tài nguyên.
   - **Nhược điểm**: Chỉ lưu trữ trên máy của người dùng cụ thể, không thể đồng bộ giữa các thiết bị.

   **Ví dụ**:
   ```js
   // Thêm sản phẩm vào giỏ hàng
   let cart = JSON.parse(localStorage.getItem('cart')) || [];
   cart.push({ productId: 123, quantity: 1 });
   localStorage.setItem('cart', JSON.stringify(cart));

   // Lấy lại giỏ hàng khi mở lại trang
   let savedCart = JSON.parse(localStorage.getItem('cart')) || [];
   console.log(savedCart);
   ```

### 2. **Sử dụng **Cookies**:
   - **Cách hoạt động**: Thông tin giỏ hàng có thể lưu trong cookies và được gửi kèm với mỗi yêu cầu HTTP. Cookie có thể được cấu hình để tồn tại trong một khoảng thời gian dài (tùy theo thời gian hết hạn được cài đặt).
   - **Ưu điểm**: Cookie có thể đồng bộ giữa các phiên trình duyệt, có thể được truy cập và sử dụng từ phía server hoặc client.
   - **Nhược điểm**: Dung lượng lưu trữ hạn chế (khoảng 4KB), dữ liệu gửi kèm với mỗi yêu cầu HTTP có thể tăng tải trọng cho server.

   **Ví dụ**:
   ```js
   // Lưu giỏ hàng vào cookie
   document.cookie = "cart=" + JSON.stringify(cart) + "; path=/; max-age=31536000"; // Lưu 1 năm

   // Lấy lại giỏ hàng từ cookie
   let cartCookie = document.cookie
     .split('; ')
     .find(row => row.startsWith('cart='))
     ?.split('=')[1];
   let cart = JSON.parse(cartCookie);
   ```

### 3. **Lưu trữ giỏ hàng trên **Database Server**:
   - **Cách hoạt động**: Giỏ hàng của người dùng sẽ được lưu trên server và gắn với tài khoản của người dùng. Khi người dùng đăng nhập lại (hoặc thông qua một phiên làm việc đã được xác thực), giỏ hàng sẽ được tải từ cơ sở dữ liệu của server.
   - **Ưu điểm**: Đồng bộ dữ liệu giữa các thiết bị, người dùng có thể tiếp tục giỏ hàng từ bất kỳ nơi đâu. An toàn và bảo mật hơn khi dữ liệu lưu trên server.
   - **Nhược điểm**: Cần người dùng phải đăng nhập hoặc tạo tài khoản để lưu trữ giỏ hàng, có thể phức tạp hơn trong việc quản lý.

   **Quy trình**:
   1. Khi người dùng thêm sản phẩm vào giỏ hàng, giỏ hàng được lưu trên server (ví dụ: database).
   2. Mỗi khi người dùng quay lại trang web, hệ thống sẽ kiểm tra giỏ hàng từ cơ sở dữ liệu dựa trên tài khoản hoặc ID người dùng (thông qua session hoặc cookie).
   
   **Ví dụ**:
   ```php
   // PHP - Lưu giỏ hàng vào database khi người dùng thêm sản phẩm
   $userId = $_SESSION['user_id'];
   $cart = json_encode($_SESSION['cart']); // Giả sử giỏ hàng lưu trong session
   $query = "UPDATE carts SET cart_data = '$cart' WHERE user_id = $userId";
   mysqli_query($conn, $query);

   // PHP - Lấy giỏ hàng từ database khi người dùng quay lại
   $query = "SELECT cart_data FROM carts WHERE user_id = $userId";
   $result = mysqli_query($conn, $query);
   $cart = json_decode(mysqli_fetch_assoc($result)['cart_data'], true);
   ```

### 4. **Kết hợp giữa Local Storage và Database**:
   - **Cách hoạt động**: Giỏ hàng sẽ được lưu trữ trên Local Storage khi người dùng không đăng nhập. Khi người dùng đăng nhập, giỏ hàng sẽ được đồng bộ với server (hoặc có thể gộp với giỏ hàng hiện tại trên server).
   - **Ưu điểm**: Giúp giữ giỏ hàng cho cả người dùng đã đăng nhập và chưa đăng nhập, và đảm bảo đồng bộ khi đăng nhập trên các thiết bị khác.
   - **Nhược điểm**: Phức tạp hơn khi phải quản lý việc đồng bộ dữ liệu giữa client và server.

   **Quy trình**:
   1. Khi người dùng thêm sản phẩm vào giỏ hàng, thông tin sẽ được lưu vào Local Storage.
   2. Khi người dùng đăng nhập, dữ liệu từ Local Storage sẽ được gửi lên server và đồng bộ với giỏ hàng trên server.

   **Ví dụ**:
   ```js
   // Khi người dùng đăng nhập, đồng bộ giỏ hàng từ Local Storage lên server
   let localCart = JSON.parse(localStorage.getItem('cart')) || [];
   fetch('/sync-cart', {
     method: 'POST',
     body: JSON.stringify({ cart: localCart }),
     headers: { 'Content-Type': 'application/json' }
   });
   ```

### Tổng kết:
- **Local Storage**: Giữ giỏ hàng trên trình duyệt và tồn tại lâu dài, không cần đăng nhập.
- **Cookie**: Lưu dữ liệu tạm thời trên trình duyệt với thời gian hết hạn cụ thể.
- **Database Server**: Lưu giỏ hàng lâu dài và đồng bộ giữa các thiết bị, yêu cầu đăng nhập để quản lý.
