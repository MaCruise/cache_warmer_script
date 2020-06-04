
$('.alert-message').hide();
$('.form-dnone').hide();
$('.button-delete_form').on('click',function(event){
    event.preventDefault(); //Prevent the default submit
    $('.form-dnone').show();
    $('input[name="valueId"]').attr("value", $('.valueRowId').html());
    console.log( $('.input[name="valueID"]').attr('value', $('.valueRowId').text()));
});
$
$( document ).ready(function() {


    $(".fetch-form").on('click',function (event) { //Trigger on form submit
        event.preventDefault(); //Prevent the default submit
        event.stopPropagation();


        $('.throw_error').empty(); //Clear the messages first

        //Validate fields if required using jQuery
        var form = {name:$(this).closest('form').attr('name')};

        var formGetPostData = $(this).closest('form').serializeArray()

        /*formGetPostData = {};

       $(dataObj).each(function(i,field){
           formGetPostData[field.name] = field.value;
        })*/

        var urlRoute = 'routeController.php'

        console.log(form);


        console.log(formGetPostData);
        console.log(urlRoute);


        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: urlRoute, //Your form processing file URL
            data: {formGetPostData,form}, //Forms name
            dataType: 'json',
            success: function (data) {
                if (data !== '') {

                    if (data.errors) {
                        $('.alert-message').show();
                        $('.throw_error').html('<span class="throw_error">'+data.errors.name+'</span>');
                    } else {
                        $('.throw_error').html('<span class="throw_error">'+data.posted+'</span>');
                        $('.alert-message').removeClass("alert-warning").addClass("alert-success").show();
                        $('.form-dnone').hide();
                    }

                }
            },
            error: function () {
                alert('Something happend with the connection')
            },
        });
        return false;


    });
});
