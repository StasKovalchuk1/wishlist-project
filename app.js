
function init(){
    const formElement = document.querySelector("#form");
    if(formElement){
        formElement.addEventListener("submit", validateRegistration);
    }
    const formElement2 = document.querySelector("#form2");
    if(formElement2){
        formElement2.addEventListener("submit", validateAuthorization);
    }
    const formElement3 = document.querySelector("#form3");
    if(formElement3){
        formElement3.addEventListener("submit", validateWish);
    }
    const formElement4 = document.querySelector("#form4");
    if(formElement4){
        formElement4.addEventListener("submit", validateSearch);
    }
}

function validateRegistration(event){
    var name = document.querySelector(".login").value;
    var password = document.querySelector(".password").value;
    var confirm = document.querySelector(".confirm").value;
    if (name.length < 5 || name.length > 20) {
        event.preventDefault();
        let x = document.getElementById('err1');
        x.innerHTML = "<p>Length is from 5 to 20 characters</p>";
    }
    if (password.length < 8 || password.length > 20){
        event.preventDefault();
        let y = document.getElementById('err2');
        y.innerHTML = "<p>Length is from 8 to 20 characters</p>";
    }
    if (password!=confirm){
        event.preventDefault();
        let z = document.getElementById('err3');
        z.innerHTML = "<p>Incorrectly repeated password</p>";
    }
}


function validateAuthorization(event){
    var name = document.querySelector(".login").value;
    var password = document.querySelector(".password").value;
    if (name.length < 5 || name.length > 20) {
        event.preventDefault();
        let x = document.getElementById('err1');
        x.innerHTML = "<p>Length is from 5 to 20 characters</p>";
    }
    if (password.length < 8 || password.length > 20){
        event.preventDefault();
        let y = document.getElementById('err2');
        y.innerHTML = "<p>Length is from 8 to 20 characters</p>";
    }
}


function validateWish(event){
    var wish = document.querySelector(".wish").value;
    var count = document.querySelector(".count").value;
    var date = document.querySelector(".date").value;
    if (wish.length > 100) {
        event.preventDefault();
        let x = document.getElementById('err1');
        x.innerHTML = "<p>Your wish is too long</p>";
    }
    if (count < 1){
        event.preventDefault();
        let y = document.getElementById('err2');
        y.innerHTML = "<p>Minimum count 1</p>";
    }
    if (count.length > 9){
        event.preventDefault();
        let y = document.getElementById('err2');
        y.innerHTML = "<p>Try a smaller value</p>";
    }
    if (!(date.match(/^(\d{4})-(\d{1,2})-(\d{1,2})/))) {
        event.preventDefault();
        let z = document.getElementById('err3');
        z.innerHTML = "<p>Enter correct date (yyyy-mm-dd)</p>";
    }
}


function validateSearch(event){
    var searchName = document.querySelector("#search-login").value;
    if (searchName.length < 1) {
        event.preventDefault();
        let x = document.getElementById('err1');
        x.innerHTML = "<p>Enter a username</p>";
    }
}