let deleteButton = document.querySelectorAll('.wish__icon--x'),
    deleteButtonMin = document.querySelectorAll('.wish__icon--delete'),
    addCartButton = document.querySelectorAll('.wish__icon--cart'),
    cartNum = document.querySelector('.header__cartCant');

    // Paginator code
try {

    var pageBtn = document.querySelectorAll('[class*="paginator__button"]'),
        wishControlContainer = document.querySelector('.control__content--wishlist'),
        wishContainer = document.querySelector('.control__wish'),
        lastPage = document.querySelector('.paginator__last').textContent,
        actual = document.querySelector('.paginator__actual'),
        wishXhr = "",
        page = 1;
    
} catch (error) {}  


reloadWishListeners();

/**
 * Delete a game from the wishlist
 * @param {*} card Game card
 */
function deleteWishGame(card)
{
    let xhr = new XMLHttpRequest();

    let data = new FormData();
    data.append('game', card.getAttribute('game'));
    data.append('platform', card.getAttribute('platform'));
    data.append('page', page);

    xhr.open('POST', `/ajax/delete_wishlist`, true);
    xhr.send(data);
    

    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 302){
            window.location.href = '/users/login'; 
        }else if(xhr.readyState == 4 && xhr.status == 200){
            wishControlContainer.innerHTML = xhr.responseText;
            reloadWishListeners();
        }
    }
}

/**
 * Add a game from the wishlist to the cart.
 * @param {*} card Game card
 */
function addWishGame(card)
{
    let xhr = new XMLHttpRequest();

    let data = new FormData();
    data.append('game', card.getAttribute('game'));
    data.append('platform', card.getAttribute('platform'));

    try {
        data.append('cartCount', cartNum.textContent);
    } catch (error) {
        data.append('cartCount', 0);
    }
   

    xhr.open('POST', '/ajax/addProductCart', true);
    xhr.send(data);

    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 302){
            window.location.href = '/users/login'; 
        }else if(xhr.readyState == 4 && xhr.status == 200){
            cartNum.textContent = xhr.responseText;
        }
    }
}

function getGames(direction)
{
    direction == 'left'  ?     page -= 1 :     page += 1;

    if(wishXhr != "") wishXhr.abort();
    wishXhr = new XMLHttpRequest();
    wishXhr.open('GET', '/ajax/wishlist_games?page='+page, true);
    wishXhr.send();

    setLoading(wishContainer);
    changeButtons(page, pageBtn[0], pageBtn[1], lastPage);
    actual.innerHTML = page;

    wishXhr.onreadystatechange = ()=>{
        if(wishXhr.readyState == 4 && wishXhr.status == 200){
            wishControlContainer.innerHTML = wishXhr.responseText;
            reloadWishListeners();
            changeButtons(page, pageBtn[0], pageBtn[1], lastPage);
        }
    }
}

function reloadWishListeners()
{
    deleteButton = document.querySelectorAll('.wish__icon--x');
    deleteButtonMin = document.querySelectorAll('.wish__icon--delete');
    addCartButton = document.querySelectorAll('.wish__icon--cart');

    // Paginator code
    try {
        pageBtn = document.querySelectorAll('[class*="paginator__button"]');
        wishContainer = document.querySelector('.control__wish');
        lastPage = document.querySelector('.paginator__last').textContent;
        actual = document.querySelector('.paginator__actual');
    } catch (error) {
        
    }

    deleteButton.forEach(button => {
        button.addEventListener('click', ()=>{
            let card = button.parentNode;
            deleteWishGame(card); 
        }) 
    });
        
    deleteButtonMin.forEach(button => {
        button.addEventListener('click', ()=>{
            let card = button.parentNode.parentNode;
            deleteWishGame(card); 
        }) 
    });
        
    addCartButton.forEach(button =>{
        button.addEventListener('click', ()=>{
            let card = button.parentNode.parentNode;
            addWishGame(card);
            }) 
    });
        
    pageBtn.forEach(btn => {
        btn.addEventListener('click', ()=>{
            let direction = btn.getAttribute('direction');
            if (!btn.classList.contains('paginator__button--disabled')) getGames(direction);
        });
    });
}