//xu ly anh tin tuc
$('p').each(function() {
    // Kiểm tra xem thẻ <p> có thẻ <img> không
    if ($(this).find('img')) {
        // Kiểm tra xem thẻ <p> có lớp 'text-center' không
        $('p:has(img)').addClass('text-center');
    }
});
$("p img").each(function () {
    // Duyệt qua tất cả các thẻ <img> trong các thẻ <p>
    $(this).removeAttr("height"); // Gỡ bỏ thuộc tính height
    $(this).removeAttr("width");  // Gỡ bỏ thuộc tính width
    $(this).addClass("custom-image"); // Thêm lớp CSS tùy chỉnh
});

//hover vao menu
$(".custom-dropdown-item").hover(
    function () {
        $(this).find(".custom-submenu").css("display", "block");
    },
    function () {
        $(this).find(".custom-submenu").css("display", "none");
    }
);
$(document).ready(function(){
    //quen mat khau
    $('.forgot-password').on('click', () => {
        $('#userModal').modal('hide');
        // Mở modal khác
        $('#forgotPassword').modal('show');
    })

    //quay lai modal update truoc
    $('#forgotPassword').on('hide.bs.modal', function() {
        $('#userModal').modal('show'); // Khi updateModal được đóng, mở lại anotherModal
    });

    //dat hang
    $('.product').each(function(key, value){
        $('.open-modal-' + $(value).data('id')).on('click', handleBuyProduct);
    });

    //chuyen trang giua doi mat khau va thong tin ca nhan
    $('.collaspe-1').on('click', function(){
        if($('.collaspe-info').hasClass('d-none')){
            $('.collaspe-info').removeClass('d-none');
            $('.collaspe-change').addClass('d-none');
        }
    });

    $('.collaspe-2').on('click', function(){
        if($('.collaspe-change').hasClass('d-none')){
            $('.collaspe-change').removeClass('d-none');
            $('.collaspe-info').addClass('d-none');
        }
    });

    //mo modal phi van chuyen
    $('.modal-fee').on('click', () => {
        if($('.find-address').val().length !== 0){
            $('.find-address').val()
        }
    })

    $('.copy-discount').on('click', function(){
        let code = $(this).siblings('.code-coupon').text(); // siblings: chon phan tu ngang hang voi phan tu chon ban dau
        var blob = new Blob([code], { type: "text/plain" });

        // Tạo một thực thể ClipboardItem từ blob
        var clipboardItem = new ClipboardItem({ "text/plain": blob });

        // Sao chép clipboardItem vào clipboard
        navigator.clipboard.write([clipboardItem])
            .then(function() {
                alert("Đã sao chép vào clipboard");
            })
            .catch(function(error) {
                console.error("Lỗi khi sao chép vào clipboard: " + error);
            });
    })
    //danh so sao
    $('.choose-star').on('mouseenter',function() {
        var rating = $(this).data('rating');
        //se xoa het class
        for(let i = 1; i <= 5; i++){
            $('.choose-star[data-rating="' + i + '"]').removeClass('text-warning');
        }
        //se add class
        for(let i = 1; i <= rating; i++){
            $('.choose-star[data-rating="' + i + '"]').addClass('text-warning');
        }
        $('.choose-star').first().attr('data-choose',rating);
        // Xử lý rating: gửi rating đến server hoặc thực hiện các thao tác khác ở đây
    });
    //cong tru so luong san pham
    $('.quantity-right-plus').on('click',function(){
        let quantity = parseInt($('#quantity').val());
        let max = parseInt($('#quantity').attr('max'));
        if(quantity > max - 1){
            $('#quantity').val(max);
        }else{
            $('#quantity').val(quantity + 1);
        }
    })
    $('.quantity-left-minus').on('click',function(){
        let quantity = parseInt($('#quantity').val());
        let min = parseInt($('#quantity').attr('min'));
        if(quantity <= min){
            $('#quantity').val(min);
        }else{
            $('#quantity').val(quantity - 1);
        }
    })
    $('#quantity').on('change',function(){
        let quantity = parseInt($(this).val());
        let min = parseInt($(this).attr('min'));
        let max = parseInt($(this).attr('max'));
        if(quantity <= min){
            $('#quantity').val(min);
        }else if(quantity > max){
            $('#quantity').val(max);
        }
    })

    var $mainCarousel = $('.main-carousel');
    var $thumbsCarousel = $('.thumbs-carousel');

    $mainCarousel.owlCarousel({
        items: 1,
        nav: true,
        dots: false,
        navText: ['<span class="prev">❮</span>', '<span class="next">❯</span>']
    });

    $thumbsCarousel.owlCarousel({
        margin: 10,
        nav: false,
        dots: false,
        responsive: {
            0: {
                items: 4
            },
            600: {
                items: 5
            },
            1000: {
                items: 5
            }
        }
    });

    $thumbsCarousel.on('click', '.owl-item', function(e) {
        e.preventDefault();
        $mainCarousel.trigger('to.owl.carousel', [$(this).index(), 300, true]);
    });
})
