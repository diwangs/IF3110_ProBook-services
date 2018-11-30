var username = document.querySelector('#username');
var password = document.querySelector('#password');
var loginButton = document.querySelector('#login-button');
var loginForm = document.querySelector('.login-form');
var usernameValidation = document.querySelector('#username-validation');
var passwordValidation = document.querySelector('#password-validation');

var fields = [
    username,
    password
];

var validations = [
    usernameValidation,
    passwordValidation
];

var checkLoginOk = function () {
    for (var i = 0; i < fields.length; i++) {
        if (fields[i].value === '') {
            return false;
        }
    }
    return true;
};

var validateInput = (field, validation) => {
    if (field.value === '') {
        validation.classList.remove('hidden');
        loginButton.disabled = true;
    } else {
        validation.classList.add('hidden');
        if (checkLoginOk()) {
            loginButton.disabled = false;
        }
    }

    return !!field.value;
};

for (var i = 0; i < fields.length; i++) {
  fields[i].onchange = ((i) => {
    validateInput(fields[i], validations[i]);
  }).bind(null, i);
  fields[i].onkeydown = ((i) => {
    validateInput(fields[i], validations[i]);
  }).bind(null, i);
  fields[i].onpaste = ((i) => {
    validateInput(fields[i], validations[i]);
  }).bind(null, i);
  fields[i].oninput = ((i) => {
    validateInput(fields[i], validations[i]);
  }).bind(null, i);
}

loginForm.onsubmit = () => {
    return checkLoginOk();
};