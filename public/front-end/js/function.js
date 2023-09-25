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
        title: '<p class="fs-16">Bạn chắc chắn muốn xóa không?</p>',
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

function swalLogout(callback){
    Swal.fire({
        title: '<p class="fs-25">Đăng xuất tài khoản</p>',
        icon: 'warning',
        html: '<p class="fs-16">Bạn có muốn đăng xuất tài khoản không?</p>',
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText:
            '<i class="fa-solid fa-check"></i> Có',
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
// giao dien modal them san pham vao gio hang
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
// xu ly su kien cong tru san pham
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

function formCartNavbar(url) {
    if(!$('div').hasClass('form-cart')){ //kiem tra neu chua ton tai thi them khong thi van de nguyen tranh vc k append dc san pham
        var html = `<div class="form-cart p-2 border">`;
        html += `<div class="fs-18 text-secondary mb-3">Sản phẩm mới thêm</div>`;
        html += `<div class="mb-3 overflow-auto width-cart cart-item">`;
        html += `</div>`;
        html += `<a href="${url}" class="btn btn-primary fs-13">Xem giỏ hàng</a>`;
        html += `</div>`;
        $('.cart-hover').html(html);
    } 
}

function addToCart(id,image,name,price,quantity) {
    let i = $('.bag > small').text() ? $('.bag > small').text() : 0;
    if($('div').hasClass('cart-child-'+id)){ //ktra san pham da ton tai chua, co thi cong khong thi xuat hien moi
        let priceExist = parseInt($('.price-child-'+id).data('price'));
        let quantityExist = parseInt($('.quantity-child-'+id).text());
        let priceChange = parseInt(price * quantity) + priceExist;
        let quantityChange = parseInt(quantity) + quantityExist;
        $('.price-child-'+id).text(priceChange.toLocaleString('vi-VN', { currency: 'VND' }) + ' đ');
        $('.quantity-child-'+id).text(quantityChange)
    }else{
        var option = `<div class="d-flex justify-content-start mr-3 mb-3 cart-child-${id}" style="width: 22rem;">`
        option += `<img loading="lazy" class="object-fit-cover rounded" width="50" height="50" src="${image}" alt="Card image cap">`;
        option += `<div class="d-block" style="width: 90%">`;
        option += `<div class="d-flex justify-content-between" style="width: 310px !important;">`;
        option += `<p class="fs-14 text-dark text-truncate mx-3">${name}</p>`;
        option += `<p class="fs-14 text-dark price-child-${id}" data-price="${parseInt(price * quantity)}">${parseInt(price * quantity).toLocaleString('vi-VN', { currency: 'VND' })} đ</p>`;
        option += `</div>`;
        option += `<div class="d-flex w-100">`;
        option += `<p class="fs-14 text-dark mx-3">x <span class="quantity-child-${id} text-dark">${quantity}</span></p>`;
        option += `</div>`;
        option += `</div>`;
        option += `</div>`;
        $('.cart-item').append(option);
        i++;
    }
    var dot = `<span class="bag d-flex justify-content-center align-items-center"><small>${i}</small></span>`;
    $('.dot-cart').html(dot)

}
