function handleBuyProduct(){
    let id = $(this).data('id');
    let image = $('.image-'+id).data('image');
    let name = $('.name-'+id).text();
    let price = $('.price-'+id+' > span').text();
    let html = '';
    html += `<div class="card">`;
    html += `<img class="card-img-top" src="${image}" alt="Card image cap">`;
    html += `<div class="card-body">`;
    html += `<h5 class="card-title text-dark fs-18">${name}</h5>`;
    html += `<p class="card-text text-dark fs-16">${price}</p>`;
    html += `<p class="card-text text-dark fs-16">${price}</p>`;
    html += `<div class="form-group">`;
    html += `<label for="exampleFormControlTextarea1">Ghi chú</label>`;
    html += `<textarea class="form-control border-secondary" id="exampleFormControlTextarea1" rows="3"></textarea>`;
    html += `</div>`;
    html += `<a href="#" class="btn btn-primary btn-outline-primary">Đặt hàng</a>`;
    html += `</div>`;
    html += `</div>`;
    $('.product-modal').html(html);
}