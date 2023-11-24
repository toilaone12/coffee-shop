$(document).ready(function() {
    //dataTable
    $('#myTable').DataTable({
        "responsive": true,
        
        // Các tùy chọn khác...
    }); // Thay #myTable bằng ID của bảng bạn muốn biến thành DataTable
    //chon mot
    $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
        $('#myTable').off('click', 'input[type="checkbox"]');
        $('#myTable').on('click', 'input[type="checkbox"]', handleChooseOneItem)
    })
    $('#myTable').on('click', 'input[type="checkbox"]', handleChooseOneItem)
    //chon nhieu
    $('.choose-all').on('click', handleAllItemsInPage)
    $('#myTable').on('draw.dt', function() {
        $('.delete-all').addClass('disabled').attr('disabled', 'disabled');
        var checkboxes = $('input[type="checkbox"]');
        var countChecked = 0;
        checkboxes.each(function(index, element) {
            if (countChecked < 10) {
                $(element).prop('checked', false);
                countChecked--;
            } else {
                $(element).prop('checked', false);
            }
        });
        $('#myTable').on('click', '.choose-all', handleAllItemsInPage)
    });

    //phan hien anh khi chon
    $('.change-image').change(function(e){
        let fileName = $(this).val().split('\\').pop();
        $('.imagePath').text(fileName);
        $('.img-thumbnail').attr('src',URL.createObjectURL(e.target.files[0])) //tao 1 file anh tam thoi
    })

    $('.change-original-image').change(function(e){
        let fileName = $(this).val().split('\\').pop();
        $('.name-image').text(fileName);
        $('.img-thumbnail').attr('src',URL.createObjectURL(e.target.files[0])) //tao 1 file anh tam thoi
    })

    //phan chuc vu
    $('#myTable').on('click', '.choose-role', handleUpdateRoleClick)
    $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
        $('#myTable').off('click', '.choose-role');
        $('#myTable').on('click', '.choose-role', handleUpdateRoleClick)
    })

    //phan tai khoan
    $('.password-toggle-btn').click(function(){
        if($('#password').attr('type') === 'password'){
            $('#password').attr('type','text');
            $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
        }else{
            $('#password').attr('type','password');
            $(this).find('i').addClass('fa-eye').removeClass('fa-eye-slash');
        }
    })
    $('.re-password-toggle-btn').click(function(){
        if($('#re-password').attr('type') === 'password'){
            $('#re-password').attr('type','text');
            $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
        }else{
            $('#re-password').attr('type','password');
            $(this).find('i').addClass('fa-eye').removeClass('fa-eye-slash');
        }
    })
    //phan dang nhap
    $('.password-toggle-login').click(function(){
        if($('#password-login').attr('type') === 'password'){
            $('#password-login').attr('type','text');
            $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
        }else{
            $('#password-login').attr('type','password');
            $(this).find('i').addClass('fa-eye').removeClass('fa-eye-slash');
        }
    })
    //thong bao dang ky
    $('.register').click(function(){
        alert('Hãy liên hệ với quản trị viên của bạn để có thể đăng ký tài khoản')
    })
    //nhay so khi nhap ma otp
    $('.otp-input').on('input', function() { //su kien danh cho o input
        if ($(this).val().length == $(this).attr('maxlength')) { //neu gia tri truyen vao bang gtri attr maxlength
          $(this).next('.otp-input').focus(); //thi se nhay sang otp-input tiep theo
        }
        let otp = '';
        $('.otp-input').each(function(){
            otp += $(this).val();
        })
        $('.otp-account').val(otp);
    });

    //danh muc
    $('#myTable').on('click', '.choose-category', handleUpdateCategoryClick);
    // Khi DataTables thực hiện phân trang, gắn lại sự kiện cho các nút trên trang mới
    $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
        $('#myTable').off('click', '.choose-category');
        $('#myTable').on('click', '.choose-category', handleUpdateCategoryClick);
    });

    // phan don vi tinh
    $('#myTable').on('click', '.choose-unit', handleUpdateUnitClick)
    $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
        $('#myTable').off('click', '.choose-unit');
        $('#myTable').on('click', '.choose-unit', handleUpdateUnitClick)
    })

    //phan san pham
    $('#myTable').on('click', '.choose-product', handleUpdateProductClick);
    $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
        $('#myTable').off('click', '.choose-product');
        $('#myTable').on('click', '.choose-product', handleUpdateProductClick);     
    })
    //phan danh muc anh
    $('.change-multi-image').change(function(){
        var selectedImages = '';
        var selectedPath = '';
        var files = $(this)[0].files;
        for (var i = 0; i < files.length; i++) {
            selectedPath += '<span class="d-block">' + files[i].name + '</span>';
            var imageSrc = URL.createObjectURL(files[i]);
            let className = "img-thumbnail d-block";
            selectedImages += '<img loading="lazy" class="'+className+'"';
            selectedImages += 'style="height: 100px;" width="150" src="'+imageSrc+'" class="mt-5">';
        }
        $('.gallery-array').html(selectedImages);
        $('.image-update').removeClass('d-block')
        $('.image-update').addClass('d-none')
        $('.imagePath').html(selectedPath);
    })
    $('#myTable').on('change', '.update-gallery', handleUpdateGalleryClick)

    $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
        $('#myTable').on('change', '.update-gallery', handleUpdateGalleryClick)
    })
     
    //sua nguyen lieu 
    $('#myTable').on('click', '.choose-ingredients', handleUpdateIngredientClick)
    $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
        $('#myTable').off('click', '.choose-ingredients');
        $('#myTable').on('click', '.choose-ingredients', handleUpdateIngredientClick)
    })
    //them thanh phan cho cong thuc trong trang them
    $('.add-component-recipe').click(function(e){
        e.preventDefault();
        handleInsertComponentRecipe();
    })
    //xoa cai cuoi cung thanh phan cong thuc trong trang them
    $(".remove-component-recipe").on("click", function() {
        var lastElement = $('.one-component').last();
        lastElement.remove();
    });

    
    //sua cong thuc
    $('#myTable').on('click', '.choose-recipe', handleUpdateRecipeClick)
    $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
        $('#myTable').off('click', '.choose-recipe');
        $('#myTable').on('click', '.choose-recipe', handleUpdateRecipeClick)
    })
    //them thanh phan cho cong thuc trong trang sua
    $('.add-component-recipe-update').click(function(e){
        e.preventDefault();
        handleInsertComponentRecipe(1);
    })
    //xoa tat ca thanh phan cong thuc trong trang sua
    $(".remove-component-recipe-update").on("click", function() {
        let id = $('.id-recipe').val();
        let count = $('.component-'+id).data('count');
        if($('.one-update-component').length > count){
            var lastElement = $('.one-update-component').last();
            lastElement.remove();
        }else{
            swalNotification('Xóa nguyên liệu','Không được xóa nguyên liệu gốc (chỉ được chỉnh sửa)','warning',
            function(callback){

            });
        }
    });

    //quang cao
    $('#myTable').on('click', '.choose-slide', handleUpdateSlideClick);
    $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
        $('#myTable').off('click', '.choose-slide');
        $('#myTable').on('click', '.choose-slide', handleUpdateSlideClick);
    })
    //sua ma khuyen mai
    $('#myTable').on('click', '.choose-coupon', handleUpdateCouponClick)
    $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
        $('#myTable').off('click', '.choose-coupon');
        $('#myTable').on('click', '.choose-coupon', handleUpdateCouponClick)
    })
    //thay doi ban kinh
    $('.range-radius').on('input',function(){
        $('.radius-fee').text($(this).val());
    })
    //sua phi van chuyen
    $('#myTable').on('click', '.choose-fee', handleUpdateFeeClick)
    $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
        $('#myTable').off('click', '.choose-fee');
        $('#myTable').on('click', '.choose-fee', handleUpdateFeeClick)
    })
    //nha cung cap
    $('#myTable').on('click', '.choose-supplier', handleUpdateSupplierClick);
    $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
        $('#myTable').off('click', '.choose-supplier');
        $('#myTable').on('click', '.choose-supplier', handleUpdateSupplierClick);
    })

    //sua tin tuc
    $('#myTable').on('click', '.choose-new', handleUpdateNewClick)
    $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
        $('#myTable').on('click', '.choose-new', handleUpdateNewClick)
    })

    //phan phieu hang 
    //quay lai modal truoc
    $('#anotherModal').on('hide.bs.modal', function() {
        $('#exampleModal').modal('show'); // Khi exampleModal được đóng, mở lại anotherModal
    });
    //sua phieu hang
    $('#myTable').on('click', '.choose-note', handleUpdateNoteClick)
    $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
        $('#myTable').on('click', '.choose-note', handleUpdateNoteClick)
    })

    //quay lai modal update truoc
    $('#updateAnotherModal').on('hide.bs.modal', function() {
        $('#updateModal').modal('show'); // Khi updateModal được đóng, mở lại anotherModal
    });

    //phan hoi & sua phan hoi
    $('#myTable').on('click', '.reply-review', handleReplyReview)
    $('#myTable').on('click', '.choose-review', handleUpdateReview)

    $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
        $('#myTable').on('click', '.reply-review', handleReplyReview)
        $('#myTable').on('click', '.choose-review', handleUpdateReview)
    })
    //tim kiem ngay
    $('#date-from').on('change', function() {
        var selectedDate = $(this).val();
        $('#date-to').attr('min', selectedDate);
    });
    $('#date-to').on('change', function() {
        var selectedDate = $(this).val();
        $('#date-from').attr('max', selectedDate);
    });

    //goi dien cho khach hang
    $('.call-customer').on('click', function(){
        let phone = $('.phone-customer').text();
        location.href = 'tel:'+phone;
    })
});