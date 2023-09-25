<script>
    $(document).ready(function() {
        //them san pham vao gio hang
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
                    if (data.res === 'warning') {
                        swalNotification(data.title, data.status, data.icon, () => {})
                    } else {
                        if (data.res === 'success') {
                            let urlCart = "{{route('cart.home')}}";
                            formCartNavbar(urlCart);
                            addToCart(id, image, name, price, quantity);
                        }
                        swalNotification(data.title, data.status, data.icon, () => {})
                    }
                },
                (err) => {
                    console.log(err);
                })
        })

        $(document).on('submit', '.register-customer', (e) => {
            e.preventDefault();
            let formData = new FormData($('.register-customer')[0]);
            let url = "{{route('customer.register')}}";
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            callAjax(url, method, formData, headers,
                (data) => {
                    if(data.res === 'warning'){
                        $('.error-name').text(data.status.name ? data.status.name : '');
                        $('.error-email').text(data.status.email ? data.status.email : '');
                        $('.error-password').text(data.status.password ? data.status.password : '');
                        $('.error-repassword').text(data.status.repassword ? data.status.repassword : '');
                    }else{
                        swalNotification(data.title, data.status, data.icon, () => {})
                    }
                },
                (err) => {
                    console.log(err);
                }, 1);
        })

        $(document).on('submit', '.login-customer', (e) => {
            e.preventDefault();
            let formData = new FormData($('.login-customer')[0]);
            let url = "{{route('customer.login')}}";
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            callAjax(url, method, formData, headers,
                (data) => {
                    if(data.res === 'warning'){
                        $('.error-email').text(data.status.email ? data.status.email : '');
                        $('.error-password').text(data.status.password ? data.status.password : '');
                    }else{
                        swalNotification(data.title, data.status, data.icon, () => { location.reload() })
                    }
                },
                (err) => {
                    console.log(err);
                }, 1);
        })
    })
</script>