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
    //dat hang
    $('.product').each(function(key, value){
        $('.open-modal-' + $(value).data('id')).on('click', handleBuyProduct);
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
})
