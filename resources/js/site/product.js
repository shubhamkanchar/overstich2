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

    $(document).on('keyup','#cgst, #sgst, #gst',function(){
        finalSellinPrice();
    })

    $(document).on('keyup','#netPrice',function(){
        priceCal();
        finalSellinPrice();
    })

    $(document).on('keyup','#discount',function() {
        priceCal();
        finalSellinPrice();
    })

    $(document).on('keyup','#gst',function(){
        $('#cgst').val($('#gst').val()/2);
        $('#sgst').val($('#gst').val()/2);
    })

    function priceCal(){
        let price = $('#netPrice').val();
        let discount = $('#discount').val();
        if(parseInt(price)>=0 && parseInt(discount)>=0) {
            let totalDiscount = (parseFloat(price) /100) * parseFloat(discount);
            let total = parseFloat(price) - parseFloat(totalDiscount);
            $('#price').val(total);
        }
    }

    function finalSellinPrice(){
        let price = $('#price').val();
        let cgst = $('#cgst').val();
        let sgst = $('#sgst').val();
        let gst = $('#gst').val();
        if(parseInt(price)>=0 && (parseInt(gst)>=0)) {
            let totalGst = (parseFloat(price) /100) * (parseFloat(gst));
            let total = parseFloat(totalGst) + parseFloat(price);
            $('#finalPrice').val(total);
        }
    }
}
export default product;