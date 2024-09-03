# Những câu hỏi liên quan đến bảo mật

---

### **1. Xác thực và Ủy quyền (Authentication & Authorization):**

* **Xác thực:** Hiểu rõ các phương thức xác thực như mật khẩu, OAuth 2.0, OpenID Connect, 2FA (Xác thực hai yếu tố).
* **Ủy quyền:** Quản lý quyền truy cập cho người dùng dựa trên vai trò và quyền hạn, sử dụng các kỹ thuật như Role-Based Access Control (RBAC) và Attribute-Based Access Control (ABAC).
* **Bảo mật mật khẩu:** Sử dụng hashing và salting để lưu trữ mật khẩu một cách an toàn, tránh lưu trữ mật khẩu dạng plain text.
* **Multi-factor Authentication (MFA):** Thêm các lớp bảo mật bổ sung như mã OTP, xác thực sinh trắc học.

### **2. Quản lý Session và Cookie:**

* **Session Management:** Hiểu cách hoạt động của session, cách tạo và quản lý session ID, bảo vệ session khỏi bị đánh cắp.
* **Cookie Management:** Sử dụng cookie một cách an toàn, thiết lập các thuộc tính như HttpOnly và Secure, tránh lưu trữ thông tin nhạy cảm trong cookie.
* **Cross-Site Scripting (XSS) Prevention:** Bảo vệ ứng dụng khỏi các cuộc tấn công XSS bằng cách thực thi input validation và output encoding.

### **3. Input Validation và Sanitization:**

* **Input Validation:** Kiểm tra và xác thực dữ liệu đầu vào từ người dùng để ngăn chặn các cuộc tấn công như SQL Injection và Cross-Site Scripting.
* **Sanitization:** Làm sạch dữ liệu đầu vào trước khi sử dụng trong các truy vấn cơ sở dữ liệu hoặc hiển thị trên trang web.
* **Data Validation:** Kiểm tra dữ liệu để đảm bảo tính hợp lệ và phù hợp với các ràng buộc của ứng dụng.

### **4. SQL Injection Prevention:**

* **Prepared Statements:** Sử dụng prepared statements để ngăn chặn các cuộc tấn công SQL Injection.
* **Parameterization:** Sử dụng tham số hóa để truyền dữ liệu vào truy vấn SQL, tránh việc dữ liệu được xử lý như mã SQL.
* **Input Sanitization:** Làm sạch dữ liệu đầu vào trước khi sử dụng trong các truy vấn SQL.

### **5. Cross-Site Request Forgery (CSRF) Prevention:**

* **CSRF Tokens:** Sử dụng token CSRF để xác thực các yêu cầu từ phía client, ngăn chặn các cuộc tấn công CSRF.
* **Referer Header Check:** Kiểm tra header Referer để đảm bảo yêu cầu đến từ trang web hợp lệ.
* **Double Submit Cookie:** Sử dụng cookie để xác thực các yêu cầu.

### **6. Bảo mật Cơ sở dữ liệu:**

* **Access Control:** Quản lý quyền truy cập vào cơ sở dữ liệu, hạn chế quyền truy cập cho các tài khoản người dùng.
* **Data Encryption:** Mã hóa dữ liệu nhạy cảm được lưu trữ trong cơ sở dữ liệu.
* **Database Auditing:** Theo dõi các hoạt động truy cập và thay đổi dữ liệu trong cơ sở dữ liệu.

### **7. Bảo mật API:**

* **API Authentication:** Sử dụng các phương thức xác thực mạnh mẽ để bảo vệ API, chẳng hạn như API Key, OAuth 2.0.
* **API Rate Limiting:** Hạn chế số lượng yêu cầu đến API trong một khoảng thời gian nhất định để ngăn chặn các cuộc tấn công DDoS.
* **API Security Headers:** Sử dụng các header bảo mật như Content-Security-Policy và X-Frame-Options để bảo vệ API.

### **8. Bảo mật Server:**

* **Firewall:** Sử dụng firewall để ngăn chặn các truy cập trái phép vào server.
* **Intrusion Detection System (IDS) và Intrusion Prevention System (IPS):** Phát hiện và ngăn chặn các hoạt động độc hại trên server.
* **Regular Security Updates:** Cập nhật hệ điều hành và các phần mềm trên server thường xuyên để vá các lỗ hổng bảo mật.

### **9. Bảo mật mã nguồn:**

* **Secure Coding Practices:** Tuân thủ các best practices về bảo mật khi viết mã, tránh các lỗi phổ biến dẫn đến lỗ hổng bảo mật.
* **Code Review:** Thực hiện code review để phát hiện và sửa lỗi bảo mật trong mã nguồn.
* **Static Application Security Testing (SAST):** Sử dụng công cụ SAST để phân tích mã nguồn và phát hiện các lỗ hổng bảo mật.

### **10.Phòng chống tấn công Brute Force và Dictionary Attack**

* **Sử dụng CAPTCHA:** Áp dụng CAPTCHA để ngăn chặn các cuộc tấn công brute force.
* **Lockout tài khoản:** Tạm khóa tài khoản sau một số lần đăng nhập sai liên tiếp.

### **11. Bảo mật mạng (Network Security):**

* **Sử dụng HTTPS:** Sử dụng giao thức HTTPS để mã hóa giao tiếp giữa client và server.
* **WAF (Web Application Firewall):** Sử dụng WAF để lọc và chặn các yêu cầu web độc hại.
* **Bảo mật mạng nội bộ:** Sử dụng các biện pháp an ninh mạng để bảo vệ mạng nội bộ và các máy chủ web.

### **12.Quản lý lỗi (Error Handling):**

* **Không hiển thị thông tin lỗi chi tiết:** Tránh hiển thị thông tin lỗi chi tiết cho người dùng để ngăn chặn kẻ tấn công khai thác.
* **Ghi lại lỗi:** Ghi lại thông tin lỗi để phân tích và khắc phục lỗi.

### **13. Hiểu biết về các mối đe dọa bảo mật phổ biến:**

* **SQL Injection:**
  * **Sử dụng câu lệnh chuẩn bị (Prepared Statements):** Dùng các câu lệnh chuẩn bị để ngăn chặn việc chèn mã SQL độc hại.
  * **Sử dụng ORM:** Các công cụ ORM (Object-Relational Mapping) như Hibernate, Entity Framework giúp hạn chế nguy cơ SQL Injection.
* **Cross-Site Scripting (XSS)**
  * **Eskap dữ liệu động:** Sử dụng các thư viện hoặc hàm để escap dữ liệu đầu ra, tránh việc nhúng mã JavaScript độc hại vào trang web.
  * **Content Security Policy (CSP):** Định nghĩa CSP để giảm thiểu nguy cơ tấn công XSS.
* **Cross-Site Request Forgery (CSRF):**
  * **Sử dụng CSRF Token:** Tạo và kiểm tra CSRF token trong các yêu cầu POST để đảm bảo yêu cầu là hợp lệ và từ người dùng đã xác thực.
  * **Kiểm tra nguồn gốc yêu cầu:** Kiểm tra Origin và Referer headers.
* **Session Hijacking:** Sử dụng X-Frame-Options để ngăn chặn việc trang web bị nhúng vào iframe độc hại.
* **Man-in-the-Middle (MitM):** Sử dụng HTTPS và HSTS để bảo vệ dữ liệu khỏi các cuộc tấn công MitM.
* **Denial-of-Service (DoS) và Distributed Denial-of-Service (DDoS)**
  * Sử dụng hệ thống lọc IP: Lọc lưu lượng từ các địa chỉ IP đáng ngờ hoặc từ các khu vực địa lý không mong muốn.
  * Sử dụng CDN: CDN giúp giảm thiểu tác động của tấn công DDoS bằng cách phân tán lưu lượng truy cập.
