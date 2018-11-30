var xmlhttp = new XMLHttpRequest();
let username_stat = '';
let email_stat = '';
var searchDelay = null

function validateFullname() {
    var fullname = document.getElementById('fullname').value;
    var fullnameValidationText = document.getElementById('fullname-validation-text')
    if (fullname.length === 0) {
        fullnameValidationText.innerHTML = 'This field is required';
        return false;
    } else {
        fullnameValidationText.innerHTML = '';
        return true;
    }
}

var fullname = document.getElementById('fullname');
fullname.onchange = validateFullname;

function addUsernameValidation() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var usernameValidationIcon = document.getElementById('username-validation-icon');
        var usernameValidationText = document.getElementById('username-validation-text');    
        username_stat = xmlhttp.responseText;
        if (username_stat === 'taken') {
            usernameValidationIcon.innerHTML = '<img src="/assets/images/wrong.png">';
            usernameValidationText.innerHTML = 'Username is already taken';
            return false;
        } else if (username_stat === 'available') {
            usernameValidationIcon.innerHTML = '<img src="/assets/images/right.png">';
            usernameValidationText.innerHTML = '';
            return true;
        }
    }
}

function getUsername(username) {
    var qry = 'username=' + username;
    var url = '/controller/register.php?' + qry;
    xmlhttp.open('GET', url, true);
    xmlhttp.onreadystatechange = addUsernameValidation;
    xmlhttp.send(null);
}

function validateUsername() {
    var username = document.getElementById('username').value;
    var usernameValidationIcon = document.getElementById('username-validation-icon');
    var usernameValidationText = document.getElementById('username-validation-text');
    if (username.length === 0) {
        usernameValidationIcon.innerHTML = '<img src="/assets/images/wrong.png">';
        usernameValidationText.innerHTML = 'This field is required';
        return false;
    } else if (/\s/.test(username)) {
        usernameValidationIcon.innerHTML = '<img src="/assets/images/wrong.png">';
        usernameValidationText.innerHTML = 'Username must not contain whitespace';
        return false
    } else if (username.length > 20) {
        usernameValidationIcon.innerHTML = '<img src="/assets/images/wrong.png">';
        usernameValidationText.innerHTML = 'Username must not exceed 20 characters';
        return false;
    } else {
        getUsername(username);
        if (username_stat === 'taken') {
            return false;
        } else if (username_stat === 'available') {
            return true;
        }
    }
}

var username = document.getElementById('username');
username.onchange = validateUsername;

function addEmailValidation() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var emailValidationIcon = document.getElementById('email-validation-icon');
        var emailValidationText = document.getElementById('email-validation-text');
        email_stat = xmlhttp.responseText;
        if (email_stat === 'taken') {
            emailValidationIcon.innerHTML = '<img src="/assets/images/wrong.png">';
            emailValidationText.innerHTML = 'Email has been used';
            return false;
        } else if (email_stat === 'available') {
            emailValidationIcon.innerHTML = '<img src="/assets/images/right.png">';
            emailValidationText.innerHTML = '';
            return true;
        }
    }
}

function getEmail(email) {
    var qry = 'email=' + email;
    var url = '/controller/register.php?' + qry;
    xmlhttp.open('GET', url, true);
    xmlhttp.onreadystatechange = addEmailValidation;
    xmlhttp.send(null);
}

function validateEmail() {
    var email = document.getElementById('email').value;
    var emailValidationIcon = document.getElementById('email-validation-icon');
    var emailValidationText = document.getElementById('email-validation-text');
    var re = /[a-z0-9\._%+!$&*=^|~#%'`?{}/\-]+@([a-z0-9\-]+\.){1,}([a-z]{2,16})/;
    if (email.length === 0) {
        emailValidationIcon.innerHTML = '<img src="/assets/images/wrong.png">';
        emailValidationText.innerHTML = 'This field is required';
        return false;
    } else if (! re.test(String(email).toLowerCase())) {
        emailValidationIcon.innerHTML = '<img src="/assets/images/wrong.png">';
        emailValidationText.innerHTML = 'Email is invalid';
        return false;
    } else {
        getEmail(email);
        if (email_stat === 'taken') {
            return false;
        } else if (email_stat === 'available') {
            return true;
        }
    }
}

var email = document.getElementById('email');
email.onchange = validateEmail;


function validatePassword() {
    var password = document.getElementById('password').value;
    var passwordValidationText = document.getElementById('password-validation-text')
    if (password.length === 0) {
        passwordValidationText.innerHTML = 'This field is required';
        return false;
    } else {
        passwordValidationText.innerHTML = '';
        return true;
    }
}

var password = document.getElementById('password');
password.onchange = validatePassword;


function validateConfirmPassword() {
    var confirmpassword = document.getElementById('confirmpassword').value;
    var confirmPasswordValidationText = document.getElementById('confirmpassword-validation-text')
    if (confirmpassword.length === 0) {
        confirmPasswordValidationText.innerHTML = 'This field is required';
        return false;
    } else {
        var password = document.getElementById('password').value;
        if (password !== confirmpassword) {
            confirmPasswordValidationText.innerHTML = 'Password doesn\'t match';
            return false;
        } else {
            confirmPasswordValidationText.innerHTML = '';
            return true;
        }
    }
}

var confirmpassword = document.getElementById('confirmpassword');
confirmpassword.onchange = validateConfirmPassword;

function validateAddress() {
    var address = document.getElementById('address').value;
    var addressValidationText = document.getElementById('address-validation-text')
    if (address.length === 0) {
        addressValidationText.innerHTML = 'This field is required';
        return false;
    } else {
        addressValidationText.innerHTML = '';
        return true;
    }
}

var address = document.getElementById('address');
address.onchange = validateAddress;

function validatePhonenumber() {
    var phonenumber = document.getElementById('phonenumber').value;
    var phonenumberValidationText = document.getElementById('phonenumber-validation-text')
    if (phonenumber.length === 0) {
        phonenumberValidationText.innerHTML = 'This field is required';
    } else if (!(/^[0-9]*$/.test(phonenumber))) {
        phonenumberValidationText.innerHTML = 'Phone number must only contain number';
        return false;
    } else if (phonenumber.length < 9) {
        phonenumberValidationText.innerHTML = 'Phone number must have at least 9 numbers';
        return false;
    } else if (phonenumber.length > 12) {
        phonenumberValidationText.innerHTML = 'Phone number must not exceed 12 numbers';
        return false;
    } else {
        phonenumberValidationText.innerHTML = '';
        return true;
    }
}

var phonenumber = document.getElementById('phonenumber');
phonenumber.onchange = validatePhonenumber;

function validateCardnumber() {
    var cardnumber = document.getElementById('cardnumber').value;
    var cardnumberValidationText = document.getElementById('cardnumber-validation-text')
    if (cardnumber.length === 0) {
        cardnumberValidationText.innerHTML = 'This field is required';
    } else if (!(/^[0-9]*$/.test(cardnumber))) {
        cardnumberValidationText.innerHTML = 'Phone number must only contain number';
        return false;
    } else {
        cardnumberValidationText.innerHTML = '';
        return true;
    }
}

var cardnumber = document.getElementById('cardnumber');
cardnumber.onchange = validateCardnumber;

function validate(id) {
    clearTimeout(searchDelay)
    setTimeout(() => {
        req = new XMLHttpRequest()
        req.onload = () => {
            console.log(JSON.parse(req.responseText).result)
            // Apa yg dilakukan setelah mendapat jawaban
            if (!JSON.parse(req.responseText).result) {
                document.getElementById("isValid").innerHTML = "credit card number not found"
                return false;
            } else {
                return true;
            }
        }
        req.open("GET", "http://localhost:3000/api/validate_customer/" + encodeURIComponent(id), true)
        req.send()
    }, 1000)
}

var registerForm = document.querySelector('.register-form');

registerForm.onsubmit = () => {
    validateFullname();
    validateUsername();
    validateEmail();
    validatePassword();
    validateConfirmPassword();
    validateAddress();
    validatePhonenumber();
    validateCardnumber();
    validate(cardnumber);
    if (! (validateFullname() && validateUsername() && validateEmail() && validatePassword() && validateConfirmPassword() && validateAddress() && validatePhonenumber() && validateCardnumber()  && validate(cardnumber)) ) {
        return false;
    } else {
        return true;
    }
}