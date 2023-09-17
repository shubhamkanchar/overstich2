import { Modal } from "bootstrap";

const seller = () => {
    $.validator.addMethod("maxupload", function(value, element, param) {
        var $fileUpload = $("input[type='file']");
        if (parseInt($fileUpload.get(0).files.length) >= 5){
            return true;
        }
    }, "Please upload 5 files");

    $.validator.addMethod("minupload", function(value, element, param) {
        var $fileUpload = $("input[type='file']");
        if (parseInt($fileUpload.get(0).files.length) <= 5){
            return true;
        }
    }, "Please upload 5 files");

    $("form").validate({
        rules:{
            product:'required',
            gst:'required',
            brand:'required',
            mail:{
                required:true,
                email:true
            },
            'product_photos[]':{
                required:true,
                'maxupload' : 5,
                'minupload' : 5
            },
            whatsapp:'required',
            category:'required',
            price_range:'required',
            address_line:'required',
            locality:'required',
            city:'required',
            state:'required',
            pincode:'required',
            account:'required',
            ifsc:'required',
            password: "required",
            c_password: {
                equalTo: "#password"
            }
        }
    });

    if($('#guideline1').length > 0){
    let modal = new Modal(document.getElementById('guideline1'));
    modal.show();
    }

    $(document).on('click','.modal1',function(){
        if($('.guideline2').is(':checked')){
            Modal.getInstance(document.getElementById('guideline2')).hide();
            let modal1 = new Modal(document.getElementById('guideline3'));
            modal1.show();
            $('.modal1_noti').addClass('d-none');
        }else{
            $('.modal1_noti').removeClass('d-none');
        }
    });

    $(document).on('click','.guideline2',function(){
        if($(this).is(":checked")) {
            $('.modal1_noti').addClass('d-none');
        }  
    });

    $(document).on('click','.modal2',function(){
        if($('.guideline5').is(':checked')){
            Modal.getInstance(document.getElementById('guideline5')).hide();
            let modal1 = new Modal(document.getElementById('guideline6'));
            modal1.show();
            $('.modal2_noti').addClass('d-none');
        }else{
            $('.modal2_noti').removeClass('d-none');
        }
    });

    $(document).on('click','.guideline5',function(){
        if($(this).is(":checked")) {
            $('.modal2_noti').addClass('d-none');
        }  
    });

    $(document).on('click','.modal3',function(){
        if($('.guideline6').is(':checked')){
            Modal.getInstance(document.getElementById('guideline6')).hide();
            $('.modal3_noti').addClass('d-none');
        }else{
            $('.modal3_noti').removeClass('d-none');
        }
    });

    $(document).on('click','.guideline6',function(){
        if($(this).is(":checked")) {
            $('.modal3_noti').addClass('d-none');
        }  
    });
}
export default seller;