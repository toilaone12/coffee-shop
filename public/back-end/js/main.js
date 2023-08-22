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

    $('.category').each(function(key, value){
        $('.update-category-'+$(value).data('id')).click(function(key, val){
            let name = $('.name-'+$(value).data('id')).text();
            let idParent = $('.id-parent-'+$(value).data('id')).data('id');
            let selectOptions = '';
            selectOptions += `<option value="0" ${idParent === 0 ? 'selected' : ''}>Danh mục gốc</option>`
            listParent.forEach(category => {
                selectOptions += `<option value="${category.id_category}" ${category.id_category === idParent ? 'selected' : ''}>${category.name_category}</option>`;
            });
            $('.name-update').val(name);
            $('.id-parent-update').html(selectOptions);
            $('.update-category').attr('data-id',$(value).data('id'))
        })
    })

    $('.change-image').change(function(){
        let fileName = $(this).val().split('\\').pop();
        $('.imagePath').text(fileName);
    })

    $('.slide').each(function(key, value){
        $('.update-slide-'+$(value).data('id')).click(function(key, val){
            let image = $('.image-'+$(value).data('id')).attr('src');;
            let name = $('.name-'+$(value).data('id')).text();
            let slug = $('.slug-'+$(value).data('id')).text();
            $('.image-update').attr('src',image);
            $('.name-update').val(name);
            $('.slug-update').val(slug);
            $('.update-slide').attr('data-id',$(value).data('id'))
        })
    })
});