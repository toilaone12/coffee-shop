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
//xu ly sua danh muc
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
//xu ly sua quang cao
function handleUpdateSlideClick() {
    let id = $(this).data('id');
    let image = $('.image-'+id).attr('src');
    let nameImage = $('.image-'+id).attr('data-name');
    let name = $('.name-'+id).text();
    let slug = $('.slug-'+id).text();
    $('.image-update').attr('src',image);
    $('.image-original').val(nameImage.replace('storage/',''));
    $('.id-slide').val(id);
    $('.name-update').val(name);
    $('.slug-update').val(slug);
}
//xu ly sua nha cung cap
function handleUpdateSupplierClick() {
    let id = $(this).data('id');
    let name = $('.name-'+id).text();
    let phone = $('.phone-'+id).text();
    let address = $('.address-'+id).text();
    $('.name-update').val(name);
    $('.phone-update').val(phone);
    $('.address-update').val(address);
    $('.update-supplier').attr('data-id',id)
}
//xu ly sua san pham
function handleUpdateProductClick() {
    let id = $(this).data('id');
    let idCategory = $('.id-category-' + id).data('id');
    let name = $('.name-' + id).text();
    let image = $('.image-'+id).attr('src');
    let imageOriginal = $('.image-'+id).attr('data-name');
    let subname = $('.subname-' + id).text();
    let quantity = $('.quantity-' + id).text();
    let price = $('.price-' + id).text();
    let description = $('.description-' + id).text();
    let selectOptions = '';
    listCate.forEach(category => {
        selectOptions += `<option value="${category.id_category}" ${category.id_category === idCategory ? 'selected' : ''}>${category.name_category}</option>`;
    });
    $('.id-product').val(id);
    $('.image-update').attr('src',image);
    $('.image-original').val(imageOriginal.replace('storage/product/',''));
    $('.name-update').val(name);
    $('.subname-update').val(subname);
    $('.quantity-update').val(quantity);
    $('.price-update').val(price);
    $('.id-category-update').html(selectOptions);
    $('.update-category').attr('data-id', id);
    CKEDITOR.instances['ckeditor'].setData(description); // set noi dung tren Ckeditor
}
//xu ly danh muc anh san pham
function handleUpdateGalleryClick(){
    let idGallery = $(this).data('gallery');
    let formData = new FormData();
    let method = "POST";
    let headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    let fileInput = $('#file-' + idGallery)[0];
    console.log(fileInput.files.length);
    if (fileInput.files.length > 0) {
        let file = fileInput.files[0];
        formData.append('id_gallery', idGallery);
        formData.append('image_gallery', file, file.name);
        callAjax(routeUpdateGallery,method,formData,headers,
            function(data){
                console.log(data);
                // if (data.res === 'success' || data.res === 'error') {
                //     $('.message-product').text(data.status);
                //     if ($('.error-image').text() != '' || $('.error-name').text() != '' || $('.error-subname').text() != ''
                //     || $('.error-quantity').text() != '' || $('.error-price').text() != '') {
                //         $('.error-name').text('');
                //         $('.error-image').text('');
                //         $('.error-subname').text('');
                //         $('.error-quantity').text('');
                //         $('.error-price').text('');
                //     }
                // } else if (data.res === 'warning') {
                //     $('.error-image').text(data.status.image_product ? data.status.image_product : '');
                //     $('.error-name').text(data.status.name_product ? data.status.name_product : '');
                //     $('.error-subname').text(data.status.subname_product ? data.status.subname_product : '');
                //     $('.error-quantity').text(data.status.quantity_product ? data.status.quantity_product : '');
                //     $('.error-price').text(data.status.price_product ? data.status.price_product : '');
                // }
            },  
            function(err){
                console.log(err);
            }
        ,1);
    }
}

