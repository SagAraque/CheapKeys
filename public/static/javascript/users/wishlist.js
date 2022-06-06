let deleteButton = document.querySelectorAll('.wish__icon--delete'),
    addCartButton = document.querySelectorAll('.wish__icon--cart'),
    cartNum = document.querySelector('.header__cartCant');

deleteButton.forEach(button => {
    button.addEventListener('click', ()=>{
       let card = button.parentNode;
        deleteWishGame(card); 
    }) 
});

addCartButton.forEach(button =>{
    button.addEventListener('click', ()=>{
        let card = button.parentNode.parentNode;
        addWishGame(card);
     }) 
});


/**
 * Delete a game from the wishlist
 * @param {*} card Game card
 */
function deleteWishGame(card)
{
    let container = card.parentNode;
    console.log(container);
    let xhr = new XMLHttpRequest();

    let data = new FormData();
    data.append('game', card.getAttribute('game'));
    data.append('platform', card.getAttribute('platform'));

    xhr.open('POST', `/ajax/wishlist`, true);
    xhr.send(data);
    
    container.removeChild(card);

    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 302){
            window.location.href = '/users/login'; 
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