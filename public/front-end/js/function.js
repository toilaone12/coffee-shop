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

function handleBuyProduct(){
    let id = $(this).data('id');
    let image = $('.image-'+id).data('image');
    let name = $('.name-'+id).text();
    let price = $('.price-'+id+' > span').text().replace('.','');
    let priceFormatted = parseInt(price.replace(' đ','')).toLocaleString('vi-VN', { currency: 'VND' });
    let html = '';
    html += `<img class="card-img-top p-3 image-product" src="${image}" alt="Card image cap">`;
    html += `<div class="card-body">`;
    html += `<input type="hidden" class="id-product" value="${id}">`;
    html += `<h5 class="card-title text-dark font-weight-bold fs-18 name-product">${name}</h5>`;
    html += `<div class="mb-2 d-flex">`;
    html += `<p class="text-dark mr-2 fs-16">Giá thành: </p>`;
    html += `<p class="card-text text-dark fs-16 price-modal price-product" data-price=${price}>${priceFormatted} đ</p>`;
    html += `</div>`;
    html += `<div class="input-group mb-3">`;
    html += `<span class="input-group-btn">`;
    html += `<button type="button" class="btn btn-secondary btn-number" data-type="plus">`;
    html += `<div class="plus-icon"></div>`;
    html += `</button>`;
    html += `</span>`;
    html += `<input type="text" id="quantity" name="quantity" class="input-number quantity-product" value="1" min="1" max="99">`;
    html += `<span class="input-group-btn">`;
    html += `<button type="button" class="btn btn-secondary btn-number" data-type="minus">`;
    html += `<div class="minus-icon"></div>`;
    html += `</button>`;
    html += `</span>`;
    html += `</div>`;
    html += `<div class="form-group">`;
    html += `<label for="exampleFormControlTextarea1" class="font-weight-bold text-dark">Ghi chú</label>`;
    html += `<textarea class="d-block w-100 border-secondary rounded note-product" id="exampleFormControlTextarea1" rows="3"></textarea>`;
    html += `</div>`;
    html += `<div class="d-flex justify-content-between">`;
    html += `<button type="button" class="btn btn-danger btn-outline-danger fs-13" id="add-waiting-cart">Thêm vào giỏ hàng</button>`;
    html += `<a href="#" class="btn btn-primary btn-outline-primary">Đặt hàng</a>`;
    html += `</div>`;
    html += `</div>`;
    $('.product-modal').html(html);
    //cong tru san pham
    handleClickQuantity();
}

function handleClickQuantity(){
    $('.btn-number').click(function(){
        let type = $(this).data('type');
        let quantity = $('.input-number').val();
        let price = $('.price-modal').text().replace(' đ','').replace('.','');
        let priceOriginal = $('.price-modal').data('price');
        if(type === 'minus'){
            if(quantity <= 1){
                $('.input-number').val(1)
                $('.price-modal').text(parseInt(priceOriginal).toLocaleString('vi-VN', { currency: 'VND' }) + ' đ');
            }else{
                let minus = parseInt(quantity) - 1;
                $('.input-number').val(minus);
                $('.price-modal').text((parseInt(price) - parseInt(priceOriginal)).toLocaleString('vi-VN', { currency: 'VND' }) + ' đ');
            }
        }else if(type === 'plus'){
            if(quantity > 99){
                $('.input-number').val(99)
                $('.price-modal').text(parseInt(priceOriginal * 99).toLocaleString('vi-VN', { currency: 'VND' }) + ' đ');
            }else{
                let plus = parseInt(quantity) + 1;
                $('.input-number').val(plus);
                $('.price-modal').text((parseInt(price) + parseInt(priceOriginal)).toLocaleString('vi-VN', { currency: 'VND' }) + ' đ');
            }
        }
    })
    $('.input-number').change(function(){
        let quantity = $(this).val();
        let priceOriginal = $('.price-modal').data('price');
        if(quantity < 1){
            $(this).val(1);
            $('.price-modal').text(parseInt(priceOriginal).toLocaleString('vi-VN', { currency: 'VND' }) + ' đ');
        }else if(quantity > 99){
            $('.input-number').val(99)
            $('.price-modal').text(parseInt(priceOriginal * 99).toLocaleString('vi-VN', { currency: 'VND' }) + ' đ');
        }else{
            $('.price-modal').text((parseInt(quantity) * parseInt(priceOriginal)).toLocaleString('vi-VN', { currency: 'VND' }) + ' đ');
        }
    })
}