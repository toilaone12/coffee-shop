$(document).ready(function() {
    $('#myTable').DataTable({
        "responsive": true,
        // Các tùy chọn khác...
    }); // Thay #myTable bằng ID của bảng bạn muốn biến thành DataTable
    //chon mot
    $('input[type="checkbox"]').click(function(){
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
    
});