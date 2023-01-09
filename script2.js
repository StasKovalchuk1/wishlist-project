
let searchButton = document.querySelector('.search');
let wishlistButton = document.querySelector('.btn-yellow');


if (searchButton){
    searchButton.addEventListener('click', (event) => {
        document.location.href = 'searchlist.php';
    });
}

if (wishlistButton){
    wishlistButton.addEventListener('click', (event) => {
        document.location.href = 'main/request.php';
    });
}

//kontrola formuláře pomocí JavaScriptu na (všech!) elementech ve formuláři, při zadávání dat
var inputLogin = document.querySelector("#login");
if (inputLogin){
    inputLogin.addEventListener("input", function (e) {
        if ((inputLogin.value.length < 5 || inputLogin.value.length > 20) && inputLogin.value.length != 0) {
            let errLog = document.getElementById('err1');
            errLog.innerHTML = "<p id='validateLogin'>Length is from 5 to 20 characters</p>";
        } else {
            var elem = document.getElementById("validateLogin");
            if (elem){
                elem.parentNode.removeChild(elem);
            }
        }
    }, false);
}

var inputPassword = document.querySelector("#password");
if (inputPassword){
    inputPassword.addEventListener("input", function (e) {
        if ((inputPassword.value.length < 8 || inputPassword.value.length > 20) && inputPassword.value.length != 0) {
            let errPass = document.querySelector('#err2');
            errPass.innerHTML = "<p id='validatePassword'>Length is from 8 to 20 characters</p>";
        } else {
            var elem = document.getElementById("validatePassword");
            if (elem){
                elem.parentNode.removeChild(elem);
            }
        }
    }, false);
}

var inputConfirm = document.querySelector("#confirm-password");
if (inputConfirm){
    inputConfirm.addEventListener("input", function (e) {
        if ((inputConfirm.value.length < 8 || inputConfirm.value.length > 20) && inputConfirm.value.length != 0) {
            let errConfirm = document.querySelector('#err3');
            errConfirm.innerHTML = "<p id='validateConfirm'>Length is from 8 to 20 characters</p>";
        } else {
            var elem = document.getElementById("validateConfirm");
            if (elem){
                elem.parentNode.removeChild(elem);
            }
        }
    }, false);
}

var inputWish = document.querySelector("#item");
if (inputWish){
    inputWish.addEventListener("input", function (e) {
        if (inputWish.value.length > 100) {
            let errWish = document.querySelector('#err1');
            errWish.innerHTML = "<p id='validateWish'>Your wish is too long</p>";
        } else {
            var elem = document.getElementById("validateWish");
            if (elem){
                elem.parentNode.removeChild(elem);
            }
        }
    }, false);
}

var inputCount = document.querySelector("#count");
if (inputCount) {
    inputCount.addEventListener("input", function (e) {
        if ((inputCount.value.length > 9 || inputCount.value < 1) && inputCount.value.length != 0) {
            let errCount = document.querySelector('#err2');
            errCount.innerHTML = "<p id='validateCount'>The allowed number is from 1 to 999999999</p>";
        } else {
            var elem = document.getElementById("validateCount");
            if (elem) {
                elem.parentNode.removeChild(elem);
            }
        }
    }, false);
}

var inputDate = document.querySelector("#date");
if (inputDate) {
    inputDate.addEventListener("input", function (e) {
        if (!(inputDate.value.match(/^(\d{4})-(\d{1,2})-(\d{1,2})/)) && inputDate.value != 0) {
            let errDate = document.querySelector('#err3');
            errDate.innerHTML = "<p id='validateDate'>Enter correct date (yyyy-mm-dd)</p>";
        } else {
            var elem = document.getElementById("validateDate");
            if (elem) {
                elem.parentNode.removeChild(elem);
            }
        }
    }, false);
}