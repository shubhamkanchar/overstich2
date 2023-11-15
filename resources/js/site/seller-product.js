const sellerProduct = () =>{
    $('#productForm').validate({
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
            size: {
                required: true
            },
            price: {
                required: true,
                number: true
            },
            stock: {
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
                fileCountRange: [5,5],
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
            size: {
                required: "Size is required."
            },
            price: {
                required: "Price is required.",
                number: "Please enter a valid number."
            },
            stock: {
                required: "Stock is required.",
                min: "Stock must be at least 1."
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
                fileCountRange: "Please upload exactly 5 file only"
            },
            description: {
                required: "Description is required.",
                
            }
        }
    });

    $('#productForm #category').on('change', function(){
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

}

export default sellerProduct;