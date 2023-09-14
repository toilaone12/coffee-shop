* Thiếu: </br>
- Mục: </br>
+ Mới lại giao diện tĩnh chưa thêm dữ liệu
- Còn lại: </br>
Xem lại cái chức năng xóa để tránh k bị lỗi dữ liệu
Còn chức năng Xóa nhiều và chọn nhiều chưa áp dụng cho tất cả các phần </br>
* Lưu ý: </br>
- Đối với việc sử dụng CKEditor, nếu bạn muốn render ra dữ liệu để gán vào html thì hãy sử dụng CKEDITOR.instances["tên class hoặc tên id"].setData();. Còn nếu bạn muốn lấy thì hãy sử dụng CKEDITOR.instances['tên class hoặc tên id'].getData() </br>
- Cùng với đó nếu sử dụng FormData kết hợp với CKEditor, thì hãy sử dụng append cho FormData để đấy thêm dữ liệu vào ajax (Nguyên nhân: khi bạn truyền dữ liệu bằng FormData trong jQuery, nó sẽ không tự động cập nhật nội dung được render bởi CKEditor vào giá trị thuộc tính value của phần tử <textarea>.
Điều này có nghĩa là dữ liệu mà CKEditor tạo ra không tự động xuất hiện trong giá trị của <textarea> khi bạn truyền dữ liệu bằng FormData. Để giải quyết vấn đề này, bạn cần thủ công cập nhật giá trị của <textarea> từ nội dung CKEditor trước khi gửi dữ liệu bằng FormData.)</br>
- Có 2 cách xử lý ở trang "SỬA CHI TIẾU PHIẾU HÀNG (NẾU TỔNG SỐ LƯỢNG SỬA LỚN HƠN TỔNG SỐ LƯỢNG ĐÃ CÓ)"</br>
C1: </br>
if ($updateNote) {</br>
    foreach ($list as $keyList => $one) {</br>
        $found = false; // Đánh dấu để kiểm tra xem chi tiết đã tồn tại trong detailNote</br>
        foreach ($detailNote as $keyDetail => $detail) {</br>
            if ($keyList == $keyDetail) {</br>
                $found = true; // Đánh dấu là đã tìm thấy chi tiết trong detailNote</br>
                // Thực hiện cập nhật cho chi tiết tồn tại ở đây</br>
                // ...</br>
                break; // Kết thúc vòng lặp vì đã tìm thấy</br>
            }</br>
        }</br>
        if (!$found) {</br>
            // Thực hiện tạo mới cho chi tiết không tồn tại trong detailNote ở đây</br>
            // ...</br>
        }</br>
    }</br>
    // ...</br>
} else {</br>
    // ...</br>
}</br>
C2:</br>
if ($updateNote) {</br>
    foreach ($list as $keyList => $one) {</br>
        // Kiểm tra nếu keyList tồn tại trong detailNote</br>
        if (array_key_exists($keyList, $detailNote->toArray())) {</br>
            // Update chi tiết đã tồn tại</br>
            $detail = $detailNote[$keyList];</br>
            $detail->id_unit = $one['id_unit'];</br>
            $detail->name_ingredient = $one['name_ingredient'];</br>
            $detail->quantity_ingredient = $one['quantity_ingredient'];</br>
            $detail->price_ingredient = str_replace('.', '', $one['price_ingredient']);</br>
            $updateDetailNote = $detail->save();</br>
            if ($updateDetailNote) {</br>
                $noti += ['res' => 'success'];</br>
            } else {</br>
                $noti += ['res' => 'warning'];</br>
            }</br>
        } else {</br>
            // Tạo mới chi tiết chưa tồn tại</br>
            $db = [</br>
                'id_note' => $note->id_note,</br>
                'code_note' => $data['code_note'],</br>
                'id_unit' => $one['id_unit'],</br>
                'name_ingredient' => $one['name_ingredient'],</br>
                'quantity_ingredient' => $one['quantity_ingredient'],</br>
                'price_ingredient' => str_replace('.', '', $one['price_ingredient']),</br>
            ];</br>
            $insert = DetailNote::create($db);</br>
            if ($insert) {</br>
                $noti += ['res' => 'success'];</br>
            } else {</br>
                $noti += ['res' => 'warning'];</br>
            }</br>
        }</br>
    }</br>
    // ... (xử lý thông báo thành công, thất bại)</br>
} else {</br>
    return response()->json(['res' => 'fail', 'icon' => 'error', 'title' => 'Sửa phiếu thất bại', 'status' => 'Lỗi truy vấn dữ liệu']);</br>
}</br>

