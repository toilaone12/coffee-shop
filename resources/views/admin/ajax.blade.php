<script>
    $(document).ready(function() {
        //xu ly socket
        let socket = new WebSocket("ws://localhost:8080");
        socket.onopen = function(e) {
            console.log("[open] Kết nối đã được thiết lập từ Trang Quản Trị");
        };

        socket.onmessage = function(event) {
            const blobData = event.data; // Đây là dữ liệu nhận được dưới dạng Blob
            // Chuyển đổi Blob thành dữ liệu văn bản
            blobData.text().then(textData => { // tra ve 1 promise
                let alert = JSON.parse(textData)[0];
                let idAdmin = "{{request()->cookie('id_account')}}";
                console.log(idAdmin);
                if(alert.id == idAdmin){
                    swalNotification('Thông báo đặt hàng',alert.text,'success',() => {
                        location.href = alert.link;
                    })
                }
                // console.log(JSON.parse(textData)[0].text); // In dữ liệu văn bản
            });
        };
        //dang xuat tai khoan
        $('.logout').click(function() {
            let url = "{{route('admin.logout')}}";
            let method = "GET";
            let data = {};
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            callAjax(url, method, data, headers,
                function(data) {
                    if (data.res === 'success') {
                        location.href = '{{route("admin.login")}}'
                    }
                },
                function(err) {
                    console.log(err);
                }
            );
        })
        //sua chuc vu
        $('.update-role').on('click', function() {
            let url = "{{route('role.update')}}";
            let method = "POST";
            let data = {
                id_role: $('.update-role').attr('data-id'),
                name_role: $('.name-update').val(),
            }
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            callAjax(url, method, data, headers,
                function(data) {
                    if (data.res === 'success' || data.res === 'error') {
                        swalNotification(data.title,data.status,data.icon,() => { location.reload() })
                        if ($('.error-name').text() != '') {
                            $('.error-name').text('');
                        }
                    } else if (data.res === 'warning') {
                        $('.error-name').text(data.status.name ? data.status.name : '');
                    }
                },
                function(err) {
                    console.log(err);
                }
            );
        })
        //xoa chuc vu
        $('#myTable').on('click', '.delete-role', function() {
            let name = $('.name-' + $(this).data('id')).text();
            let url = '{{route("role.delete")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let data = {
                id: $(this).data('id'),
            };
            swalQuestion('<span class="fs-16">Bạn có muốn xóa chức vụ ' + name + ' không</span>', function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()});
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //xoa nhieu chuc vu
        $('.delete-all-role').click(function() {
            let arrId = [];
            let url = '{{route("role.deleteAll")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let html = '<span class="fs-16">Bạn có muốn xóa các chức vụ đã chọn không ?';
            $('input[type="checkbox"]:checked').each(function(k, v) {
                let id = parseInt($(this).val());
                arrId.push({
                    id: id
                });
            })
            let data = {
                arrId,
            };
            swalQuestion(html, function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()});
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //xoa tai khoan
        $('#myTable').on('click', '.delete-account', function() {
            let name = $('.name-' + $(this).data('id')).text();
            let url = '{{route("account.delete")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let data = {
                id: $(this).data('id'),
            };
            swalQuestion('<span class="fs-16">Bạn có muốn xóa tài khoản ' + name + ' này không</span>', function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()});
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //xoa nhieu tài khoản
        $('.delete-all-account').click(function() {
            let arrId = [];
            let url = '{{route("account.deleteAll")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let html = '<span class="fs-16">Bạn có muốn xóa các tài khoản đã chọn không ?';
            $('input[type="checkbox"]:checked').each(function(k, v) {
                let id = parseInt($(this).val());
                arrId.push({
                    id: id
                });
            })
            let data = {
                arrId,
            };
            swalQuestion(html, function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()});
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //sua danh muc
        $('.update-category').on('click', function() {
            let url = "{{route('category.update')}}";
            let method = "POST";
            let data = {
                id_category: $('.update-category').attr('data-id'),
                name_category: $('.name-update').val(),
                id_parent_category: $('.id-parent-update').val(),
            }
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            callAjax(url, method, data, headers,
                function(data) {
                    if (data.res === 'success' || data.res === 'error') {
                        swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        if ($('.error-name').text() != '') {
                            $('.error-name').text('');
                        }
                    } else if (data.res === 'warning') {
                        $('.error-name').text(data.status.name ? data.status.name : '');
                    }
                },
                function(err) {
                    console.log(err);
                }
            );
        })
        //xoa danh muc
        $('#myTable').on('click', '.delete-category', function() { // su kien click ben trong id myTable va bat click co class la delete-category
            let name = $('.name-' + $(this).data('id')).text();
            let url = '{{route("category.delete")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let data = {
                id: $(this).data('id'),
            };
            // console.log('a');
            swalQuestion('<span class="fs-16">Bạn có muốn xóa nhà danh mục ' + name + ' không</span>', function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                } else {}
            });
        })
        //xoa nhieu danh muc
        $('.delete-all-category').click(function() {
            let arrId = [];
            let url = '{{route("category.deleteAll")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let html = '<span class="fs-16">Bạn có muốn xóa những danh mục này';
            $('input[type="checkbox"]:checked').each(function(k, v) {
                let id = parseInt($(this).val());
                arrId.push({
                    id: id
                });
            })
            html += ' không</span>';
            let data = {
                arrId,
            };
            swalQuestion(html, function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //sua don vi tinh
        $('.update-unit').on('click', function() {
            let url = "{{route('units.update')}}";
            let method = "POST";
            let data = {
                id_unit: $('.update-unit').attr('data-id'),
                fullname_unit: $('.fullname-update').val(),
                abbreviation_unit: $('.abbreviation-update').val(),
            }
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            callAjax(url, method, data, headers,
                function(data) {
                    if (data.res === 'success' || data.res === 'error') {
                        swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        if ($('.error-fullname').text() != '' || $('.error-abbreviation').text() != '') {
                            $('.error-fullname').text('');
                            $('.error-abbreviation').text('');
                        }
                    } else if (data.res === 'warning') {
                        $('.error-fullname').text(data.status.fullname ? data.status.fullname : '');
                        $('.error-abbreviation').text(data.status.abbreviation ? data.status.abbreviation : '');
                    }
                },
                function(err) {
                    console.log(err);
                }
            );
        })
        //xoa don vi tinh
        $('#myTable').on('click', '.delete-unit', function() {
            let fullname = $('.fullname-' + $(this).data('id')).text();
            let url = '{{route("units.delete")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let data = {
                id: $(this).data('id'),
            };
            swalQuestion('<span class="fs-16">Bạn có muốn xóa đơn vị ' + fullname + ' này không</span>', function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //xoa nhieu don vi tinh
        $('.delete-all-unit').click(function() {
            let arrId = [];
            let url = '{{route("units.deleteAll")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let html = '<span class="fs-16">Bạn có muốn xóa đơn vị đã chọn không ?';
            $('input[type="checkbox"]:checked').each(function(k, v) {
                let id = parseInt($(this).val());
                arrId.push({
                    id: id
                });
            })
            let data = {
                arrId,
            };
            swalQuestion(html, function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //sua san pham
        $('.update-product').submit(function(e) {
            e.preventDefault()
            let url = "{{route('product.update')}}";
            let method = "POST";
            let formData = new FormData($('.update-product')[0]);
            formData.append('description_product', CKEDITOR.instances['ckeditor'].getData())
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            callAjax(url, method, formData, headers,
                function(data) {
                    if (data.res === 'success' || data.res === 'error') {
                        swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        if ($('.error-image').text() != '' || $('.error-name').text() != '' || $('.error-subname').text() != '' ||
                            $('.error-quantity').text() != '' || $('.error-price').text() != '') {
                            $('.error-name').text('');
                            $('.error-image').text('');
                            $('.error-subname').text('');
                            $('.error-quantity').text('');
                            $('.error-price').text('');
                        }
                    } else if (data.res === 'warning') {
                        $('.error-image').text(data.status.image_product ? data.status.image_product : '');
                        $('.error-name').text(data.status.name_product ? data.status.name_product : '');
                        $('.error-subname').text(data.status.subname_product ? data.status.subname_product : '');
                        $('.error-quantity').text(data.status.quantity_product ? data.status.quantity_product : '');
                        $('.error-price').text(data.status.price_product ? data.status.price_product : '');
                    }
                },
                function(err) {
                    console.log(err);
                }, 1);
        })
        //xoa san pham
        $('#myTable').on('click', '.delete-product', function() {
            let name = $('.name-' + $(this).data('id')).text();
            let url = '{{route("product.delete")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let data = {
                id: $(this).data('id'),
            };
            // console.log('a');
            swalQuestion('<span class="fs-16">Bạn có muốn xóa sản phẩm ' + name + ' không</span>', function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //xoa nhieu san pham
        $('.delete-all-product').click(function() {
            let arrId = [];
            let url = '{{route("product.deleteAll")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let html = '<span class="fs-16">Bạn có muốn xóa các sản phẩm đã chọn không ?</span>';
            $('input[type="checkbox"]:checked').each(function(k, v) {
                let id = parseInt($(this).val());
                arrId.push({
                    id: id
                });
            })
            let data = {
                arrId,
            };
            swalQuestion(html, function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //xoa danh muc hinh anh san pham
        $('#myTable').on('click', '.delete-gallery', function() {
            let index = $(this).data('index');
            let url = '{{route("gallery.delete")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let data = {
                id: $(this).data('id'),
            };
            swalQuestion('<span class="fs-16">Bạn có muốn xóa ảnh số ' + index + ' không</span>', function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //sua nguyen lieu
        $('.update-ingredient').submit(function(e) {
            e.preventDefault()
            let formData = new FormData($(this)[0]);
            let url = "{{route('ingredients.update')}}";
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            callAjax(url, method, formData, headers,
                function(data) {
                    // console.log(data);
                    if (data.res === 'success' || data.res === 'error') {
                        swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        if ($('.error-name').text() != '') {
                            $('.error-name').text('');
                        }
                    } else if (data.res === 'warning') {
                        $('.error-name').text(data.status.name_ingredient ? data.status.name_ingredient : '');
                    }
                },
                function(err) {
                    console.log(err);
                }, 1);
        })
        //xoa nguyen lieu
        $('#myTable').on('click', '.delete-ingredient', function() {
            let name = $('.name-' + $(this).data('id')).text();
            let url = '{{route("ingredients.delete")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let data = {
                id: $(this).data('id'),
            };
            // console.log('a');
            swalQuestion('<span class="fs-16">Bạn có muốn xóa nguyên liệu ' + name + ' không?</span>', function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //xoa nhieu nguyen lieu
        $('.delete-all-ingredients').click(function() {
            let arrId = [];
            let url = '{{route("ingredients.deleteAll")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let html = '<span class="fs-16">Bạn có muốn xóa các nguyên liệu đã chọn không?</span>';
            $('input[type="checkbox"]:checked').each(function(k, v) {
                let id = parseInt($(this).val());
                arrId.push({
                    id: id
                });
            })
            let data = {
                arrId,
            };
            swalQuestion(html, function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //them cong thuc cho san pham
        $('.insert-recipe').click(function() {
            let objComponent = [];
            let url = "{{route('recipe.insert')}}";
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            $('.one-component').each(function() {
                let obj = {
                    id_ingredient: $(this).find('.id-ingredient-insert').val(),
                    id_unit: $(this).find('.id-unit-insert').val(),
                    quantity_recipe_need: $(this).find('.quantity-insert').val(),
                }
                objComponent.push(obj);
            })
            let data = {
                id_product: $('.id-product').val(),
                objComponent
            }
            callAjax(url, method, data, headers,
                function(data) {
                    swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                },
                function(err) {
                    console.log(err);
                }
            );
        })
        //sua cong thuc cho san pham
        $('.update-recipe').click(function() {
            let objComponent = [];
            let url = "{{route('recipe.update')}}";
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            $('.one-update-component').each(function() {
                let obj = {
                    id_ingredient: $(this).find('.id-ingredient-update').val(),
                    id_unit: $(this).find('.id-unit-update').val(),
                    quantity_recipe_need: $(this).find('.quantity-update').val(),
                }
                objComponent.push(obj);
            })
            let data = {
                id_product: $('.id-product-recipe').val(),
                id_recipe: $('.id-recipe').val(),
                objComponent
            }
            callAjax(url, method, data, headers,
                function(data) {
                    swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                },
                function(err) {
                    console.log(err);
                }
            );
        });
        //xoa cong thuc cho san pham
        $('#myTable').on('click', '.delete-recipe', function() {
            let id = $(this).data('id');
            let name = $('.id-product-' + id).text();
            let url = '{{route("recipe.delete")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let data = {
                id: id,
            };
            swalQuestion('<span class="fs-16">Bạn có muốn xóa công thức của sản phẩm ' + name + ' này không?</span>', function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //xoa nhieu cong thuc cho san pham
        $('.delete-all-recipe').click(function() {
            let arrId = [];
            let url = '{{route("recipe.deleteAll")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let html = '<span class="fs-16">Bạn có muốn xóa các công thức đã chọn không?</span>';
            $('input[type="checkbox"]:checked').each(function(k, v) {
                let id = parseInt($(this).val());
                arrId.push({
                    id: id
                });
            })
            let data = {
                arrId,
            };
            swalQuestion(html, function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //sua quang cao
        $('.update-slide').submit(function(e) {
            e.preventDefault()
            let url = "{{route('slide.update')}}";
            let method = "POST";
            let formData = new FormData($('.update-slide')[0]);
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }

            callAjax(url, method, formData, headers,
                function(data) {
                    if (data.res === 'success' || data.res === 'error') {
                        swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        if ($('.error-image').text() != '' || $('.error-name').text() != '' || $('.error-slug').text() != '') {
                            $('.error-name').text('');
                            $('.error-image').text('');
                            $('.error-slug').text('');
                        }
                    } else if (data.res === 'warning') {
                        $('.error-image').text(data.status.image_slide ? data.status.image_slide : '');
                        $('.error-name').text(data.status.name_slide ? data.status.name_slide : '');
                        $('.error-slug').text(data.status.slug_slide ? data.status.slug_slide : '');
                    }
                },
                function(err) {
                    console.log(err);
                }, 1);
        })
        //xoa quang cao
        $('#myTable').on('click', '.delete-slide', function() { // su kien click ben trong id myTable va bat click co class la delete-category
            let name = $('.name-' + $(this).data('id')).text();
            let url = '{{route("slide.delete")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let data = {
                id: $(this).data('id'),
            };
            // console.log('a');
            swalQuestion('<span class="fs-16">Bạn có muốn xóa ảnh có tên là ' + name + ' không</span>', function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                } else {}
            });
        })
        //xoa nhieu quang cao
        $('.delete-all-slide').click(function() {
            let arrId = [];
            let url = '{{route("slide.deleteAll")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let html = '<span class="fs-16">Bạn có muốn xóa các quảng cáo này';
            $('input[type="checkbox"]:checked').each(function(k, v) {
                let id = parseInt($(this).val());
                arrId.push({
                    id: id
                });
            })
            html += ' không</span>';
            let data = {
                arrId,
            };
            swalQuestion(html, function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //sua ma khuyen mai
        $('.update-coupon').submit(function(e) {
            e.preventDefault();
            let url = "{{route('coupon.update')}}";
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let formData = new FormData($(this)[0]);
            callAjax(url, method, formData, headers,
                function(data) {
                    if (data.res == 'warning') {
                        $('.error-name').text(data.status.name_coupon);
                        $('.error-code').text(data.status.code_coupon);
                        $('.error-quantity').text(data.status.quantity_coupon);
                        $('.error-discount').text(data.status.discount_coupon);
                        $('.error-time').text(data.status.expiration_time);
                    } else {
                        swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                    }
                },
                function(err) {
                    console.log(err);
                }, 1);
        });
        //xoa ma khuyen mai
        $('#myTable').on('click', '.delete-coupon', function() {
            let id = $(this).data('id');
            let url = '{{route("coupon.delete")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let data = {
                id: id,
            };
            swalQuestion('<span class="fs-16">Bạn có muốn xóa mã khuyến mãi này không</span>', function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //xoa nhieu ma khuyen mai
        $('.delete-all-coupon').click(function() {
            let arrId = [];
            let url = '{{route("coupon.deleteAll")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let html = '<span class="fs-16">Bạn có muốn xóa những mã khuyến mãi này không</span>';
            $('input[type="checkbox"]:checked').each(function(k, v) {
                let id = parseInt($(this).val());
                arrId.push({
                    id: id
                });
            })
            let data = {
                arrId,
            };
            swalQuestion(html, function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //sua phi van chuyen 
        $('.update-fee').submit(function(e) {
            e.preventDefault();
            let url = "{{route('fee.update')}}";
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let formData = new FormData($(this)[0]);
            callAjax(url, method, formData, headers,
                function(data) {
                    if (data.res == 'warning') {
                        $('.error-fee').text(data.status.fee);
                    } else {
                        swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                    }
                },
                function(err) {
                    console.log(err);
                }, 1);
        });
        //xoa phi van chuyen
        $('#myTable').on('click', '.delete-fee', function() {
            let id = $(this).data('id');
            let url = '{{route("fee.delete")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let data = {
                id: id,
            };
            swalQuestion('<span class="fs-16">Bạn có muốn xóa phí vận chuyển này không?</span>', function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //xoa nhieu phi van chuyen
        $('.delete-all-fee').click(function() {
            let arrId = [];
            let url = '{{route("fee.deleteAll")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let html = '<span class="fs-16">Bạn có muốn xóa những phí vận chuyển đã chọn không?</span>';
            $('input[type="checkbox"]:checked').each(function(k, v) {
                let id = parseInt($(this).val());
                arrId.push({
                    id: id
                });
            })
            let data = {
                arrId,
            };
            swalQuestion(html, function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //sua nha cung cap
        $('.update-supplier').on('click', function() {
            let url = "{{route('supplier.update')}}";
            let method = "POST";
            let data = {
                id_supplier: $('.update-supplier').attr('data-id'),
                name_supplier: $('.name-update').val(),
                phone_supplier: $('.phone-update').val(),
                address_supplier: $('.address-update').val(),
            }
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            callAjax(url, method, data, headers,
                function(data) {
                    if (data.res === 'success' || data.res === 'error') {
                        swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        if ($('.error-name').text() != '' || $('.error-phone').text() != '' || $('.error-address').text() != '') {
                            $('.error-name').text('');
                            $('.error-phone').text('');
                            $('.error-address').text('');
                        }
                    } else if (data.res === 'warning') {
                        $('.error-name').text(data.status.name ? data.status.name : '');
                        $('.error-phone').text(data.status.phone ? data.status.phone : '');
                        $('.error-address').text(data.status.address ? data.status.address : '');
                    }
                },
                function(err) {
                    console.log(err);
                }
            );
        })
        //xoa nha cung cap
        $('#myTable').on('click', '.delete-supplier', function() {
            let name = $('.name-' + $(this).data('id')).text();
            let url = '{{route("supplier.delete")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let data = {
                id: $(this).data('id'),
            };
            swalQuestion('<span class="fs-16">Bạn có muốn xóa nhà cung cấp ' + name + ' không</span>', function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                } else {}
            });
        })
        //xoa nhieu nha cung cap
        $('.delete-all-supplier').click(function() {
            let arrId = [];
            let url = '{{route("supplier.deleteAll")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let html = '<span class="fs-16">Bạn có muốn xóa các nhà cung cấp này';
            $('input[type="checkbox"]:checked').each(function(k, v) {
                let id = parseInt($(this).val());
                arrId.push({
                    id: id
                });
            })
            html += ' không</span>';
            let data = {
                arrId,
            };
            swalQuestion(html, function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //sua tin tuc
        $('.update-new').submit(function(e) {
            e.preventDefault()
            let url = "{{route('news.update')}}";
            let method = "POST";
            let formData = new FormData($(this)[0]);
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            formData.append('content_new', CKEDITOR.instances['ckeditor'].getData())
            callAjax(url, method, formData, headers,
                function(data) {
                    // console.log(data);
                    if (data.res === 'success' || data.res === 'error') {
                        swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                    } else if (data.res === 'warning') {
                        $('.error-image').text(data.status.image_new ? data.status.image_new : '');
                        $('.error-title').text(data.status.title_new ? data.status.title_new : '');
                        $('.error-content').text(data.status.content_new ? data.status.content_new : '');
                    }
                },
                function(err) {
                    console.log(err);
                }, 
            1);
        })
        //xoa tin tuc
        $('#myTable').on('click', '.delete-new', function() {
            let id = $(this).data('id');
            let url = '{{route("news.delete")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let data = {
                id: id,
            };
            swalQuestion('<span class="fs-16">Bạn có muốn xóa tin tức này không</span>', function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //xoa nhieu tin tuc
        $('.delete-all-news').click(function() {
            let arrId = [];
            let url = '{{route("news.deleteAll")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let html = '<span class="fs-16">Bạn có muốn xóa những tin tức này không</span>';
            $('input[type="checkbox"]:checked').each(function(k, v) {
                let id = parseInt($(this).val());
                arrId.push({
                    id: id
                });
            })
            let data = {
                arrId,
            };
            swalQuestion(html, function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            swalNotification(data.title,data.status,data.icon,() => {location.reload()})
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //them phieu hang
        $('.insert-note').submit(function(event) {
            event.preventDefault(); // Ngăn chặn việc gửi form mặc định;
            let url = "{{route('notes.insert')}}";
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let formData = new FormData($('.insert-note')[0]);
            formData.append('code_note', $('.list-detail-note').attr('data-code'))
            callAjax(url, method, formData, headers,
                function(data) {
                    if (data.res === 'success' || data.res === 'fail') {
                        swalNotification(data.title, data.status, data.icon,
                            function(callback) {
                                if (callback) {
                                    // Đóng modal hiện tại
                                    $('#exampleModal').modal('hide');
                                    // Mở modal khác
                                    $('#anotherModal').modal('show');
                                    $('.error-insert-name').text('');
                                    $('.error-insert-quantity').text('');
                                    listDetailNote(data.result);
                                }
                            }
                        );
                    } else {
                        $('.error-insert-name').text(data.status.name_note);
                        $('.error-insert-quantity').text(data.status.quantity_note);
                    }
                },
                function(err) {
                    console.log(err);
                }, 1)

        });
        //them danh sach chi tiet nguyen lieu
        $('.insert-detail-note').click(function() {
            let formDataArray = []; // Mảng chứa các dữ liệu từ form-detail-note
            $('.form-detail-note').each(function() {
                //tim cac class co trong tung form-detail-note
                let name = $(this).find('.name-ingredients-insert').val();
                let unit = $(this).find('.id-unit-insert').val();
                let quantity = $(this).find('.quantity-ingredients-insert').val();
                let price = $(this).find('.price-ingredients-insert').val();
                let formData = {
                    name_ingredient: name,
                    id_unit: unit,
                    quantity_ingredient: quantity,
                    price_ingredient: price
                };
                formDataArray.push(formData);
            });
            let url = "{{route('detail.insert')}}";
            let method = "POST";
            let header = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let data = {
                name_note: $('.name-insert').val(),
                quantity_note: $('.quantity-insert').val(),
                id_supplier: $('.list-detail-note').attr('data-id'),
                code_note: $('.list-detail-note').attr('data-code'),
                formDataArray
            }
            callAjax(url, method, data, header,
                function(data) {
                    if (data.res === 'success' || data.res === 'fail') {
                        swalNotification(data.title, data.status, data.icon,
                            function(callback) {
                                $('.list-detail-note').attr('data-id', '').attr('data-code', '').attr('data-count', '');
                                location.reload();
                            }
                        )
                    } else {
                        $('.error-name').text(data.status.name);
                        $('.error-quantity').text(data.status.quantity);
                        $('.error-price').text(data.status.price);
                    }
                },
                function(err) {
                    console.log(err);
                })
        })
        //sua thong tin phieu hang va chuyen sang sua chi tiet phieu hang
        $('.update-note').submit(function(e) {
            e.preventDefault();
            let url = "{{route('notes.update')}}";
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let formData = new FormData($('.update-note')[0]);
            formData.append('id', $('.update-note').attr('data-id'));
            callAjax(url, method, formData, headers,
                function(data) {
                    if (data.res === 'success' || data.res === 'fail') {
                        swalNotification(data.title, data.status, data.icon,
                            function(callback) {
                                if (callback) {
                                    $('#updateModal').modal('hide');
                                    // Mở modal khác
                                    $('#updateAnotherModal').modal('show');
                                    $('.error-update-name').text('');
                                    $('.error-update-quantity').text('');
                                    listUpdateDetailNote(data.result);
                                }
                            }
                        );
                    } else {
                        $('.error-update-name').text(data.status.name_note);
                        $('.error-update-quantity').text(data.status.quantity_note);
                    }
                },
                function(err) {
                    console.log(err);
                }, 1)
        })
        //sua danh sach chi tiet nguyen lieu
        $('.update-detail-note').click(function() {
            let formDataArray = []; // Mảng chứa các dữ liệu từ form-detail-note
            $('.form-update-detail-note').each(function() {
                //tim cac class co trong tung form-detail-note
                let name = $(this).find('.name-ingredients-update').val();
                let unit = $(this).find('.id-unit-update').val();
                let quantity = $(this).find('.quantity-ingredients-update').val();
                let price = $(this).find('.price-ingredients-update').val();
                let formData = {
                    name_ingredient: name,
                    id_unit: unit,
                    quantity_ingredient: quantity,
                    price_ingredient: price
                };
                formDataArray.push(formData);
            });
            let url = "{{route('detail.update')}}";
            let method = "POST";
            let header = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let data = {
                name_note: $('.name-update').val(),
                quantity_note: $('.quantity-update').val(),
                id_supplier: $('.list-update-detail-note').attr('data-id'),
                code_note: $('.list-update-detail-note').attr('data-code'),
                formDataArray
            }
            callAjax(url, method, data, header,
                function(data) {
                    // console.log(data);
                    if (data.res === 'success' || data.res === 'fail') {
                        swalNotification(data.title, data.status, data.icon,
                            function(callback) {
                                $('.list-update-detail-note').attr('data-id', '').attr('data-code', '').attr('data-count', '');
                                location.reload();
                            }
                        )
                    } else {
                        $('.error-name').text(data.status.name);
                        $('.error-quantity').text(data.status.quantity);
                        $('.error-price').text(data.status.price);
                    }
                },
                function(err) {
                    console.log(err);
                }
            )
        })
        //xoa phieu hang
        $('#myTable').on('click', '.delete-note', function() {
            let name = $('.name-' + $(this).data('id')).text();
            let url = '{{route("notes.delete")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let data = {
                id: $(this).data('id'),
            };
            swalQuestion('<span class="fs-16">Bạn có muốn xóa ' + name + ' này không</span>', function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            // console.log(data);
                            swalNotification(data.title, data.status, data.icon,() => {location.reload();})
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //xoa nhieu phieu hang
        $('.delete-all-notes').click(function() {
            let arrId = [];
            let url = '{{route("notes.deleteAll")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let html = '<span class="fs-16">Bạn có muốn xóa các phiếu hàng này';
            $('input[type="checkbox"]:checked').each(function(k, v) {
                let id = parseInt($(this).val());
                arrId.push({
                    id: id
                });
            })
            html += ' không</span>';
            let data = {
                arrId,
            };
            swalQuestion(html, function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            if (data.res === 'success') {
                                swalNotification('Xóa thành công!', 'Bạn đã xóa thành công.', 'success',
                                    function(callback) {
                                        if (callback) {
                                            location.reload();
                                        }
                                    }
                                );
                            } else {
                                swalNotification('Xóa không thành công!', 'Bạn đã xóa không thành công.', 'error');
                            }
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //xoa 1 nguyen lieu trong chi tiet don hang
        $('#myTable').on('click', '.delete-detail-note', function() {
            let name = $('.name-' + $(this).data('id')).text();
            let url = '{{route("detail.delete")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let data = {
                id: $(this).data('id'),
            };
            swalQuestion('<span class="fs-16">Bạn có muốn xóa nguyên liệu ' + name + ' này không</span>', function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            if (data.res === 'success') {
                                swalNotification('Xóa thành công!', 'Bạn đã xóa thành công.', 'success',
                                    function(callback) {
                                        if (callback) {
                                            location.reload();
                                        }
                                    }
                                );
                            } else {
                                swalNotification('Xóa không thành công!', 'Bạn đã xóa không thành công.', 'error');
                            }
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //xoa nhieu phieu hang
        $('.delete-all-detail').click(function() {
            let arrId = [];
            let url = '{{route("detail.deleteAll")}}';
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            let html = '<span class="fs-16">Bạn có muốn xóa các nguyên liệu trong phiếu hàng này';
            $('input[type="checkbox"]:checked').each(function(k, v) {
                let id = parseInt($(this).val());
                arrId.push({
                    id: id
                });
            })
            html += ' không?</span>';
            let data = {
                arrId,
            };
            swalQuestion(html, function(alert) {
                if (alert) {
                    callAjax(url, method, data, headers,
                        function(data) {
                            if (data.res === 'success') {
                                swalNotification('Xóa thành công!', 'Bạn đã xóa thành công.', 'success',
                                    function(callback) {
                                        if (callback) {
                                            location.reload();
                                        }
                                    }
                                );
                            } else {
                                swalNotification('Xóa không thành công!', 'Bạn đã xóa không thành công.', 'error');
                            }
                        },
                        function(err) {
                            console.log(err);
                        }
                    );
                }
            });
        })
        //xuat nguyen lieu
        $('#myTable').on('click', '.export-ingredients', function() {
            let url = "{{route('detail.export')}}";
            let method = "GET";
            let data = {
                id: $(this).data('id'),
            }
            let header = {};
            callAjax(url, method, data, header,
                function(data) {
                    swalNotification(data.title, data.status, data.icon, function(callback) {
                        if (callback) {
                            location.reload();
                        }
                    })
                },
                function(err) {
                    console.log(err);
                }
            )
        })
        
        //sua danh gia 
        $('.update-review').submit(function(e){
            e.preventDefault()
            let url = "{{route('review.update')}}";
            let method = "POST";
            let formData = new FormData($(this)[0]);
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            callAjax(url, method, formData, headers,
                function(data) {
                    // console.log(data);
                    if (data.res === 'success' || data.res === 'error') {
                        swalNotification(data.title, data.status, data.icon,
                            function(callback) {
                                if (callback) {
                                    location.reload();
                                }
                            }
                        );
                    } else if (data.res === 'warning') {
                        $('.error-reply').text(data.status.title_reply ? data.status.title_reply : '');
                    }
                },
                function(err) {
                    console.log(err);
                }, 1);
        })
        //tim kiem tuy chon ngay
        $('.search-date-product').submit(function(e){
            e.preventDefault()
            let url = "{{route('order.search')}}";
            let method = "POST";
            let formData = new FormData($(this)[0]);
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            callAjax(url, method, formData, headers,
                function(data) {
                    if (data.res === 'success') {
                        createChart(data.arrDetail,'Số lượng','myAreaChart')
                        $('.text-quantity-chart').text(`Biểu đồ số lượng sản phẩm đã bán (từ ${data.from} đến ${data.to})`)
                    }
                },
                function(err) {
                    console.log(err);
                }, 
            1);
        })
        //loc thong ke theo tuy chon
        $('.filter-quantity-sold').change(function(e){
            let option = $(this).val(); 
            let optionText = $(this).text();
            let url = "{{route('order.filter')}}";
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
            let data = {
                option: option,
            };
            callAjax(url, method, data, headers,
                function(data) {
                    if (data.res === 'success') {
                        createChart(data.arrDetail,'Số lượng','myAreaChart')
                        $('.text-quantity-chart').text(`Biểu đồ số lượng sản phẩm đã bán (từ ${data.from} đến ${data.to})`)
                    }
                },
                function(err) {
                    console.log(err);
                }, 
            );
        })
        //doc thong bao
        $(document).on('click','.choose-notification',function(){
            let id = $(this).data('id');
            let choose = $(this);
            let url = "{{route('notification.one')}}";
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
            let data = {
                id: id,
            };
            callAjax(url, method, data, headers,
                function(data) {
                    if(data.res == 'success'){
                        choose.find('.dot-notification').remove();
                        if(data.count == 0) $('.dot-bell').remove();
                    }
                },
                function(err) {
                    console.log(err);
                }, 
            );
        });
        //xem thong thong bao
        $(document).on('click','.load-more-notification',function(){
            let page = parseInt($(this).data('page')) + 1;
            let load = $(this);
            let id = "{{request()->cookie('id_account')}}";
            let choose = $(this);
            let url = "{{route('notification.load')}}";
            let method = "POST";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
            let data = {
                id: id,
                page: page,
            };
            callAjax(url, method, data, headers,
                function(data) {
                    if(data.res == 'success' && data.count != 0){
                        // console.log(data);
                        formNotification(data.list,data.page,data.count);
                        load.remove();
                    }
                },
                function(err) {
                    console.log(err);
                }, 
            );
        })
        //kiem tra don hang
        $('.check-order').on('click',function(){
            let id = $(this).data('id');
            let url = "{{route('order.check')}}";
            let method = "GET";
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
            let data = {
                id: id,
            };
            callAjax(url, method, data, headers,
                function(data) {
                    // console.log(data);
                    if(data.res == 'success'){
                        $('.invoice').removeClass('disabled')
                        location.reload();
                    } 
                    if(data.res == 'fail'){
                        $('.quantity').addClass('change-quantity-order');
                    }
                    swalNotiWithHTML(data.title, data.status, data.icon,() => {});
                },
                function(err) {
                    console.log(err);
                }, 
            );
        })
        //thay doi so luong khi khong du hang
        $(document).on('click','.change-quantity-order',function(e){
            e.preventDefault();
            var change = $(this);
            var currentValue = $(this).data('quantity');
            var dataId = $(this).data('id');
            
            // Thay thế ô <td> bằng ô <input>
            $(this).html('<input type="tel" class="input-quantity form-control" min=1 max='+currentValue+' value="' + currentValue + '" data-id="' + dataId + '">');
            
            // Focus vào ô input
            $('.input-quantity').focus();
            
            // Xử lý khi người dùng blur (click ra khỏi ô input)
            $('.input-quantity').on('blur', function() {
                var input = $(this);
                var newValue = $(this).val().trim();
                var dataId = $(this).data('id');
                if (newValue <= 1) {
                    // Giá trị không hợp lệ, thông báo lỗi hoặc xử lý theo ý của bạn
                    change.html('<input type="tel" class="input-quantity form-control" min=1 max='+currentValue+' value="' + currentValue + '" data-id="' + dataId + '">');
                    $(this).focus();
                } else {
                    // Thay thế ô <input> bằng giá trị mới trong ô <td> nếu giá trị hợp lệ
                    $(this).parent().html(newValue);
                    let url = "{{route('order.update')}}";
                    let method = "POST";
                    let headers = {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    };
                    let data = {
                        id: dataId,
                        quantity: newValue,
                    };
                    callAjax(url, method, data, headers,
                        function(data) {
                            if(data.res == 'success') change.closest('tr').find('.price').text(data.total);
                            // swalNotification(data.title, data.status, data.icon,() => {});
                        },
                        function(err) {
                            console.log(err);
                        }, 
                    );
                }
            });
        })
    })
</script>