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
$(".custom-dropdown-item").hover(
    function () {
        $(this).find(".custom-submenu").css("display", "block");
    },
    function () {
        $(this).find(".custom-submenu").css("display", "none");
    }
);
