
$('.alert-message').hide();
$('.form-dnone').hide();
$('.form-button_delete').on('click',function(event){
    event.preventDefault(); //Prevent the default submit
    $('.form-dnone').show();
    $('input[name="valueId"]').attr("value", $(this).closest('tr').find(".valueRowId").text());
});
$('.formEdit-button_delete').on('click',function(event){
    event.preventDefault(); //Prevent the default submit
    $('.form-dnone').show();
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


        var urlRoute = 'routeController.php'


        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: urlRoute, //Your form processing file URL
            data: {formGetPostData,form}, //Forms name
            dataType: 'json',
            success: function (data) {
                if (data !== '') {

                    if (data.errors) {

                        result = "";
                        for ( var i = 0; i < data.errors.error.length; i++ ) {
                            console.log(i)
                            result += '<span class="throw_error">'+data.errors.error[i]+'</span><br>'
                        }
                        $('.throw_error').append(result);
                        $('.alert-message').removeClass("alert-success").addClass("alert-warning").show();
                    } else {
                        $('.form-dnone').hide();
                        $('.throw_error').delay( ).html('<span class="throw_error">'+data.posted+'</span>');

                        $('.alert-message').removeClass("alert-warning").addClass("alert-success").show();


                    }

                }
            },
            error: function () {
                alert('Something happend with the connection')
            },
        });
        return false;


    });

    $(".flush-form").on('click',function (event) { //Trigger on form submit
        event.preventDefault(); //Prevent the default submit
        event.stopPropagation();


       /* $('.throw_error').empty(); //Clear the messages first

        //Validate fields if required using jQuery
        var form = {name:$(this).closest('form').attr('name')};

        var formGetPostData = $(this).closest('form').serializeArray()*/


        var urlRoute = 'controller/ErrorMessageController.php'


        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: urlRoute, //Your form processing file URL
            data: {formGetPostData,form}, //Forms name
            dataType: 'json',
            success: function (data) {
                if (data !== '') {

                    if (data.errors) {

                        result = "";
                        for ( var i = 0; i < data.errors.error.length; i++ ) {
                            result += '<span class="throw_error">'+data.errors.error[i]+'</span><br>'
                        }
                        $('.throw_error').append(result);
                        $('.alert-message').removeClass("alert-success").addClass("alert-warning").show();

                    } else {
                        $('.form-dnone').hide();
                        $('.throw_error').delay( ).html('<span class="throw_error">'+data.posted+'</span>');

                        $('.alert-message').removeClass("alert-warning").addClass("alert-success").show();

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
