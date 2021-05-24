function toggleModal(event){
    event.preventDefault();
    document.querySelector('.modal').setAttribute('style', 'display:none');
}

function addModal(event){
    event.preventDefault();
    document.querySelector('.modal').setAttribute('style', 'display:flex');    
}

document.getElementById('text').addEventListener('click', addModal);


document.getElementById('x_close').addEventListener('click', toggleModal);


function tryEnableSubmit(){
    const canEnable = status_text_ok;

    const submitButton = document.getElementById("add_post");
    submitButton.disabled = !canEnable;
}

function checkText(){
    const spanElement = document.getElementById("span-text");
    const input = document.getElementById('text_area');
    if(!input.value || input.value === ''){
        spanElement.classList.remove("span-hide");
        spanElement.classList.add("span-show");
        status_text_ok = false;

    }
    else{
        // input valido
        spanElement.classList.add("span-hide");
        spanElement.classList.remove("span-show");
        status_text_ok = true;
    }

    tryEnableSubmit();
}

let status_text_ok = false;