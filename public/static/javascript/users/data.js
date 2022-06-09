// User data variables
let controlIconCollapse = document.querySelectorAll('.control__icon--collapse'),
    deleteCardButtons = document.querySelectorAll('.pay__icon--delete'),
    deleteBillingButtons = document.querySelectorAll('.billing__icon--delete'),
    container = document.querySelector('.control__container--billing'),
    closeForm = document.querySelectorAll('.card__icon--closeForm'),
    addCardButton = document.querySelector('.control__add--card'),
    formCard = document.querySelector('.control__form--card'),
    addBillingButton = document.querySelector('.control__add--billing'),
    formBilling = document.querySelector('.control__form--billing');

// Orders variables
let button = document.querySelectorAll('.order__icon'),
    ordersContainer = document.querySelector('.control__order'),
    orderXhr = "";

// Wishlist variables
let deleteButton = document.querySelectorAll('.wish__icon--x'),
    deleteButtonMin = document.querySelectorAll('.wish__icon--delete'),
    addCartButton = document.querySelectorAll('.wish__icon--cart'),
    wishControlContainer = document.querySelector('.control__content--wishlist'),
    wishContainer = document.querySelector('.control__wish'),
    wishXhr = "",
    cartNum = document.querySelector('.header__cartCant');

// Paginator variables
let lastPage = document.querySelector('.paginator__last'),
    actual = document.querySelector('.paginator__actual'),
    pageBtnWish = document.querySelectorAll('[class*="paginator__button"]'),
    pageBtnOrders = document.querySelectorAll('[class*="paginator__button"]')
    page = 1;

/**
 * First listers load
 */
try {
    dataListeners();
} catch (error) {}

try {
    orderListeners();
} catch (error) {}

try {
    wishlistListeners();
} catch (error) {}


function deleteUserInfo(card, type)
{
    let id = card.getAttribute('identifier');
    let cardsContainer = card.parentNode;

    let xhr = new XMLHttpRequest();

    if(type == 'card'){
        xhr.open('PUT', '/ajax/deleteCard?id='+id, true);
    }else{
        xhr.open('PUT', '/ajax/deleteBilling?id='+id, true);
    }
    
    xhr.send();

    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200) cardsContainer.removeChild(card);
    }
}


function changePage(direction)
{
    direction == 'left'  ?     page -= 1 :     page += 1;
    
    orderXhr != "" ? orderXhr.abort() : orderXhr = new XMLHttpRequest();

    orderXhr.open('GET', '/ajax/get_orders?page='+page, true);
    orderXhr.send();

    actual.innerHTML = page;
    changeButtons(page, pageBtnOrders[0], pageBtnOrders[1], lastPage.textContent);
    setLoading(ordersContainer);

    orderXhr.onreadystatechange = ()=>{
        if(orderXhr.readyState == 4 && orderXhr.status == 200){
            ordersContainer.innerHTML = orderXhr.responseText;
            reloadOrders();
        }
    }
}

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
             reloadWishlist();
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
 
     wishXhr != "" ? wishXhr.abort() : wishXhr = new XMLHttpRequest();
     
     wishXhr.open('GET', '/ajax/wishlist_games?page='+page, true);
     wishXhr.send();
 
     setLoading(wishContainer);
     changeButtons(page, pageBtnWish[0], pageBtnWish[1], lastPage.textContent);
     actual.innerHTML = page;
 
     wishXhr.onreadystatechange = ()=>{
         if(wishXhr.readyState == 4 && wishXhr.status == 200){
             wishControlContainer.innerHTML = wishXhr.responseText;
             reloadWishlist();
             changeButtons(page, pageBtnWish[0], pageBtnWish[1], lastPage.textContent);
         }
    }
}


/**
 * Reload listeners functions
*/

function dataListeners()
{
    controlIconCollapse.forEach(collapseIcon => {
        collapseIcon.addEventListener('click', ()=>{
            let container = collapseIcon.parentNode.parentNode;
            let target = container.querySelector('.control__container--collapse');
            collapse('collapsed--unset', target, collapseIcon);
        })
    });
    
    deleteCardButtons.forEach(deleteButton => {
        deleteButton.addEventListener('click', ()=>{
            deleteUserInfo(deleteButton.parentNode, 'card');
        });
    });
    
    deleteBillingButtons.forEach(deleteButton => {
        deleteButton.addEventListener('click', ()=>{
            deleteUserInfo(deleteButton.parentNode, 'billing');
        });
    })
    
    addCardButton.addEventListener('click', ()=>{
        let container = formCard.parentNode;
        container.classList.toggle('control__container--none');
    });
    
    addBillingButton.addEventListener('click', ()=>{
        let container = formBilling.parentNode;
        container.classList.toggle('control__container--none');
    });
    
    closeForm.forEach(button => {
        button.addEventListener('click', ()=>{
            let container = button.parentNode.parentNode;
            container.classList.toggle('control__container--none');
        });
    });
}

function orderListeners()
{
    button.forEach(arrow => {
        arrow.addEventListener('click', ()=>{
            let container = arrow.parentNode.parentNode;
            let bottom = container.querySelector('.order__bottom');
            collapse('collapsed', bottom, arrow);    
        });
    });

    pageBtnOrders.forEach(button => {
        button.addEventListener('click', ()=>{
            let direction = button.getAttribute('direction');
            if (!button.classList.contains('paginator__button--disabled')) changePage(direction);
        });
    });
}

function wishlistListeners()
{
    deleteButton.forEach(button => {
        button.addEventListener('click', ()=>{
            deleteWishGame(button.parentNode); 
        }); 
    });
        
    deleteButtonMin.forEach(button => {
        button.addEventListener('click', ()=>{
            deleteWishGame(button.parentNode.parentNode); 
        }); 
    });
        
    addCartButton.forEach(button =>{
        button.addEventListener('click', ()=>{
            addWishGame(button.parentNode.parentNode);
        }); 
    });

    if(pageBtnWish != 'undefined' || pageBtnWish != null)
    {
        pageBtnWish.forEach(btn => {
            btn.addEventListener('click', ()=>{
                let direction = btn.getAttribute('direction');
                if (!btn.classList.contains('paginator__button--disabled')) getGames(direction);
            });
        });
    }
}


/**
 * Reload variables and listeners functions
*/

function reloadOrders()
{
    button = document.querySelectorAll('.order__icon');
    orderListeners()
}

function reloadWishlist()
{
    deleteButton = document.querySelectorAll('.wish__icon--x');
    deleteButtonMin = document.querySelectorAll('.wish__icon--delete');
    addCartButton = document.querySelectorAll('.wish__icon--cart');
    wishContainer = document.querySelector('.control__wish');

    try {
        pageBtnWish = document.querySelectorAll('[class*="paginator__button"]');
        wishContainer = document.querySelector('.control__wish');
        lastPage = document.querySelector('.paginator__last');
        actual = document.querySelector('.paginator__actual'); 
    } catch (error) {}
    
    wishlistListeners();
}