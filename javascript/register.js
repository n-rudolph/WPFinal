$( document ).ready(function() {
  $('#firstnameError').hide();
  $('#lastnameError').hide();
  $('#emailError').hide();
  $('#passwordError').hide();
});

function registerUser() {
  resetErrors();
  if (checkRegistrationForm()) {
    // todo: uncomment post

    $.post("php/register.php",
    {
      name: $("#firstname").val(),
      lastname: $("#lastname").val(),
      email: $("#email").val(),
      password: sha256($("#password").val())
    }, function(result) {
      console.log(result);
      //window.location.href = 'index.html';
    });
  }
}

function checkRegistrationForm() {
  var firstname = $('#firstname').val();
  var lastname = $('#lastname').val();
  var email = $('#email').val();
  var password = $('#password').val();

  var errors = 0;
  if (firstname == undefined || firstname.length == 0) {
    errors++;
    $('#firstname').addClass('is-invalid');
    $('#firstnameError').show();
  }
  if (lastname == undefined || lastname.length == 0) {
    errors++;
    $('#lastname').addClass('is-invalid');
    $('#lastnameError').show();
  }
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
  $('#firstname').removeClass('is-invalid');
  $('#firstnameError').hide();
  $('#lastname').removeClass('is-invalid');
  $('#lastnameError').hide();
  $('#email').removeClass('is-invalid');
  $('#emailError').hide();
  $('#password').removeClass('is-invalid');
  $('#passwordError').hide();
}
