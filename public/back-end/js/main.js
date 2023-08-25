$(document).ready(function() {
    $('#myTable').DataTable({
        "responsive": true,
        // Các tùy chọn khác...
    }); // Thay #myTable bằng ID của bảng bạn muốn biến thành DataTable
    
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
    $('#myTable').on('click', '.update-gallery', handleUpdateGalleryClick)

    $('#myTable').on('draw.dt', function() { // draw.dt la sau khi dataTables dc ve lai
        $('#myTable').on('click', '.update-gallery', handleUpdateGalleryClick)
    })
});