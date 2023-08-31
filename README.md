* Thiếu: </br>
- Mục: </br>
+ Chức năng xóa tất cả: Thiếu trang danh mục, sản phẩm, danh mục hình ảnh, tài khoản
+ Chưa làm phần nguyên liệu, công thức (chỉ mới ra danh sách)
+ Chưa làm nốt thêm chi tiết các nguyên liệu mới làm ra giao diện 
+ Chưa làm chức năng xóa cho phiếu hàng
- Còn lại: </br>
Xem lại cái chức năng xóa để tránh k bị lỗi dữ liệu
Còn chức năng Xóa nhiều và chọn nhiều chưa áp dụng cho tất cả các phần </br>
* Lưu ý: </br>
- Đối với việc sử dụng CKEditor, nếu bạn muốn render ra dữ liệu để gán vào html thì hãy sử dụng CKEDITOR.instances["tên class hoặc tên id"].setData();. Còn nếu bạn muốn lấy thì hãy sử dụng CKEDITOR.instances['tên class hoặc tên id'].getData() </br>
- Cùng với đó nếu sử dụng FormData kết hợp với CKEditor, thì hãy sử dụng append cho FormData để đấy thêm dữ liệu vào ajax (Nguyên nhân: khi bạn truyền dữ liệu bằng FormData trong jQuery, nó sẽ không tự động cập nhật nội dung được render bởi CKEditor vào giá trị thuộc tính value của phần tử <textarea>.
Điều này có nghĩa là dữ liệu mà CKEditor tạo ra không tự động xuất hiện trong giá trị của <textarea> khi bạn truyền dữ liệu bằng FormData. Để giải quyết vấn đề này, bạn cần thủ công cập nhật giá trị của <textarea> từ nội dung CKEditor trước khi gửi dữ liệu bằng FormData.)
- Có 2 cách xử lý ở trang "SỬA CHI TIẾU PHIẾU HÀNG (NẾU TỔNG SỐ LƯỢNG SỬA LỚN HƠN TỔNG SỐ LƯỢNG ĐÃ CÓ)"
C1:
if ($updateNote) {
    foreach ($list as $keyList => $one) {
        $found = false; // Đánh dấu để kiểm tra xem chi tiết đã tồn tại trong detailNote
        foreach ($detailNote as $keyDetail => $detail) {
            if ($keyList == $keyDetail) {
                $found = true; // Đánh dấu là đã tìm thấy chi tiết trong detailNote
                // Thực hiện cập nhật cho chi tiết tồn tại ở đây
                // ...
                break; // Kết thúc vòng lặp vì đã tìm thấy
            }
        }
        if (!$found) {
            // Thực hiện tạo mới cho chi tiết không tồn tại trong detailNote ở đây
            // ...
        }
    }
    // ...
} else {
    // ...
}
C2:
if ($updateNote) {
    foreach ($list as $keyList => $one) {
        // Kiểm tra nếu keyList tồn tại trong detailNote
        if (array_key_exists($keyList, $detailNote->toArray())) {
            // Update chi tiết đã tồn tại
            $detail = $detailNote[$keyList];
            $detail->id_unit = $one['id_unit'];
            $detail->name_ingredient = $one['name_ingredient'];
            $detail->quantity_ingredient = $one['quantity_ingredient'];
            $detail->price_ingredient = str_replace('.', '', $one['price_ingredient']);
            $updateDetailNote = $detail->save();
            if ($updateDetailNote) {
                $noti += ['res' => 'success'];
            } else {
                $noti += ['res' => 'warning'];
            }
        } else {
            // Tạo mới chi tiết chưa tồn tại
            $db = [
                'id_note' => $note->id_note,
                'code_note' => $data['code_note'],
                'id_unit' => $one['id_unit'],
                'name_ingredient' => $one['name_ingredient'],
                'quantity_ingredient' => $one['quantity_ingredient'],
                'price_ingredient' => str_replace('.', '', $one['price_ingredient']),
            ];
            $insert = DetailNote::create($db);
            if ($insert) {
                $noti += ['res' => 'success'];
            } else {
                $noti += ['res' => 'warning'];
            }
        }
    }
    // ... (xử lý thông báo thành công, thất bại)
} else {
    return response()->json(['res' => 'fail', 'icon' => 'error', 'title' => 'Sửa phiếu thất bại', 'status' => 'Lỗi truy vấn dữ liệu']);
}

