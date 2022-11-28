
let blueRadio = document.querySelector('.blue-radio');
let pinkRadio = document.querySelector('.pink-radio');
let searchButton = document.querySelector('.search');
let wishlistButton = document.querySelector('.btn-yellow');

if (document.querySelector('.themes')){
    document.querySelector('.themes').addEventListener('change',
        (event) => {
            if (event.target.nodeName === 'INPUT') {
                document.body.classList.remove('blue-theme', 'pink-theme');
                document.body.classList.add(event.target.value);
                let themeValue = event.target.value;
                localStorage.removeItem('theme');
                localStorage.setItem('theme', themeValue);
            }
        });
}

if (localStorage.getItem('theme') === 'blue-theme'){
    document.body.classList.remove('blue-theme', 'pink-theme');
    document.body.classList.add('blue-theme');
    if(blueRadio){
        blueRadio.checked = true;
        pinkRadio.checked = false;
    }
} else {
    document.body.classList.remove('blue-theme', 'pink-theme');
    document.body.classList.add('pink-theme');
    if(blueRadio){
        blueRadio.checked = false;
        pinkRadio.checked = true;
    }
}

if (searchButton){
    searchButton.addEventListener('click', (event) => {
        document.location.href = 'searchlist.html';
    });
}

if (wishlistButton){
    wishlistButton.addEventListener('click', (event) => {
        document.location.href = 'mywishlist.html';
    });
}