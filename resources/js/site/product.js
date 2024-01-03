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
                    $('#pincodeMsg').html('Service available at this pincode');
                }else{
                    $('#pincodeMsg').html('Sorry! service not available at this pincode');
                }
            },
            error:function(res){

            }
        })
    })
}
export default product;