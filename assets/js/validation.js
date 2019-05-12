$(document).ready(function () {

    let $ = jQuery;

    $.validator.addMethod("selected", function (value, element) {
        if (value == 0) {
            return false;
        } else {
            return true;
        }
    }, "Ce champ est obligatoire.");

    $.validator.addMethod("checkEmailExist", function (value, element) {
        let response = false;

        let post_url_check_email = baseurl + "user/check_email/";

        $.ajax({
            type: "POST",
            url: post_url_check_email,
            data: {email: value},
            dataType: "json",
            async: false
        }).done(function (result) {
            if (result.status == true) {
                response = false;
            } else {
                response = true;
            }
        });
        return response;
    }, "Email déjà utilisé.");
});
