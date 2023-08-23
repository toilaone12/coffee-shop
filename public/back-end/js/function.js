function callAjax(url,method='GET',data,headers,success,error,isFormData = 0){
    $.ajax({
        method: method,
        url: url,
        headers: headers,
        data: data ? data : {},
        processData: isFormData ? false : true,
        contentType: isFormData ? false : 'application/x-www-form-urlencoded',
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

function handleUpdateCategoryClick() {
    let id = $(this).data('id');
    let name = $('.name-' + id).text();
    let idParent = $('.id-parent-' + id).data('id');
    
    let selectOptions = `<option value="0" ${idParent === 0 ? 'selected' : ''}>Danh mục gốc</option>`;
    listParent.forEach(category => {
        selectOptions += `<option value="${category.id_category}" ${category.id_category === idParent ? 'selected' : ''}>${category.name_category}</option>`;
    });
    
    $('.name-update').val(name);
    $('.id-parent-update').html(selectOptions);
    $('.update-category').attr('data-id', id);
}
