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
    $(document).on('keyup','#netPrice , #cgst, #sgst',function(){
        priceCal();
    })
    function priceCal(){
        let netPrice = $('#netPrice').val();
        let cgst = $('#cgst').val();
        let sgst = $('#sgst').val();
        let totalGst = (parseFloat(netPrice) /100) * (parseFloat(cgst) + parseFloat(sgst));
        let total = parseFloat(totalGst) + parseFloat(netPrice);
        $('#price').val(total);
    }

    $(document).on('keyup','#discount',function(){
        finalSellinPrice();
    })
    function finalSellinPrice(){
        let price = $('#price').val();
        let discount = $('#discount').val();
        let totalDiscount = (parseFloat(price) /100) * parseFloat(discount);
        let total = parseFloat(price) - parseFloat(totalDiscount);
        $('#finalPrice').val(total);
    }
}
export default product;