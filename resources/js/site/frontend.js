const frontend = () => {
    $('.size-label').on('click', function() {
        $('.size-label').removeClass('border-2 border-black');
        $(this).addClass('border-2 border-black');
        $('input[name="quantity"]').attr('max', $(this).data('max'));
        $('#' + $(this).attr('for')).prop('checked', true);
    })

    $('#checkoutForm').validate({
        rules: {
            first_name: 'required',
            last_name: 'required',
            mobile: {
                required: true,
                phone_number : true,
            },
            email: {
                required: true,
                email: true
            },
            address: 'required',
            pincode: {
                required: true,
                digits: true,
                minlength: 6,
                maxlength: 6
            },
            locality: 'required',
            city: 'required',
            state: 'required'
        },
        messages: {
            first_name: 'Please enter your first name',
            last_name: 'Please enter your last name',
            mobile: {
                required: 'Please enter your mobile number',
                digits: 'Please enter a valid mobile number',
                minlength: 'Please enter a 10-digit mobile number',
                maxlength: 'Please enter a 10-digit mobile number'
            },
            email: {
                required: 'Please enter your email address',
                email: 'Please enter a valid email address'
            },
            address: 'Please enter your address',
            pincode: {
                required: 'Please enter your pincode',
                digits: 'Please enter a valid pincode',
                minlength: 'Please enter a valid pincode',
                maxlength: 'Please enter a valid pincode'
            },
            locality: 'Please enter your locality',
            city: 'Please enter your city',
            state: 'Please enter your state'
        },
    });

    $('.add-to-wishlist').on('click', function() {
        let product = $(this);
        let url = '';
        let method = ''
        if(product.hasClass('bi-heart-fill')) {
            product.removeClass('bi-heart-fill text-danger');
            product.addClass('bi-heart');
            url = $(this).data('remove-route');
            method = 'DELETE';
            
        } else {
            url = $(this).data('add-route');
            product.addClass('bi-heart-fill text-danger');
            product.removeClass('bi-heart');
            method = 'POST';
        }

        $.ajax({
            url: url,
            type: method,
            success: function(response) {
                
            },
            error: function(error) {
                console.log(error);
            }
        });

        
    });

    $("#paymentMethod").on('change', function () {
        var selectedPaymentMethod = $("#paymentMethod option:selected").data('target');
        $('.payment-fields').hide();
        $(selectedPaymentMethod).fadeIn();

    });

    $('.show-subcategory').on('click', function() {
        var targetId = $(this).data('target');
        var targetParentId = $(this).closest('.main-category').attr('id');
        $('.child-categories').not(targetId).hide();
        $(targetId).toggle();
    })

    $('.show-sm-subcategory').on('click', function() { 
        $('.category-menu').addClass('position-absolute top-0 left-0');
        $('.navbar').toggle();
        var targetId = $(this).data('target');
        var targetParentId = $(this).closest('.main-category').attr('id');
        $('.child-categories').not(targetId).hide();
        $(targetId).toggle();
    })

    $('.close-category-menu').on('click', function() { 
        $('.category-menu').removeClass('position-absolute top-0 left-0');
        $('.child-categories').hide();
        $('.child-categories childs').addClass('d-none');
        $('.navbar').show();
    } )

    let fadeOut = true;
    $('.show-md-subcategory,.child-categories').hover(function(){
    var newWindowWidth = $(window).width();
    if (newWindowWidth > 576) {
        var targetId = $(this).data('target');
        fadeOut = false;
        var targetParentId = $(this).closest('.main-category').attr('id');
        $('.child-categories').not(targetId).hide();
        $(targetId).fadeIn();
    }
    }, function(){
        
        var newWindowWidth = $(window).width();
        if (newWindowWidth > 576) {
            var targetId = $(this).data('target');
            var targetParentId = $(this).closest('.main-category').attr('id');
            $('.child-categories').not(targetId).hide();
            fadeOut = true;
            setTimeout(function() {
                if(fadeOut) {
                    $(targetId).fadeOut(fadeOut);
                }
            }, 100)
        }
    });

    $('.navbar').on('hidden.bs.collapse', function() {
        $('.child-categories').hide();
        $('.childs').addClass('d-none');
        $('.main-category').show();
        $('.nav-right-content').show();
    })

    $('.show-nested-subcategory').on('click', function() {
        var targetId = $(this).data('target');
        console.log(targetId)

        $(this).find('.childs').not(targetId).hide();
        $(targetId).toggleClass('d-none');
    })

}

export default frontend;