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
                isLogin: "{{session('id_customer') ? 1 : 0}}"
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
        //dang ky
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
                    if (data.res === 'warning') {
                        $('.error-name').text(data.status.name ? data.status.name : '');
                        $('.error-email').text(data.status.email ? data.status.email : '');
                        $('.error-password').text(data.status.password ? data.status.password : '');
                        $('.error-repassword').text(data.status.repassword ? data.status.repassword : '');
                    } else {
                        swalNotification(data.title, data.status, data.icon, () => {})
                    }
                },
                (err) => {
                    console.log(err);
                }, 1);
        })
        //dang nhap
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
                    if (data.res === 'warning') {
                        $('.error-email').text(data.status.email ? data.status.email : '');
                        $('.error-password').text(data.status.password ? data.status.password : '');
                    } else {
                        swalNotification(data.title, data.status, data.icon, () => {
                            location.reload()
                        })
                    }
                },
                (err) => {
                    console.log(err);
                }, 1);
        })
        //dang xuat
        $(document).on('click', '.logout', () => {
            let url = "{{route('customer.logout')}}";
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            swalLogout(() => {
                callAjax(url, method, {}, headers,
                    (data) => {
                        console.log(data);
                        if (data.res === 'success') {
                            swalNotification(data.title, data.status, data.icon, () => {
                                location.reload()
                            })
                        }
                    },
                    (err) => {
                        console.log(err);
                    });
            })
        })
        //tim dia chi
        $(document).on('keyup', '.find-address', () => {
            let typingTimer;
            clearTimeout(typingTimer); // Xóa bất kỳ timeout nào hiện tại
            // Đặt timeout mới
            let keyword = encodeURIComponent($('.find-address').val());
            if (keyword.length > 0) {
                typingTimer = setTimeout(function() {
                    // console.log($('.find-address').val());
                    let apiKey = 'X5rp4KMjYtFLZvjKBlRWIGh_BKUecHaGUQ8sGwkOOT4';
                    let url = `https://discover.search.hereapi.com/v1/discover`;
                    let method = 'GET';
                    let headers = {};
                    let data = {
                        q: keyword,
                        at: '20.994081780314524,105.79288106771862',
                        apiKey: apiKey,
                        xnlp: 'CL_JSMv3.1.38.0'
                    };
                    callAjax(url, method, data, headers,
                        (data) => {
                            if (data.items.length > 0) {
                                formResultSearch(data.items);
                            }
                        },
                        (err) => {
                            console.log(err);
                        })


                    // Thực hiện hành động sau khi ngừng gõ trong doneTypingInterval
                }, 2000);
            } else {
                $('#result-list').addClass('d-none');
            }
        })
        //tra phi van chuyen
        $(document).on('submit', '.search-fee', (e) => {
            e.preventDefault();
            let formData = new FormData($('.search-fee')[0]);
            let url = "{{route('fee.search')}}";
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            callAjax(url, method, formData, headers,
                (data) => {
                    console.log(data);
                    // if(data.res === 'warning'){
                    //     $('.error-email').text(data.status.email ? data.status.email : '');
                    //     $('.error-password').text(data.status.password ? data.status.password : '');
                    // }else{
                    //     swalNotification(data.title, data.status, data.icon, () => { location.reload() })
                    // }
                },
                (err) => {
                    console.log(err);
                }, 1);
        })
    })
</script>