* Thiếu: </br>
- Mục: </br>
+ Chức năng xóa tất cả: Thiếu trang danh mục, sản phẩm, danh mục hình ảnh, tài khoản
+ Chưa làm phần nguyên liệu, công thức (chỉ mới ra danh sách)
+ Chưa làm nốt thêm chi tiết các nguyên liệu mới làm ra giao diện 
+ Có TH back lại từ trang chi tiết sẽ thử xem có giữ đc code không
- Còn lại: </br>
Xem lại cái chức năng xóa để tránh k bị lỗi dữ liệu
Còn chức năng Xóa nhiều và chọn nhiều chưa áp dụng cho tất cả các phần </br>
* Lưu ý: </br>
- Đối với việc sử dụng CKEditor, nếu bạn muốn render ra dữ liệu để gán vào html thì hãy sử dụng CKEDITOR.instances["tên class hoặc tên id"].setData();. Còn nếu bạn muốn lấy thì hãy sử dụng CKEDITOR.instances['tên class hoặc tên id'].getData() </br>
- Cùng với đó nếu sử dụng FormData kết hợp với CKEditor, thì hãy sử dụng append cho FormData để đấy thêm dữ liệu vào ajax (Nguyên nhân: khi bạn truyền dữ liệu bằng FormData trong jQuery, nó sẽ không tự động cập nhật nội dung được render bởi CKEditor vào giá trị thuộc tính value của phần tử <textarea>.
Điều này có nghĩa là dữ liệu mà CKEditor tạo ra không tự động xuất hiện trong giá trị của <textarea> khi bạn truyền dữ liệu bằng FormData. Để giải quyết vấn đề này, bạn cần thủ công cập nhật giá trị của <textarea> từ nội dung CKEditor trước khi gửi dữ liệu bằng FormData.)
