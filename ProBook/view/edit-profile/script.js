var nameField = document.querySelector('#name');
var addressField = document.querySelector('#address');
var phoneNumberField = document.querySelector('#phone-number');
var form = document.querySelector('form');
var submitButton = document.querySelector('#save-button');
var nameValidation = document.querySelector('.validation.name');
var addressValidation = document.querySelector('.validation.address');
var phoneNumberValidation = document.querySelector('.validation.phone-number');
var phoneNumberValidationLength = document.querySelector('.validation.phone-number-length');

var fields = [
    nameField,
    addressField,
    phoneNumberField
];

var validations = [
    nameValidation,
    addressValidation,
    phoneNumberValidation
];

function checkSubmitOk() {
    for (var i = 0; i < fields.length; i++) {
        if (fields[i].value === '' || (fields[i].type === 'tel' && (fields[i].value.length < 9 || fields[i].value.length > 12))) {
            return false;
        }
    }
    return true;
}

function validateInput(field, validation) {
    if (field.value === '' || (field.type === 'tel' && (field.value.length < 9 || field.value.length > 12))) {
        validation.classList.remove('hidden');
        submitButton.disabled = true;
    } else {
        validation.classList.add('hidden');
        if (checkSubmitOk()) {
            submitButton.disabled = false;
        }
    }
}

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

form.onsubmit = () => {
    return checkSubmitOk();
};
