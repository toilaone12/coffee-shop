$(document).ready(function() {
    //dataTable
    $('#myTable').DataTable({
        "responsive": true,
        
        // Các tùy chọn khác...
    }); // Thay #myTable bằng ID của bảng bạn muốn biến thành DataTable
    //chon mot
    $('#myTable').on('click', 'input[type="checkbox"]', function() {
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
    })
    //chon nhieu
    $('.choose-all').click(function(){
        var isChecked = $('input[type="checkbox"]').not(':checked').length !== 0; // b1: true b2: false
        $('input[type="checkbox"]').prop('checked', isChecked); //ktra
        if ($('input[type="checkbox"]:checked').length >= 2) {
            $('.delete-all').removeClass('disabled').removeAttr('disabled')
        } else {
            $('.delete-all').addClass('disabled').attr('disabled','disabled')
        }
    })

    //nha cung cap
    $('.supplier').each(function(key, value){
        $('#myTable').on('click', '.update-supplier-' + $(value).data('id'), handleUpdateSupplierClick);
    })
    $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
        $('.supplier').each(function(key, value){
            $('#myTable').on('click', '.update-supplier-' + $(value).data('id'), handleUpdateSupplierClick);
        })

    })
    //danh muc
    $('.category').each(function(key, value){
        $('#myTable').on('click', '.update-category-' + $(value).data('id'), handleUpdateCategoryClick);
    });
    
    // Khi DataTables thực hiện phân trang, gắn lại sự kiện cho các nút trên trang mới
    $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
        $('.category').each(function(key, value){
            $('#myTable').on('click', '.update-category-' + $(value).data('id'), handleUpdateCategoryClick);
        });
    });
    //phan quang cao
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

    $('.slide').each(function(key, value){
        $('#myTable').on('click', '.update-slide-' + $(value).data('id'), handleUpdateSlideClick);
    })

    $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
        $('.slide').each(function(key, value){
            $('#myTable').on('click', '.update-slide-' + $(value).data('id'), handleUpdateSlideClick);
        })
    })
    //phan san pham
    $('.product').each(function(key, value){
        $('#myTable').on('click', '.update-product-' + $(value).data('id'), handleUpdateProductClick);
    })

    $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
        $('.product').each(function(key, value){
            $('#myTable').on('click', '.update-product-' + $(value).data('id'), handleUpdateProductClick);
        })
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

    //phan chuc vu
    $('.role').each(function(key, value){
        $('#myTable').on('click', '.update-role-' + $(value).data('id'), handleUpdateRoleClick)
    })
    $('.role').each(function(key, value){
        $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
            $('#myTable').on('click', '.update-role-' + $(value).data('id'), handleUpdateRoleClick)
        })
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

    $('.register').click(function(){
        alert('Hãy liên hệ với quản trị viên của bạn để có thể đăng ký tài khoản')
    })

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
    
    // phan don vi tinh
    $('.unit').each(function(key, value){
        $('#myTable').on('click', '.update-unit-' + $(value).data('id'), handleUpdateUnitClick)
    })
    $('.unit').each(function(key, value){
        $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
            $('#myTable').on('click', '.update-unit-' + $(value).data('id'), handleUpdateUnitClick)
        })
    })

    //phan phieu hang 
    //quay lai modal truoc
    $('#anotherModal').on('hide.bs.modal', function() {
        $('#exampleModal').modal('show'); // Khi exampleModal được đóng, mở lại anotherModal
    });
    //sua phieu hang
    $('.note').each(function(key, value){
        $('#myTable').on('click', '.update-note-' + $(value).data('id'), handleUpdateNoteClick)
    })
    $('.note').each(function(key, value){
        $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
            $('#myTable').on('click', '.update-note-' + $(value).data('id'), handleUpdateNoteClick)
        })
    })

    //quay lai modal update truoc
    $('#updateAnotherModal').on('hide.bs.modal', function() {
        $('#updateModal').modal('show'); // Khi updateModal được đóng, mở lại anotherModal
    });
    
    //sua nguyen lieu 
    $('.ingredients').each(function(key, value){
        $('#myTable').on('click', '.update-ingredients-' + $(value).data('id'), handleUpdateIngredientClick)
    })
    $('.ingredients').each(function(key, value){
        $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
            $('#myTable').on('click', '.update-ingredients-' + $(value).data('id'), handleUpdateIngredientClick)
        })
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
    $('.recipe').each(function(key, value){
        $('#myTable').on('click', '.update-recipe-' + $(value).data('id'), handleUpdateRecipeClick)
    })
    $('.recipe').each(function(key, value){
        $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
            $('#myTable').on('click', '.update-recipe-' + $(value).data('id'), handleUpdateRecipeClick)
        })
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
    //thay doi ban kinh
    $('.range-radius').on('input',function(){
        $('.radius-fee').text($(this).val());
    })
    //sua phi van chuyen
    $('.fee').each(function(key, value){
        $('#myTable').on('click', '.update-fee-' + $(value).data('id'), handleUpdateFeeClick)
    })
    $('.fee').each(function(key, value){
        $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
            $('#myTable').on('click', '.update-fee-' + $(value).data('id'), handleUpdateFeeClick)
        })
    })
    //sua ma khuyen mai
    $('.coupon').each(function(key, value){
        $('#myTable').on('click', '.update-coupon-' + $(value).data('id'), handleUpdateCouponClick)
    })
    $('.coupon').each(function(key, value){
        $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
            $('#myTable').on('click', '.update-coupon-' + $(value).data('id'), handleUpdateCouponClick)
        })
    })
    //sua tin tuc
    $('.new').each(function(key, value){
        $('#myTable').on('click', '.update-new-' + $(value).data('id'), handleUpdateNewClick)
    })
    $('.new').each(function(key, value){
        $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
            $('#myTable').on('click', '.update-new-' + $(value).data('id'), handleUpdateNewClick)
        })
    })
    //phan hoi & sua phan hoi
    $('.review').each(function(key, value){
        $('#myTable').on('click', '.reply-review-' + $(value).data('id'), handleReplyReview)
        $('#myTable').on('click', '.update-review-' + $(value).data('id'), handleUpdateReview)
    })
    $('.review').each(function(key, value){
        $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
            $('#myTable').on('click', '.reply-review-' + $(value).data('id'), handleReplyReview)
            $('#myTable').on('click', '.update-review-' + $(value).data('id'), handleUpdateReview)
        })
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
});