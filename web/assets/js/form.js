$(function () {
    function postForm($form, callback) {
        const values = {};
        $.each($form.serializeArray(), function (i, field) {
            values[field.name] = field.value;
        });
	
	//Test for bots
	var tampered = false;
	var time = document.getElementById('ms_contact_us_asdf').value;
	if(!time){
	    console.log("Time tampered with.");
	    tampered = true;
	}
	if(isNaN(time)){
	    console.log("Time tampered with.");
	    tampered = true;
	}
	var time_past = new Date().getTime() / 1000;
	time_past = time_past - time;	
	if (time_past > 84600) {
	    console.log("Time tampered with.");
	    tampered = true;
	}
	if(time_past < 7){
	    console.log("Time tampered with.");
	    tampered = true;
	}

	if(tampered === false){
        $.ajax({
            type   : "POST",
            url    :  $form.attr('action'),
            data   : values,
            success: function (data) {
                callback(data);
            }
        });
	}else{
	    alert("There was an error processing your request, please try again.");
	}
    }

    $(".complete-form").on('submit', function (e) {
        e.preventDefault();
        const form = this;
        postForm($(this), function (data) {
            if (data.status === 'ok') {
                $('.complete-form .error-text').empty();
                $(".complete-form").css("visibility", "hidden");
		$(".complete-form").css("display", "none");
                $(".after-submit").css("visibility", "initial" );
		$(".after-submit").css("display", "block" );
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
	$(".complete-form").css("display", "block");
        $(".after-submit").css('visibility', 'hidden');
	$(".after-submit").css("display", "none" );
    });
});

