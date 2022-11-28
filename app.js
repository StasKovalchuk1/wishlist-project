function init(){
    const formElement = document.querySelector("#form");
    if(formElement){
        formElement.addEventListener("submit", validate);
    }
}

function validate(event){
    var name = document.querySelector(".login").value;
    var password = document.querySelector(".password").value;
    var confirm = document.querySelector(".confirm").value;
    if (name.length < 5) {
        event.preventDefault();
        alert("Jmeno min. 5 znaku!");
    }
    else if (password.length < 8 || password!=confirm){
        event.preventDefault();
        alert("Something wrong with your password!");
    }
}



