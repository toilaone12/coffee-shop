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

function swalNotiWithHTML(title, html, icon, callback) {
    Swal.fire({
        icon: icon, // Biểu tượng của thông báo
        title: title,
        html: html, // Nội dung HTML
        showCloseButton: true,
        confirmButtonText: 'Xác nhận',
    }).then((res) => {
        if (res.isConfirmed) {
            callback(true);
        }
    });
}

function formatDateToISO(dateString) {
    const parts = dateString.split(' ');
    const dateParts = parts[0].split('/');
    const timeParts = parts[1].split(':');

    const year = dateParts[2];
    const month = dateParts[1];
    const day = dateParts[0];
    const hours = timeParts[0];
    const minutes = timeParts[1];

    return `${year}-${month}-${day}T${hours}:${minutes}`;
}

function createChart(array, label, id){
    $('#myAreaChart').remove();
    var arrName = [];
    var arrQuantity = [];
    array.forEach(one => {
        arrName.push(one.name);
        arrQuantity.push(one.quantity);
    });
    // console.log(arrQuantity);
    var data = {
        labels: arrName, // truc x
        datasets: [{
            label: label,
            data: arrQuantity,
            backgroundColor: 'rgba(75, 192, 192, 0.2)', // Màu nền của khu vực
            borderColor: 'rgba(75, 192, 192, 1)', // Màu viền
            borderWidth: 1
        }]
    };

    // Lấy thẻ canvas từ HTML
    $('.order-chart').html(`<canvas id="${id}" height="200"></canvas>`)
    var ctx = document.getElementById(id).getContext('2d');

    // Tạo biểu đồ
    var myAreaChart = new Chart(ctx, {
        type: 'line', // Loại biểu đồ là khu vực
        data: data,
        options: {
            responsive: true, // Cho phép biểu đồ thích ứng với kích thước container
            maintainAspectRatio: false, // Vô hiệu hóa tỷ lệ giữa chiều rộng và chiều cao
            indexAxis: 'x', // Chỉ định chiều cao cố định cho trục y
            layout: {
                padding: {
                    top: 0,
                    bottom: 0
                }
            },
            aspectRatio: 2, // Tỷ lệ chiều rộng và chiều cao (tùy chọn)
            plugins: {
                legend: {
                    display: false // Tắt hiển thị chú thích (tùy chọn)
                }
            },
            elements: {
                line: {
                    borderWidth: 2 // Định dạng độ dày của đường biểu đồ (tùy chọn)
                }
            },
            scales: {
                y: {
                    ticks: {
                        beginAtZero: true,
                        precision: 0 // Định dạng số nguyên
                    }
                }
            }
        }
    });

}

//chon mot item
function handleChooseOneItem(){
    let arrId = [];
    $('input[type="checkbox"]:checked').each(function(k,v){
        let id = parseInt($(this).val());
        arrId.push({id: id});
    })
    if(arrId.length >= 2){
        $('.delete-all').removeClass('disabled').removeAttr('disabled')
    }else{
        $('.delete-all').addClass('disabled').attr('disabled','disabled')
    }
}
//chon tat ca item
function handleAllItemsInPage(){
    var checkboxes = $('input[type="checkbox"]');
    var countChecked = 0;

    checkboxes.each(function(index, element) {
        if (countChecked < 10) {
            if (!$(element).prop('checked')) {
                $(element).prop('checked', true);
                countChecked++;
            } else {
                $(element).prop('checked', false);
                countChecked--;
            }
        } else {
            $(element).prop('checked', false);
        }
    });
    if (countChecked >= 2) {
        $('.delete-all').removeClass('disabled').removeAttr('disabled');
    } else {
        $('.delete-all').addClass('disabled').attr('disabled', 'disabled');
    }
}

//xu ly sua chuc vu
function handleUpdateRoleClick(){
    let id = $(this).data('id');
    let name = $('.name-' + id).text();
    $('.name-update').val(name);
    $('.update-role').attr('data-id', id);
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
//xu ly sua don vi
function handleUpdateUnitClick(){
    let id = $(this).data('id');
    let fullname = $('.fullname-' + id).text();
    let abbreviation = $('.abbreviation-' + id).text();
    $('.fullname-update').val(fullname);
    $('.abbreviation-update').val(abbreviation);
    $('.update-unit').attr('data-id', id);
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
    let isSpecial = $('.is-special-' + id).data('special');
    let selectOptions = '';
    let specialOptions = `<option value="">---Lựa chọn---</option>`;
    specialOptions += `<option value="0" ${!isSpecial && 'selected'}>Không</option>`;
    specialOptions += `<option value="1" ${isSpecial && 'selected'}>Có</option>`;
    listCate.forEach(parent => {
        if(parent.id_parent_category == 0){
            selectOptions += `<optgroup label="${parent.name_category}">`
            listCate.forEach(child => {
                if(child.id_parent_category != 0 && child.id_parent_category == parent.id_category){
                    selectOptions += `<option value="${child.id_category}" ${child.id_category === idCategory ? 'selected' : ''}>⊢–${child.name_category}</option>`;
                }
            });
            selectOptions += `</optgroup>`
        }
    });
    $('.id-product').val(id);
    $('.image-update').attr('src',image);
    $('.image-original').val(imageOriginal.replace('storage/product/',''));
    $('.name-update').val(name);
    $('.subname-update').val(subname);
    $('.quantity-update').val(quantity);
    $('.price-update').val(price);
    $('.id-category-update').html(selectOptions);
    $('.is-special-update').html(specialOptions);
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
//xu ly phan sua nguyen lieu
function handleUpdateIngredientClick(){
    let id = $(this).data('id');
    let idUnit = $('.id-' + id).data('id');
    let name = $('.name-' + id).text();
    let selectOptions = '';
    listUnits.forEach(unit => {
        selectOptions += `<option value="${unit.id_unit}" ${unit.id_unit === idUnit ? 'selected' : ''}>${unit.fullname_unit}</option>`;
    });
    $('.name-update').val(name);
    $('.id-unit-update').html(selectOptions);
    $('.id-ingredient').val(id);
}
//xu ly phan them thanh phan nguyen lieu (ca trang sua)
function handleInsertComponentRecipe(isUpdate=0){
    let optionUnit = '';
    let optionIngredient = '';
    listUnits.forEach(unit => {
        optionUnit += `<option value="${unit.id_unit}">${unit.fullname_unit}</option>`;
    });
    listIngredients.forEach(ingredient => {
        optionIngredient += `<option value="${ingredient.id_ingredient}">${ingredient.name_ingredient}</option>`;
    });
    let html = `<div class="col-lg-4 ${isUpdate ? 'one-update-component' : 'one-component'}">`;
    html += `<div class="form-group">`;
    html += `<label for="ingredient">Tên nguyên liệu</label>`;
    html += `<select name="id_ingredient" id="ingredient" class="id-ingredient-${isUpdate ? 'update' : 'insert'} form-control">`;
    html += optionIngredient;
    html += `</select>`;
    html += `</div>`;
    html += `<div class="form-group">`;
    html += `<label for="unit">Đơn vị tính</label>`;
    html += `<select name="id_unit" id="unit" class="id-unit-${isUpdate ? 'update' : 'insert'} form-control">`;
    html += optionUnit;
    html += `</select>`;
    html += `</div>`;
    html += '<div class="form-group">';
    html += '<label for="quantity">Số lượng cần</label>'
    html += `<input type="number" min=1 name="quantity_recipe_need" id="quantity" class="form-control quantity-${isUpdate ? 'update' : 'insert'}">`
    html += '<span class="text-danger error-quantity"></span>'
    html += '</div>'
    html += '</div>';
    if(isUpdate){
        $('.form-update-component-recipe').append(html);
    }else{
        $('.form-component-recipe').append(html);
    }
}
//xu ly sua quang cao
function handleUpdateSlideClick() {
    let id = $(this).data('id');
    let image = $('.image-'+id).attr('src');
    let nameImage = $('.image-'+id).attr('data-name');
    let name = $('.name-'+id).text();
    let slug = $('.slug-'+id).text();
    $('.image-update').attr('src',image);
    $('.image-original').val(nameImage.replace('storage/slide/',''));
    $('.id-slide').val(id);
    $('.name-update').val(name);
    $('.slug-update').val(slug);
}
//xu ly phan sua ma giam gia
function handleUpdateCouponClick(){
    let id = $(this).data('id');
    let name = $('.name-' + id).text().trim();
    let code = $('.code-' + id).text().trim();
    let quantity = $('.quantity-' + id).text().trim();
    let discount = $('.discount-' + id).data('discount');
    let type = $('.type-' + id).data('type');
    let isBuy = $('.is-buy-' + id).text().trim();
    let isPrice = $('.is-price-' + id).text().trim();
    let time = $('.time-' + id).text().trim();
    let optionType = '';
    let arrayType = [
        {'id': 0, 'name': 'Theo phần trăm'},
        {'id': 1, 'name': 'Theo giá tiền'}
    ];
    for(let i = 0; i < arrayType.length; i++){
        optionType += `<option value="${arrayType[i].id}" ${arrayType[i].id === type ? 'selected' : ''}>${arrayType[i].name}</option>`
    }
    $('.id-coupon').val(id);
    $('.name-update').val(name);
    $('.code-update').val(code);
    $('.quantity-update').val(quantity);
    $('.discount-update').val(discount);
    $('.is-buy-update').val(isBuy);
    $('.is-price-update').val(isPrice);
    $('.time-update').val(formatDateToISO(time));
    $('.type-update').html(optionType);
}
//xu ly phan sua phuong thuc thanh toan
function handleUpdateFeeClick(){
    let id = $(this).data('id');
    let radius = $('.radius-' + id).text().replace(' km','');
    let weather = $('.weather-' + id).text();
    let fee = $('.fee-' + id).text().replace(/[.,đ]/g, '');;
    let arrayWeather = [
        {'id': 'Sun', 'weather': 'Nắng'},
        {'id': 'Rain', 'weather': 'Mưa'}
    ];
    let html = '';
    for(let i = 0; i < arrayWeather.length; i++){
        html += `<option value="${arrayWeather[i].id}" ${arrayWeather[i].id === weather ? 'selected' : ''}>${arrayWeather[i].weather}</option>`
    }
    $('.radius-update').val(radius);
    $('.weather-update').html(html);
    $('.fee-update').val(fee);
    $('.id-fee').val(id);
    $('.radius-fee').text(radius);
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
//xu ly phan hien sua danh sach chi tiet phieu
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
    $('.quantity-update').attr('min',quantity);
    $('.id-supplier-update').html(selectOptions);
    $('.update-note').attr('data-id', id);
}
//xu ly phan sua cong thuc
function handleUpdateRecipeClick(){
    let id = $(this).data('id');
    let idProduct = $('.id-product-' + id).data('id');
    let count = $('.component-'+id).data('count');
    let optionProduct = '';
    let html = '';
    listProducts.forEach(product => {
        optionProduct += `<option value="${product.id_product}" ${product.id_product === idProduct ? 'selected' : ''}>${product.name_product}</option>`;
    })
    $('.id-product-recipe').html(optionProduct);
    for(let i = 0; i < parseInt(count); i++){
        //id: la ma cong thuc, i: la key trong vong lap cong thuc
        let optionUnit = '';
        let optionIngredient = '';
        let quantityRecipe = '';
        let idIngredient = $('.id-ingredient-'+id+'-'+i).data('id'); 
        let idUnit = $('.id-unit-'+id+'-'+i).data('id');
        if($('tr').hasClass('child')){
            quantityRecipe = $('.child').find('.quantity-recipe-'+id+'-'+i).text();
        }else{
            quantityRecipe = $('.quantity-recipe-'+id+'-'+i).text();
        }
        listUnits.forEach(unit => {
            optionUnit += `<option value="${unit.id_unit}" ${unit.id_unit === idUnit ? 'selected' : ''}>${unit.fullname_unit}</option>`;
        });
        listIngredients.forEach(ingredient => {
            optionIngredient += `<option value="${ingredient.id_ingredient}" ${ingredient.id_ingredient === idIngredient ? 'selected' : ''}>${ingredient.name_ingredient}</option>`;
        });
        html += `<div class="col-lg-4 one-update-component">`;
        html += `<div class="form-group">`;
        html += `<label for="ingredient">Tên nguyên liệu</label>`;
        html += `<select name="id_ingredient" id="ingredient" class="id-ingredient-update form-control">`;
        html += optionIngredient;
        html += `</select>`;
        html += `</div>`;
        html += `<div class="form-group">`;
        html += `<label for="unit">Đơn vị tính</label>`;
        html += `<select name="id_unit" id="unit" class="id-unit-update form-control">`;
        html += optionUnit;
        html += `</select>`;
        html += `</div>`;
        html += `<div class="form-group">`;
        html += `<label for="quantity">Số lượng cần</label>`
        html += `<input type="number" min=1 name="quantity_recipe_need" id="quantity" value="${quantityRecipe}" class="form-control quantity-update">`
        html +=` <span class="text-danger error-quantity"></span>`
        html += `</div>`
        html += `</div>`;
    }
    $('.form-update-component-recipe').html(html);
    $('.id-recipe').val(id);
}

//xu ly tin tuc
function handleUpdateNewClick() {
    let id = $(this).data('id');
    let image = $('.image-'+id).attr('src');
    let nameImage = $('.image-'+id).attr('data-name');
    let title = $('.title-'+id).text();
    let subtitle = $('.subtitle-'+id).text();
    let content = $('.content-'+id).text();
    $('.id-new').val(id);
    $('.image-update').attr('src',image);
    $('.image-original').val(nameImage.replace('storage/news/',''));
    $('.title-update').val(title);
    $('.subtitle-update').val(subtitle);
    CKEDITOR.instances['ckeditor'].setData(content);
}
//form phan hoi
function formReply(){
    let arrayReply = [
        {id: 0, name: 'Thành thật xin lỗi vì điều đó'},
        {id: 1, name: 'Cảm ơn vì đã ủng hộ'},
        {id: 2, name: 'Mong bạn ủng hộ nhiều'},
    ]
    let replyButtons = $('.form-reply');
    let nameInput = $('.reply');
    let buttonsHtml = '';
    arrayReply.forEach(reply => {
        buttonsHtml += `<button type="button" class="btn rating-button fs-14 rounded small">${reply.name}</button>`;
    });
    replyButtons.html(buttonsHtml);
    replyButtons.find('button').click(function() {
        let replyName = $(this).text();
        nameInput.val(replyName);
    });
}
//xu ly phan hoi
function handleReplyReview(){
    formReply();
    let id = $(this).data('id');
    let name = $('.name-'+id).text();
    $('.id-reply').val(id)
    $('.name-review').text(name)
}

function handleUpdateReview(){
    formReply();
    let id = $(this).data('id');
    let idReply = $(this).data('reply');
    let name = $('.name-'+id).text();
    let review = $('.reply-admin-'+id).text();
    $('.id-reply').val(idReply)
    $('.review-update').val(review)
    $('.name-review').text(name)
}

//firebase
function sendTokenToServer(token) {
    console.log(isTokenToServer());
    if(!isTokenToServer()){
        setTokenSentToServer(true);
        console.log('Sending token to server');
    }else{
        console.log('Token is already');
    }
}

function isTokenToServer(){
    return window.localStorage.getItem('sentToServer') === '1'
}

function setTokenSentToServer(sent){
    window.localStorage.setItem('sentToServer', sent ? 1 : 0)
}

function formNotification(list, page, count){
    let html = '';
    list.forEach(one => {
        let formattedDate = moment(one.created_at).format('DD/MM/YYYY');
        html += `<div class="border-bottom px-2 pt-2 choose-notification cursor-pointer" data-id="{{$noti->id_notification}}">`;
        html += `<a href="${one.link}" class="text-decoration-none">`;
        html += `<div class="d-flex align-item-center justify-content-between mb-1">`;
        html += `<span class="fs-12 d-block text-secondary">${formattedDate}</span>`;
        if(one.is_read == 0) html += `<i class="fa-solid fa-circle text-danger fs-10 dot-notification"></i>`;
        html += `</div>`;
        html += `<p class="fs-15 text-dark">${one.content}</p>`;
        html += `</a>`;
        html += `</div>`;    
    })
    if(count == 7){
        html += `<span class="text-center fs-15 d-block mt-2 load-more-notification cursor-pointer" data-page="${page}"><i class="fa-solid fa-angle-down"></i> Xem thêm</span>`
    }
    $('.notification').append(html);
}