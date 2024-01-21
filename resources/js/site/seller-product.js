const sellerProduct = () =>{
    let sizeNo = $(".size-row").length;
    const productForm = $('#productForm');
    productForm.validate({
        rules: {
            title: {
                required: true
            },
            brand: {
                required: true
            },
            category_id: {
                required: true
            },
            child_category_id: {
                required: true
            },
            'size[]': {
                required: true
            },
            price: {
                required: true,
                number: true
            },
            'quantity[]': {
                required: true,
                min: 1
            },
            discount: {
                number: true,
                range: [0, 100]
            },
            condition: {
                required: true
            },
            status: {
                required: true
            },
            'product_images[]': {
                required: true,
                fileCountRange: [5,7],
            }
        },
        messages: {
            title: {
                required: "Title is required."
            },
            brand: {
                required: "Brand is required."
            },
            category_id: {
                required: "Category is required"
            },
            child_category_id: {
                required: "Sub Category is required"
            },
            'size[]': {
                required: "Size is required."
            },
            price: {
                required: "Price is required.",
                number: "Please enter a valid number."
            },
            'quantity[]': {
                required: "quantity is required.",
                min: "quantity must be at least 1."
            },
            discount: {
                number: "Please enter a valid number.",
                range: "Discount must be between 0 and 100."
            },
            condition: {
                required: "Condition is required."
            },
            status: {
                required: "Status is required."
            },
            'images[]': {
                required: "Image is required.",
                fileCountRange: "Please add minimum 5 or maximum 7 file only"
            },
            description: {
                required: "Description is required.",
                
            }
        }
    });

    $('#productForm #masterCategory').on('change', function(){
        let category = $(this).val();
        let url = $(this).data('route');
        $.ajax({
            method:"get",
            url: url.replace(':categoryId', category),
            success: (res) =>{
                $('#subCategory').empty();
                $.each(res, function(key, value){
                    $('#subCategory').append($("<option></option>")
                    .attr("value", key)
                    .text(value)); 
                })
            },
            error: (err) => {

            }
        });
    })

    $('#masterCategory').trigger('change');
    $('#subCategory').trigger('change');
    $('#productForm #masterCategory').on('change', function(){
        let category = $(this).val();
        let url = $(this).data('route');
        $.ajax({
            method:"get",
            url: url.replace(':categoryId', category),
            success: (res) =>{
                $('#subCategory').empty();
                $.each(res, function(key, value){
                    $('#subCategory').append($("<option></option>")
                    .attr("value", key)
                    .text(value)); 
                })
                

                $('#subCategory').trigger('change');
            },
            error: (err) => {

            }
        });
    })

    $('#productForm #subCategory').on('change', function(){
        let category = $(this).val();
        let url = $(this).data('route');
        $.ajax({
            method:"get",
            url: url.replace(':categoryId', category),
            success: (res) =>{
                $('#category').empty();
                $.each(res, function(key, value){
                    $('#category').append($("<option></option>")
                    .attr("value", key)
                    .text(value)); 
                })
            },
            error: (err) => {

            }
        });
    })

    $(document).on('click', '.delete-product',function () {
        const deleteUrl = $(this).data('url');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'DELETE',
                    url: deleteUrl,
                    beforeSend: ()=>{
                        $('#popup-overlay').removeClass('d-none')
                        $('.spinner').removeClass('d-none')
                    },
                    success: (response) => {
                        window.location.reload();
                    },
                    error: (error) => {
                        window.location.reload();
                    },
                    complete: () => {
                        $('#popup-overlay').addClass('d-none')
                        $('.spinner').addClass('d-none')
                    }
                });
            }
        });
    });

    $('.image-form input[type="file"]').on('change', function () {
        let button = $($(this).data('target')).trigger('click');
        $('#popup-overlay').removeClass('d-none')
        $('.spinner').removeClass('d-none')
    });


    $("#sizeContainer").on("click", ".add-size-btn", function () {    
        var newSizeRow = $(".size-row:first").clone();
        newSizeRow.find('input.quantity-input').val('').attr('name', 'quantity['+sizeNo+']');
        newSizeRow.find('input.size-input').val('').attr('name', 'size['+sizeNo+']');
        newSizeRow.find('.add-size-row').remove();
        newSizeRow.append('<div class="col-4"><button type="button" class="btn btn-danger remove-size-btn">Remove</button></div>');
        $("#sizeContainer").append(newSizeRow);

        $('.quantity-input').each(function () {
            $(this).rules("add", {
                required: true,
                min: 0
            });
        });

        $('.size-input').each(function () {
            $(this).rules("add", {
                required: true
            });
        });

        sizeNo++;
    });

    $(document).on('click', '.remove-size-btn', function () {
        $(this).closest('.size-row').remove();
    });

}

export default sellerProduct;