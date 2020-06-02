$(document).ready(function() {
    $(".update_form").off('click').click(function(event) { //Trigger on form submit
        event.preventDefault() ; //Prevent the default submit
        event.stopPropagation() ;
        $('.throw_error').empty(); //Clear the messages first


        //Validate fields if required using jQuery


        var postForm = $(this).closest('form').serialize();

        var urlClass = $(this).closest('form').attr( 'id');

        /*var idMessage = $(this).closest('form').attr('action');*/




        $.ajax({ //Process the form using $.ajax()
            type      : 'POST', //Method type
            url       : urlClass, //Your form processing file URL
            data      : postForm, //Forms name
            dataType  : 'json',
            success   : function(data) {
                if(data !==''){
                    if(!data.errors)
                $('form[id="' + urlClass + '"]').fadeIn(1000).prepend("<div class='alert alert-warning alert-dismissible fade show' role='alert'>" + data.errors.name + "<a href='' type='button' class='close' data-dismiss='alert' aria-label='Close''><span aria-hidden='true'>&times;</span></a></div>");
                }else[]
            },
            error: function (data) {
                if(data !==''){
                    $('form[id="' + urlClass + '"]').fadeIn(1000).prepend("<div class='alert alert-warning alert-dismissible fade show' role='alert'>" + data.posted + "<a href='' type='button' class='close' data-dismiss='alert' aria-label='Close''><span aria-hidden='true'>&times;</span></a></div>");
                }
            }
        });
        return false;




    });
});
