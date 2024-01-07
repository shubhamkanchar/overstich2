const product = () =>{
    $('#pincodeForm').validate({
        rules:{
            pincode:'required'
        }
    })

    $(document).on('submit','#pincodeForm',function(e){
        e.preventDefault();
        $.ajax({
            url:$(this).attr('action'),
            type:'POST',
            data:{'pincode':$('#pincode').val()},
            success:function(res){
                res = JSON.parse(res);
                let data = res.delivery_codes;
                if(data.length > 0){
                    $('#pincodeMsg').html('<span class="text-primary">Service available at this pincode</span>');
                }else{
                    $('#pincodeMsg').html('<span class="text-danger">Sorry! service not available at this pincode</span>');
                }
            },
            error:function(res){

            }
        })
    })
}
export default product;