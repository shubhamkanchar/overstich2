const seller = () => {
    $("form").validate({
        rules:{
            product:'required'
        }
    });
}
export default seller;