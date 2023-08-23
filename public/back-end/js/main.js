function handleUpdateCategoryClick() {
    let id = $(this).data('id');
    let name = $('.name-' + id).text();
    let idParent = $('.id-parent-' + id).data('id');
    
    let selectOptions = `<option value="0" ${idParent === 0 ? 'selected' : ''}>Danh mục gốc</option>`;
    listParent.forEach(category => {
        selectOptions += `<option value="${category.id_category}" ${category.id_category === idParent ? 'selected' : ''}>${category.name_category}</option>`;
    });
    
    $('.name-update').val(name);
    $('.id-parent-update').html(selectOptions);
    $('.update-category').attr('data-id', id);
}

$(document).ready(function() {
    $('#myTable').DataTable({
        "responsive": true,
        // Các tùy chọn khác...
    }); // Thay #myTable bằng ID của bảng bạn muốn biến thành DataTable
    
    //nha cung cap
    $('.supplier').each(function(key, value){
        $('.update-supplier-'+$(value).data('id')).click(function(key, val){
            let name = $('.name-'+$(value).data('id')).text();
            let phone = $('.phone-'+$(value).data('id')).text();
            let address = $('.address-'+$(value).data('id')).text();
            $('.name-update').val(name);
            $('.phone-update').val(phone);
            $('.address-update').val(address);
            $('.update-supplier').attr('data-id',$(value).data('id'))
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
        $('.update-slide-'+$(value).data('id')).click(function(key, val){
            let id = $(value).data('id');
            let image = $('.image-'+$(value).data('id')).attr('src');
            let nameImage = $('.image-'+$(value).data('id')).attr('data-name');
            let name = $('.name-'+$(value).data('id')).text();
            let slug = $('.slug-'+$(value).data('id')).text();
            $('.image-update').attr('src',image);
            $('.id-slide').val(id);
            $('.image-original').val(nameImage.replace('storage/',''));
            $('.name-update').val(name);
            $('.slug-update').val(slug);
        })
    })
});