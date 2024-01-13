const category = () =>{
    $('#categoryForm #masterCategory').on('change', function(){
        let category = $(this).val();
        let url = $(this).data('route');
        $.ajax({
            method:"get",
            url: url.replace(':categoryId', category),
            success: (res) =>{
                $('#subCategory').empty();
                $('#subCategory').append($("<option value=''>Sub Category</option>"))
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

    var index = $('.filter-row').length;

    $('.add-filter').on('click', function () {
        var newRow = $('.filter-row:first').clone();
        newRow.find('input').val('');  // Clear input values
        newRow.find('.filter_id').remove(); 
        newRow.find('input[name="types[0]"]').attr('name', 'types[' + index + ']');
        newRow.find('input[name="types[0]"]').attr('placeholder', 'Category Type');
        newRow.find('input[name="type_values[0]"]').attr('name', 'type_values[' + index + ']');
        newRow.find('input[name="type_values[0]"]').attr('placeholder', 'Add multiple value by comma separate');
        newRow.find('button.add-filter').removeClass('add-filter').addClass('remove btn-danger').text('Remove');
        $('.filter-row:last').after(newRow);
        index++;
    });

    $('.container').on('click', '.remove', function () {
        $(this).closest('.filter-row').remove();
    });
}
export default category;