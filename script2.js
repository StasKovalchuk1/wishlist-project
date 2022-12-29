
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
