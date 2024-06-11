//this validation for first form

$(document).ready(function () {

    //form validation js
    var form = $('#myForm');
    form.submit(function (e) {
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            async: false,
            success: function (json) {
                // Handle success response, if needed     
                return true;
            },
            error: function (json) {
                if (json.status === 422) {
                    e.preventDefault();
                    var errors_ = json.responseJSON;

                    // Reset error messages
                    form.find('.text-danger.error').text('');

                    // Display error messages
                    $.each(errors_.errors, function (key, value) {
                        $('.' + key).html(value);
                        // "<i class='feather icon-info'></i> " +                    
                    });
                }
            }

        });

    });

});
