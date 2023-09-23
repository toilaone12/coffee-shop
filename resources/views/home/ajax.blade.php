<script>
    $(document).ready(function() {
        $(document).on('click', '#add-waiting-cart', () => { // se chay ke ca khi DOM chua xuat hien
            let id = $('.id-product').val();
            let image = $('.image-product').attr('src');
            let name = $('.name-product').text();
            let price = $('.price-product').data('price');
            let quantity = $('.quantity-product').val();
            let note = $('.note-product').val();
            let url = '{{route("cart.insert")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
            let data = {
                id: id,
                quantity: quantity,
                note: note,
            };
            callAjax(url, method, data, headers,
                (data) => {
                    if(data.res === 'warning'){
                        swalNotification(data.title,data.status,data.icon,() => {})
                    }else{
                        if(data.res === 'success'){
                            let urlCart = "{{route('cart.home')}}";
                            formCartNavbar(urlCart);
                            addToCart(id,image,name,price,quantity);
                        }
                        swalNotification(data.title,data.status,data.icon,() => {})
                    } 
                },
                (err) => {
                    console.log(err);
                })
        })
    })
</script>