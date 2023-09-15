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

    // $('#guideline').modal('show');
    let modal = new Modal(document.getElementById('guideline1'));
    modal.show();
}
export default seller;