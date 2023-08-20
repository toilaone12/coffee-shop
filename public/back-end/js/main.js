function callAjax(url,method='GET',data,headers,success,error){
    $.ajax({
        method: method,
        url: url,
        headers: headers,
        data: data ? data : {},
        dataType: 'json',
        success: success,
        error: error
    })
}

function swalQuestion(html, callback){
    Swal.fire({
        title: '<p class="f-16">Bạn chắc chắn muốn xóa không?</p>',
        icon: 'warning',
        html: html,
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText:
            '<i class="fa-solid fa-check"></i> Có',
        confirmButtonAriaLabel: 'Đã xóa thành công!',
        cancelButtonText:
            '<i class="fa-solid fa-xmark"></i> Không',
        cancelButtonAriaLabel: 'Đã hủy bỏ'
    }).then((result) => {
        // console.log(arr);
        if(result.isConfirmed){
            callback(true);
        }else{
            callback(false);
        }
    });
}

function swalNotification(title,text,icon,callback){
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Xác nhận',
    }).then((res) => {
        if(res.isConfirmed){
            callback(true);
        }
    });
}

$(document).ready(function() {
    $('#myTable').DataTable({
        "responsive": true,
        // Các tùy chọn khác...
    }); // Thay #myTable bằng ID của bảng bạn muốn biến thành DataTable
    

    $('.supplier').each(function(key, value){
        $('.update-supplier-'+$(value).data('id')).click(function(key, val){
            let name = $('.name-'+$(value).data('id')).text();
            let phone = $('.phone-'+$(value).data('id')).text();
            let address = $('.address-'+$(value).data('id')).text();
            $('.name-update').val(name);
            $('.phone-update').val(phone);
            $('.address-update').val(address);
            $('.update-supplier').attr('data-id',$(value).data('id'))
        })
    })
});