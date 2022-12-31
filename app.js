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
        let x = document.getElementById('err1');
        x.innerHTML = "<p>Minimum 5 letters</p>";
    }
    if (password.length < 8){
        event.preventDefault();
        let y = document.getElementById('err2');
        y.innerHTML = "<p>Minimum 8 letters</p>";
    }
    if (password!=confirm){
        event.preventDefault();
        let z = document.getElementById('err3');
        z.innerHTML = "<p>Incorrectly repeated password</p>";
    }
}



