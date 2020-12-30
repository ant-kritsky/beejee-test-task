$(document).ready(function () {
    $.validator.setDefaults({
        highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block error',
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });

    $('#loginForm').validate({
        rules: {
            login: {
                maxlength: 150,
                required: true
            },
            password: {
                maxlength: 150,
                required: true
            }
        }
    });

    $('#addTask').validate({
        rules: {
            name: {
                minlength: 3,
                maxlength: 150,
                required: true
            },
            email: {
                minlength: 3,
                maxlength: 150,
                required: true,
                email: true
            },
            description: {
                minlength: 3,
                maxlength: 500,
                required: true
            }
        }
    });

    $('.editable').bind('click', function () {
        var field = $(this);
        if (field.data('editing') == undefined) {
            field.data('editing', true);
            var input = $('<textarea>').val(field.text().trim());
            $(this).html(input).find('textarea').focus();

            $('.editable textarea').bind('blur', function () {
                var text = $(this).val(),
                    parentField = $(this).parent();

                $.ajax({
                    url: "/update",
                    type: "POST",
                    data: {id: parentField.data('id'), text: text},
                    success: function (data) {
                        if (data == 'success') {
                            parentField.removeData('editing');
                            parentField.text(text);
                        } else {
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});