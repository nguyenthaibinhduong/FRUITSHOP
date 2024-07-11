    <script src="{{ asset('client/js/jquery-3.3.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.0/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('client/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('client/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('client/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('client/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('client/js/mixitup.min.js') }}"></script>
    <script src="{{ asset('client/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('client/js/main.js') }}"></script>
    <script>
         

        

       $(document).ready(function() {
        cartQuantity();
        //=============================PRODUCT API=================================//
        function renderProduct(data){
                     $('.product-list-pagginate').empty();
                    $('.product-list-pagginate').html(data);
                    $('.set-bg').each(function () {
                        var bg = $(this).data('setbg');
                        $(this).css('background-image', 'url(' + bg + ')');
                    });
                    $('.add-to-cart').click(function() {
                    var productId = $(this).data('id');
                    var userId = $('#user_id_cart_' + productId).val();
                    var token = $('input[name="_token"]').val();
                    addToCart(productId, userId, token);
                    });
        }
        function fetchProducts(page=1){
            let minamount = $("#minamount").val();
            let maxamount = $("#maxamount").val();
            $.ajax({
                url: "{{ url('api/get-product-price') }}",
                type: 'GET',
                data:{page:page,minamount:minamount,maxamount:maxamount},
                success: function(response){
                    renderProduct(response)
                }
            });
        }
        $.ajax({
            url: "{{ url('api/get-min-max-price') }}",
            type: 'GET',
            success: function(data){
            var rangeSlider = $(".price-range"),
            minamount = $("#minamount"),
            maxamount = $("#maxamount"),
            minPrice = data[0],
            maxPrice = data[1];       
            rangeSlider.slider({
                range: true,
                min: minPrice,
                max: maxPrice,
                values: [minPrice, maxPrice],
                slide: function (event, ui) {
                    minamount.val(  ui.values[0].toLocaleString('vi-VN')+'đ');
                    maxamount.val(  ui.values[1].toLocaleString('vi-VN')+'đ');
                }
            });
            minamount.val(rangeSlider.slider("values", 0).toLocaleString('vi-VN')+'đ');
            maxamount.val(rangeSlider.slider("values", 1).toLocaleString('vi-VN')+'đ');

            }
        })
        $('.ui-state-default').on('mouseup',function(){
            fetchProducts();
        })
        $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        fetchProducts(page);
        });
        //=============================PRODUCT API END=================================//





        //=============================CART API =================================//

      function closeOffcanvas() {
        $('#offcanvasExample').removeClass('show');
        $('#offcanvasBackdrop').removeClass('show');
      }
      function cartQuantity(){
                $.ajax({
                    url: "{{ url('api/cart-quantity') }}",
                    type: 'GET',
                    success: function(data) {
                        $('.count_cart').html(data)
                    }
                });
                
      }
      function addToCart(productId, userId, token) {
            if (userId != "") {
                $.ajax({
                    url: "{{ url('api/add-cart') }}",
                    type: 'POST',
                    data: {
                        product_id: productId,
                        user_id: userId,
                        _token: token
                    },
                    success: function(response) {
                        if (response == 1) {
                            Swal.fire({
                                title: "Thành công!",
                                text: "Sản phẩm của đã được thêm vào giỏ hàng!",
                                icon: "success"
                            });
                            cartQuantity();
                        } else {
                            Swal.fire({
                                title: "Hết hàng!",
                                text: "Sản phẩm của đang trong trạng thái hết hàng!",
                                icon: "error"
                            });
                        }
                    }
                });
            } else {
                Swal.fire({
                    title: "Chưa đăng nhập",
                    text: "Hãy đăng nhập để thêm giỏ hàng",
                    icon: "question"
                });
            }
        }
      $('.add-to-cart').click(function() {
        var productId = $(this).data('id');
        var userId = $('#user_id_cart_' + productId).val();
        var token = $('input[name="_token"]').val();
        addToCart(productId, userId, token);

      });
      $('.offcanvasToggle').on('click', function(event) {
        event.preventDefault();
        $('#offcanvasExample').toggleClass('show');
        $('#offcanvasBackdrop').toggleClass('show');
        var id = $('#user_id').val();
        var html ='';
        $.ajax({
                    url: "{{ url('api/get-cart/') }}"+'/'+id,
                    type: 'GET',
                    success: function(res){
                        if(res.length>0){
                            for(var cart of res){
                                urlImage="{{ url('/') }}"+'/'+cart.url;
                                html+='<tr>';
                                html+='<td><img width="40px" height="40px" src="'+urlImage+'" alt=""></td>';
                                html+='<td>'+cart.product_name.substring(0, 18)+'</td>';
                                html+='<td> x '+cart.quantity+'</td>';
                                html+='<td class="subtotal font-weight-bold">'+(cart.product_price*cart.quantity).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + 'đ'+'</td>';
                                html+='</tr>';
                            }
                            $('.cart_table_offcanvas').html(html);
                            
                        }else{
                            html+='<i>Chưa có sản phẩm trong giỏ hàng</i>'
                            $('.cart_table_offcanvas').html(html);
                        }
                    }
        });
        
      });
      
      $('#offcanvasClose').on('click', function(event) {
        event.preventDefault();
        closeOffcanvas();
      });

      $('#offcanvasBackdrop').on('click', function() {
        closeOffcanvas();
      });
     
       //=============================CART API END=================================//


       //=============================COMMENT API=================================//
       const renderComment = (data) => {
                    $('#commentsList').empty();
                    $('#commentsList').html(data);
                    $('input[name="body"]').val('');
                    $('input[name="option"]').val(0)
                    $('.edit-comment').on('click', function() {
                        var commentId = $(this).data('id');
                        var commentBody = $('#comment_' + commentId + ' p').text();
                        $('input[name="body"]').val(commentBody);
                        $('input[name="option"]').val(commentId);
                    });
                    $('.delete-comment').on('click', function() {
                        var commentId = $(this).data('id');
                        var commentBody = $('#comment_' + commentId + ' p').text();
                       $.ajax({
                            url: "{{ url('api/delete-comment') }}"+"/"+commentId,
                            method: 'GET',
                            success: function(response) {
                                renderComment(response)
                            },    
                    })
    });
       };


       $('#button-comment').on('click', function(event) {
        event.preventDefault();
        var body = $('input[name="body"]').val();
        var user_id = $('input[name="user_id"]').val();
        var commentable_id = $('input[name="commentable_id"]').val();
        var commentable_type = $('input[name="commentable_type"]').val();
        var token = $('input[name="_token"]').val();
        var option = $('input[name="option"]').val();
        //console.log(option);
        if(user_id!=""){
            $.ajax({
                url: (option!=0)?("{{ url('api/update-comment') }}"+"/"+option):("{{ url('api/store-comment') }}"),
                method: 'GET',
                data: {
                    body:body,
                    user_id:user_id,
                    commentable_id:commentable_id,
                    commentable_type:commentable_type,
                    token:token
                },
                success: function(response) {
                    renderComment(response)
                },
                error: function(xhr) {
                    // Handle error
                    console.log(xhr.responseText);
                }
            });
        }
        else{
            Swal.fire({
                    title: "Chưa đăng nhập",
                    text: "Hãy đăng nhập để bình luận",
                    icon: "question"
                });
        }
    });

    $('.edit-comment').on('click', function() {
                        var commentId = $(this).data('id');
                        var commentBody = $('#comment_' + commentId + ' p').text();
                        $('input[name="body"]').val(commentBody);
                        $('input[name="option"]').val(commentId);
    });

    $('.delete-comment').on('click', function() {
                        var commentId = $(this).data('id');
                        var commentBody = $('#comment_' + commentId + ' p').text();
                       $.ajax({
                            url: "{{ url('api/delete-comment') }}"+"/"+commentId,
                            method: 'GET',
                            success: function(response) {
                                renderComment(response)
                            },    
                       })
    });
       
    });
    


   
    </script>
    {{-- SearchAjax --}}
    <script>

       $('.ajaxSearch').keyup(function(){
			var text = $(this).val();
            //alert(text);
			var html ='';
			var urlImage='';
			var urlPro='';
            if(text!=''){
                $.ajax({
                    url: "{{ url('api/search-product') }}"+'/'+text,
                    type: 'GET',
                    success: function(res){
                        if(res.length>0){
                            for(var pro of res){
                            urlImage="{{ url('/') }}"+'/'+pro.url;
                            urlPro="{{ url('/product') }}"+'/'+pro.id;
                            //html+='<li class="list-group-item  ">';
                            html+='<a class="list-group-item list-group-item-action d-flex p-2" href="'+urlPro+'">';
                                html+='<div class="d-flex align-items-center">';
                                html+=' <img width="40px" height="40px" src="'+urlImage+'" alt="">';
                                html+=' <span class="ml-3">'+pro.name+'</span>';
                                html+='</div>';
                            html+='</a>';                           
                            }
                            $('.resultSearch').html(html);
                        }
                        else{
                            html+='<a class="list-group-item list-group-item-action d-flex p-2" href="#"><i>Không có kết quả tìm kiếm</i><a>';
                            $('.resultSearch').html(html);
                        }
                
                    
                    }
                });
            }else{
                 
                $('.resultSearch').html('');
            }

	})
    </script>
  