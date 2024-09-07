### Cách Cookie được gửi lên server trong mỗi request

Mỗi khi trình duyệt gửi một **HTTP request** đến server, nó tự động gửi kèm các **cookie** có liên quan đến domain và đường dẫn (path) của server đó. Dưới đây là cách hoạt động của quá trình này:

### 1. **Tạo và lưu cookie**:
Server có thể gửi cookie đến trình duyệt thông qua header **`Set-Cookie`** trong phản hồi HTTP (HTTP response). Cookie này sẽ được trình duyệt lưu trữ nếu không bị từ chối (ví dụ do cài đặt bảo mật hoặc dung lượng vượt quá giới hạn).

**Ví dụ: Server tạo cookie trong HTTP response**:
```http
HTTP/1.1 200 OK
Set-Cookie: user_session=abc123; Path=/; Expires=Wed, 13 Sep 2024 10:00:00 GMT; Secure; HttpOnly
```
Trong trường hợp này:
- **`user_session=abc123`**: Dữ liệu của cookie là một cặp khóa-giá trị.
- **`Path=/`**: Cookie sẽ được gửi trong tất cả các request thuộc đường dẫn `/` và các đường dẫn con.
- **`Expires`**: Thời gian hết hạn của cookie.
- **`Secure`**: Cookie chỉ được gửi qua kết nối HTTPS.
- **`HttpOnly`**: Cookie chỉ có thể truy cập bởi server, không thể bị truy cập hoặc thay đổi thông qua JavaScript.

### 2. **Trình duyệt gửi cookie trong các request**:
Khi người dùng thực hiện một hành động như tải lại trang hoặc truy cập một trang mới trong cùng domain và path, trình duyệt tự động thêm cookie vào các request gửi đến server bằng header **`Cookie`**.

**Ví dụ: Trình duyệt gửi cookie trong HTTP request**:
```http
GET /profile HTTP/1.1
Host: example.com
Cookie: user_session=abc123
```

Trong yêu cầu này:
- **`Cookie: user_session=abc123`**: Cookie đã được gửi từ trình duyệt đến server theo đúng domain và path.

### 3. **Điều kiện để cookie được gửi lên server**:
Cookie chỉ được gửi lên server nếu các điều kiện sau được thỏa mãn:
- **Domain**: Cookie phải thuộc về cùng domain hoặc subdomain của server mà yêu cầu được gửi đến.
- **Path**: Cookie chỉ được gửi nếu URL của yêu cầu thuộc về đường dẫn đã chỉ định khi cookie được tạo.
- **Secure flag**: Nếu cookie có flag `Secure`, nó chỉ được gửi qua các kết nối HTTPS (không gửi qua HTTP không bảo mật).
- **HttpOnly flag**: Nếu cookie có flag `HttpOnly`, cookie chỉ có thể được gửi và truy cập bởi server, không thể bị đọc hoặc chỉnh sửa bởi JavaScript.
- **SameSite policy**: Cài đặt chính sách `SameSite` (Strict, Lax, None) sẽ ảnh hưởng đến việc cookie có được gửi qua yêu cầu từ các trang khác nhau hay không.

### 4. **Quy trình tổng quát**:
1. **Client gửi request đầu tiên đến server**: Không có cookie ban đầu.
2. **Server phản hồi với Set-Cookie**: Cookie được gửi và trình duyệt lưu trữ cookie đó.
3. **Client gửi request tiếp theo**: Trình duyệt tự động gửi cookie liên quan trong các yêu cầu đến cùng domain và path.

### Ví dụ thực tế:
Giả sử bạn truy cập một trang web thương mại điện tử và đăng nhập. Sau khi đăng nhập, server gửi cho trình duyệt một cookie để lưu trạng thái đăng nhập.

#### Request đầu tiên (trước khi đăng nhập):
```http
GET /login HTTP/1.1
Host: shop.com
```

#### Response từ server (sau khi đăng nhập thành công):
```http
HTTP/1.1 200 OK
Set-Cookie: session_id=abc123; Path=/; Secure; HttpOnly; Expires=Wed, 13 Sep 2024 10:00:00 GMT
```

#### Request tiếp theo (khi tải trang giỏ hàng sau khi đăng nhập):
```http
GET /cart HTTP/1.1
Host: shop.com
Cookie: session_id=abc123
```

Trong ví dụ này, cookie **`session_id=abc123`** được gửi kèm với request, giúp server nhận biết rằng người dùng đã đăng nhập và có thể truy cập giỏ hàng của mình mà không cần đăng nhập lại.

### Tóm lại:
- Cookie được gửi kèm trong mọi HTTP request tới server nếu domain và path của cookie phù hợp với yêu cầu đó.
- Cookie có thể được sử dụng để duy trì trạng thái của người dùng giữa các request (ví dụ: trạng thái đăng nhập, thông tin giỏ hàng).
