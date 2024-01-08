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
}
export default category;