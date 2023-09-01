function callAjax(url,method,data,headers,success,error,isFormData = 0){
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
//xu ly sua danh muc anh san pham
function handleUpdateGalleryClick(){
    let idGallery = $(this).data('gallery');
    let formData = new FormData();
    let method = "POST";
    let headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    let fileInput = $('#file-' + idGallery)[0];
    let imageOriginal = $('.image-original-'+idGallery).data('name').replace('storage/gallery/','');
    if (fileInput.files.length > 0) {
        let file = fileInput.files[0];
        formData.append('id_gallery', idGallery);
        formData.append('image_gallery', file, file.name);
        formData.append('image_original_gallery',imageOriginal)
        callAjax(routeUpdateGallery,method,formData,headers,
            function(data){
                let title = 'Cập nhật dữ liệu danh mục ảnh';
                let text = '';
                let icon = '';
                if(data.res === 'success'){
                    icon = 'success';
                    text = data.status;
                }else if(data.res === 'warning'){
                    icon = 'warning';
                    text = data.status.image_gallery;
                }else{
                    icon = 'error';
                    text = data.status;
                }
                swalNotification(title,text,icon,function(callback){
                    if(callback){
                        location.reload();
                    }
                })
            },  
            function(err){
                console.log(err);
            }
        ,1);
    }
}
//xu ly sua chuc vu
function handleUpdateRoleClick(){
    let id = $(this).data('id');
    let name = $('.name-' + id).text();
    $('.name-update').val(name);
    $('.update-role').attr('data-id', id);
}
//xu ly sua chuc vu
function handleUpdateUnitClick(){
    let id = $(this).data('id');
    let fullname = $('.fullname-' + id).text();
    let abbreviation = $('.abbreviation-' + id).text();
    $('.fullname-update').val(fullname);
    $('.abbreviation-update').val(abbreviation);
    $('.update-unit').attr('data-id', id);
}
//xu ly phan hien danh sach chi tiet phieu
function listDetailNote(data){
    let html = '<div class="row">';
    let selectOptions = '';
    listUnit.forEach(unit => {
        selectOptions += `<option value="${unit.id_unit}">${unit.fullname_unit}</option>`;
    });
    for (let i = 0; i < parseInt(data.quantity_note); i++){
        html += `<div class="col-lg-4 border-success form-detail-note border-right border-bottom pt-3 ${i%3 == 0 ? 'border-left' : ''} ${i < 3 ? 'border-top' : ''}">`;
        html += `<div class="form-group">`;
        html += `<label for="name">Tên nguyên liệu</label>`;
        html += `<input type="text" name="name_ingredients" id="name" class="form-control name-ingredients-insert">`;
        html += `<span class="text-danger error-name"></span>`
        html += `</div>`;
        html += `<div class="form-group">`;
        html += `<label for="id">Đơn vị tính</label>`;
        html += `<select name="id_unit" id="id" class="id-unit-insert form-control">`;
        html += selectOptions;
        html += `</select>`;
        html += `</div>`;
        html += `<div class="form-group">`;
        html += `<label for="quantity">Số lượng</label>`;
        html += `<input type="number" min=1 name="quantity_ingredients" id="quantity" class="form-control quantity-ingredients-insert">`;
        html += `<span class="text-danger error-quantity"></span>`
        html += `</div>`;
        html += `<div class="form-group">`;
        html += `<label for="price">Giá thành (Trên 1 đơn vị)</label>`;
        html += `<input type="phone" min=1 name="price_ingredients" id="price" class="form-control price-autonumeric price-ingredients-insert">`;
        html += `<span class="text-danger error-price"></span>`
        html += `</div>`;
        html += `</div>`;
    }
    html += '</div>';
    $('.list-detail-note').attr('data-count',data.quantity_note)
    .attr('data-code',data.code_note)
    .attr('data-id',data.id_supplier)
    .html(html);
    $('.code-detail-note').text(data.code_note);
    $('.price-autonumeric').each(function () {
        new AutoNumeric(this, {
            digitGroupSeparator: '.',
            decimalCharacter: ',',
            decimalPlaces: 0, // Điều chỉnh số lượng chữ số thập phân theo nhu cầu
            minimumValue: '0',
            allowDecimalPadding: true // Giữ nguyên giá trị này
        });
    });
}
function listUpdateDetailNote(data){
    let html = '<div class="row">';
    
    for (let i = 0; i < parseInt(data.quantity_note); i++){
        let selectOptions = '';
        let name = data.list.length > i ? data.list[i].name_ingredient : ''
        let quantity = data.list.length > i ? data.list[i].quantity_ingredient : ''
        let price = data.list.length > i ? data.list[i].price_ingredient : ''
        let id = data.list.length > i ? data.list[i].id_unit : 0
        listUnit.forEach(unit => {
            selectOptions += `<option value="${unit.id_unit}" ${unit.id_unit === id ? 'selected' : ''}>${unit.fullname_unit}</option>`;
        });
        html += `<div class="col-lg-4 border-success form-update-detail-note border-right border-bottom pt-3 ${i%3 == 0 ? 'border-left' : ''} ${i < 3 ? 'border-top' : ''}">`;
        html += `<div class="form-group">`;
        html += `<label for="name">Tên nguyên liệu</label>`;
        html += `<input type="text" name="name_ingredients" id="name" value="${name}" class="form-control name-ingredients-update">`;
        html += `<span class="text-danger error-name"></span>`
        html += `</div>`;
        html += `<div class="form-group">`;
        html += `<label for="id">Đơn vị tính</label>`;
        html += `<select name="id_unit" id="id" class="id-unit-update form-control">`;
        html += selectOptions;
        html += `</select>`;
        html += `</div>`;
        html += `<div class="form-group">`;
        html += `<label for="quantity">Số lượng</label>`;
        html += `<input type="number" min=1 name="quantity_ingredients" id="quantity" value="${quantity}" class="form-control quantity-ingredients-update">`;
        html += `<span class="text-danger error-quantity"></span>`
        html += `</div>`;
        html += `<div class="form-group">`;
        html += `<label for="price">Giá thành (Trên 1 đơn vị)</label>`;
        html += `<input type="phone" min=1 name="price_ingredients" id="price" value="${price}" class="form-control price-autonumeric price-ingredients-update">`;
        html += `<span class="text-danger error-price"></span>`
        html += `</div>`;
        html += `</div>`;
    }
    html += '</div>';
    $('.list-update-detail-note').attr('data-count',data.quantity_note)
    .attr('data-code',data.code_note)
    .attr('data-id',data.id_supplier)
    .html(html);
    $('.code-detail-note').text(data.code_note);
    $('.price-autonumeric').each(function () {
        new AutoNumeric(this, {
            digitGroupSeparator: '.',
            decimalCharacter: ',',
            decimalPlaces: 0, // Điều chỉnh số lượng chữ số thập phân theo nhu cầu
            minimumValue: '0',
            allowDecimalPadding: true // Giữ nguyên giá trị này
        });
    });
}
//xu ly phan sua phieu hang
function handleUpdateNoteClick(){
    let id = $(this).data('id');
    let idSupplier = $('.id-supplier-' + id).data('id');
    let name = $('.name-' + id).text();
    let quantity = $('.quantity-' + id).text();
    let selectOptions = '';
    listSupplier.forEach(supplier => {
        selectOptions += `<option value="${supplier.id_supplier}" ${supplier.id_supplier === idSupplier ? 'selected' : ''}>${supplier.name_supplier}</option>`;
    });
    $('.name-update').val(name);
    $('.quantity-update').val(quantity);
    $('.id-supplier-update').html(selectOptions);
    $('.update-note').attr('data-id', id);
}


