$(function () {
    function postForm($form, callback) {
        const values = {};
        $.each($form.serializeArray(), function (i, field) {
            values[field.name] = field.value;
        });

        $.ajax({
            type   : "POST",
            url    :  $form.attr('action'),
            data   : values,
            success: function (data) {
                callback(data);
            }
        });
    }

    $(".complete-form").on('submit', function (e) {
        e.preventDefault();
        const form = this;
        postForm($(this), function (data) {
            if (data.status === 'ok') {
                $('.complete-form .error-text').empty();
                $(".complete-form").css("visibility", "hidden");
                $(".after-submit").css("visibility", "initial" );
            } else {
                $('.complete-form .error-text').remove();

                for (let key in data.errors) {
                    if (data.errors.hasOwnProperty(key)) {
                        const elName = "[name='" +$(form).attr('name') + "[" + key + "]']";
                        const element = $(elName);
                        const errorElement = document.createElement('ul');
                        errorElement.className = 'error-text';

                        if (data.errors[key] !== undefined) {
                            data.errors[key].forEach(function (val) {
                                const errorMsg = document.createElement('li');
                                errorMsg.appendChild(document.createTextNode(val));
                                errorElement.appendChild(errorMsg);
                            });
                        }
                        $(element).after($(errorElement));
                    }
                }
            }
        });
    });

    $('.ok-btn').on('click', function () {
        $(".complete-form").css("visibility", "inherit").trigger('reset');
        $(".after-submit").css('visibility', 'hidden');
    });
});

