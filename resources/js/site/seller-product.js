const sellerProduct = () =>{
    let sizeNo = $(".size-row").length;
    let index = $('.filter-row').length;
    let maxFilters = $('.filter-row').data('max');
    let getFilterUrl = $('.filter-row').data('route');
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
            hsn: {
                required: true,
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
            'types[]': {
                required: true,
                checkSelected: true
            },
            'type_values[]': {
                required: true,
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
            },
            hsn: {
                required: "Description is required.",
            },
            'types[]': {
                required: "Please select a filter type",
                checkSelected: "Filter type must be unique"
            },
            'type_values[]': {
                required: "Please select a value",
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

    // $('#masterCategory').trigger('change');
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
                $('#category').html($("<option value='' selected disabled>Category Type</option>"))
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

    $('#productForm #masterCategory').on('change', function(){
        let category = $(this).val();
        let url = $('#category').data('route');
        if($('.add-filter').hasClass('disabled')) {
            $('.add-filter').attr('disabled', false)
            $('.add-filter').removeClass('disabled')
        }
        $('.filter-row:not(:first)').remove();
        $.ajax({
            method:"get",
            url: url.replace(':categoryId', category),
            success: (res) => {
                maxFilters = Object.keys(res).length;
                $('.filter-type').html($("<option value=''>Select Filter type</option>"));
                $('.filter-values').html($("<option value=''>Select Value</option>"));
                $.each(res, function(key, value) {
                    console.log(key, value);
                    $('.filter-type').append($("<option></option>")
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

    $('.add-filter').on('click', function () {
        if($('.filter-row').length < maxFilters) {
            var newRow = $('.filter-row:first').clone();
            newRow.find('.filter_id').remove(); 
            newRow.find('select[name="types[0]"]').data('target','#filterValue'+index);
            newRow.find('select[name="types[0]"]').val('');
            newRow.find('select[name="types[0]"]').attr('name', 'types[' + index + ']');
            newRow.find('select[name="type_values[0]"]').attr('id', 'filterValue'+index);
            newRow.find('select[name="type_values[0]"]').empty();
            newRow.find('select[name="type_values[0]"]').append($("<option value=''>Select Value</option>"));
            newRow.find('select[name="type_values[0]"]').attr('name', 'type_values[' + index + ']');
            newRow.find('button.add-filter').removeClass('add-filter').addClass('remove btn-danger').text('Remove');
            $('.filter-row:last').after(newRow);
            index++;
        } else {
            $('.add-filter').prop('disabled', true)
            $('.add-filter').addClass('disabled')
        }
    });

    $('.container').on('click', '.remove', function () {
        $(this).closest('.filter-row').remove();
        if($('.add-filter').hasClass('disabled')) {
            $('.add-filter').attr('disabled', false)
            $('.add-filter').removeClass('disabled')
        }
    });

    $(document).on('change', '.filter-type',function(){
        let categoryFilter = $(this).val();
        let targetId = $(this).data('target');
        $.ajax({
            method:"get",
            url: getFilterUrl.replace(':categoryFilter', categoryFilter),
            success: (res) =>{
                $(targetId).empty();
                $(targetId).append($("<option value=''>Select Value</option>"))
                let values = JSON.parse(res.categoryFilter.value);
                $.each(values, function(key, value){
                    $(targetId).append($("<option></option>")
                    .attr("value", value)
                    .text(value)); 
                })
            },
            error: (err) => {

            }
        });
        console.log(checkSelected(categoryFilter, $(this)), );
    })

    function checkSelected(val, element) {
        var ret = false;
        $(".filter-type").not(element).each(function() {
            if ($(this).val() === val) {
                ret = true;
            }
        });
        return ret;
    }

    $.validator.addMethod("checkSelected", function(value, element) {
        return checkSelected(val, element);
    }, "Filter type must be unique");

    $('#productfilter').validate({
        rules: {
            'types[]': {
                required: true,
                checkSelected: true
            },
            'type_values[]': {
                required: true,
            },
        },
        messages: {
            'types[]': {
                required: "Please select a filter type",
                checkSelected: "Filter type must be unique"
            },
            'type_values[]': {
                required: "Please select a value",
            },
        },
    
    });

}

export default sellerProduct;