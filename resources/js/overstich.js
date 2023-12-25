import frontend from "./site/frontend";
import seller from "./site/seller";
import sellerProduct from "./site/seller-product";
const overstich = () => {

    $.validator.setDefaults({
        errorElement: 'div',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.parent().append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            
        }
    });

    $.validator.addMethod("fileCountRange", function(value, element, params) {
        var files = element.files;
        return files.length >= params[0] && files.length <= params[1];
    }, "Please upload exactly {0} files.");

    $.validator.addMethod("phone_number", function(phone_number, element) {
        return this.optional(element) || /^((\+)?\d{1,2}[\s]?)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/.test(phone_number);
    }, "Please enter a valid phone number");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    

    seller();
    frontend();
    if($('.seller-product').length != 0){
        sellerProduct();
    }
}
export default overstich();