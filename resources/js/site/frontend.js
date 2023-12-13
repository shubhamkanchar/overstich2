const frontend = () => {
    $('.size-label').on('click', function() {
        $('.size-label').removeClass('border-2 border-black');
        $(this).addClass('border-2 border-black');
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
        let url = $(this).data('route');
        console.log(url)
        let product = $(this);
        console.log(product)
        $.ajax({
            url: url,
            method: 'POST',
            success: function(response) {
                if(response.added) {
                    product.addClass('bi-heart-fill text-danger');
                    product.removeClass('bi-heart');
                } else {
                    product.removeClass('bi-heart-fill text-danger');
                    product.addClass('bi-heart');
                }
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
        console.log(targetId)
        $('.child-categories').not(targetId).hide();
        $(targetId).toggle();
    })
}

export default frontend;