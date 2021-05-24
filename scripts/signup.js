// let errors = [];

// function checkForm(){
//     const btnShow = document.getElementById('register');
//     if(errors.length == 0)
//     {
//         btnShow.disabled = false;
//     }else{
//         btnShow.disabled = true;  
//     }
// }

var status_name_ok = false;
var status_cognome_ok = false;
var status_username_ok = false;
var status_email_ok = false;
var status_pwd_ok = false;
var status_pwd_conferma_ok = false;
var status_acconsento_ok = false;

function tryEnableSubmit(){
    const canEnable = 
        status_name_ok && 
        status_cognome_ok && 
        status_username_ok &&
        status_email_ok &&
        status_pwd_ok &&
        status_pwd_conferma_ok &&
        status_acconsento_ok;

    const submitButton = document.getElementById("register");
    submitButton.disabled = !canEnable;
}

function checkName(){
    const spanElement = document.getElementById("span-name");
    const input = document.getElementById('name-field');
    if(!input.value || input.value === ''){
        spanElement.classList.remove("span-hide");
        spanElement.classList.add("span-show");
        status_name_ok = false;
    }
    else{
        // input valido
        spanElement.classList.add("span-hide");
        spanElement.classList.remove("span-show");
        status_name_ok = true;
    }
    tryEnableSubmit();
}

function checkSurname(){
    const spanElement = document.getElementById("span-surname");
    const input = document.getElementById('surname-field');
    if(!input.value || input.value === ''){
        spanElement.classList.remove("span-hide");
        spanElement.classList.add("span-show");
        status_cognome_ok = false;
    }
    else{
        // input valido
        spanElement.classList.add("span-hide");
        spanElement.classList.remove("span-show");
        status_cognome_ok = true;
    } 
    tryEnableSubmit();
}

function checkUsername() {
    const spanElement = document.getElementById("span-username");
    const input = document.getElementById('username-field');
    
    if(!/^[a-zA-Z0-9_]{1,15}$/.test(input.value)) {
        spanElement.classList.remove("span-hide");
        spanElement.classList.add("span-show");
        status_username_ok = false;
    } else {
        spanElement.classList.add("span-hide");
        spanElement.classList.remove("span-show");
        status_username_ok = true;
    }    
    tryEnableSubmit();
}

function checkEmail(){
    const spanElement = document.getElementById("span-email");
    const input = document.getElementById('email-field');

    // Controlliamo se il campo è stato riempito, in caso contrario viene aggiunta la classe "errorj"
    if(!/^[A-z0-9\.\+_-]+@[A-z0-9\._-]+\.[A-z]{2,6}$/.test(input.value)){
        spanElement.classList.remove("span-hide");
        spanElement.classList.add("span-show");
        status_email_ok = false;
    } else{
        spanElement.classList.add("span-hide");
        spanElement.classList.remove("span-show");
        status_email_ok = true;
    }
    tryEnableSubmit();
}

function checkPassword(){
    const spanElement = document.getElementById("span-password");
    const input = document.getElementById('password-field');

    if(input.value.length < 8){
        spanElement.classList.remove("span-hide");
        spanElement.classList.add("span-show");
        status_pwd_ok = false;
    } else{
        spanElement.classList.add("span-hide");
        spanElement.classList.remove("span-show");
        status_pwd_ok = true;
    }
    tryEnableSubmit();
}

function checkConfirmPassword(){
    const spanElement = document.getElementById("span-confirm_password");
    const input = document.getElementById('confirm_password-field');    
    const passwordField = document.getElementById('password-field');

    if(input.value !== passwordField.value){
        spanElement.classList.remove("span-hide");
        spanElement.classList.add("span-show");
        status_pwd_conferma_ok = false;
    } else{
        spanElement.classList.add("span-hide");
        spanElement.classList.remove("span-show");
        status_pwd_conferma_ok = true;
    }
    tryEnableSubmit();
}

function checkAllow(){
    const spanElement = document.getElementById("span-allow");
    if(document.getElementById('smallBox').checked)
    {
        spanElement.classList.add("span-hide");
        spanElement.classList.remove("span-show");
        status_acconsento_ok = true;
    } else{
        spanElement.classList.remove("span-hide");
        spanElement.classList.add("span-show");
        status_acconsento_ok = false;
    }
    tryEnableSubmit();
}