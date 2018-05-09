$(document).ready(function () {
    $('#emailError').hide();
    $('#passwordError').hide();
    $('#errorAlert').hide();
    if (sessionStorage.id) window.location.href = "index.html";

});

function loginUser() {
    resetErrors();
    if (checkLoginForm()) {
        if (sessionStorage.id) {
            $.get("php/logout.php", {}, function (daten) {
                performLogin();
            });
        } else {
            performLogin();
        }
    }
}

function performLogin() {
    $.post("php/login.php",
        {
            email: $("#email").val(),
            password: sha256($("#password").val())
        }, function (result) {
            var response = JSON.parse(result);
            if (!response || response.status !== 200) {
                var error = $('#errorAlert');
                error.html(response.msg ? response.msg : "An error occurred. Try again later.");
                error.show();
            } else {
                sessionStorage.id = response.user.id;
                sessionStorage.name = response.user.name;
                sessionStorage.email = response.user.email;
                window.location.href = 'index.html';
            }
        });
}

function checkLoginForm() {
    var email = $('#email').val();
    var password = $('#password').val();

    var errors = 0;
    if (email == undefined || email.length == 0 || !validateEmail(email)) {
        errors++;
        $('#email').addClass('is-invalid');
        $('#emailError').show();
    }
    if (password == undefined || password.length < 6) {
        errors++;
        $('#password').addClass('is-invalid');
        $('#passwordError').show();
    }
    return errors == 0;
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function resetErrors() {
    $('#email').removeClass('is-invalid');
    $('#emailError').hide();
    $('#password').removeClass('is-invalid');
    $('#passwordError').hide();
    $('#errorAlert').hide();
}
