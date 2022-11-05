document.querySelector('.themes').addEventListener('change',
    (event) => {
        if (event.target.nodeName === 'INPUT') {
            document.documentElement.classList.remove('blue-theme', 'pink-theme');
            document.documentElement.classList.add(event.target.value);

        }
    });

function init(){
    const formElement = document.querySelector("#form");
    formElement.addEventListener("submit", validate);
}

function validate(event){
    var name = document.querySelector(".login").value;
    var password = document.querySelector(".password").value;
    var confirm = document.querySelector(".confirm").value;
    if (name.length < 5) {
        event.preventDefault();
        alert("Name min. 5 znaku");
    }
    else if (password.length < 8 || password!=confirm){
        event.preventDefault();
        alert("Wrong password");
    }
}

function setCookie(){
    document.cookie = document.getElementsByClassName()
}

