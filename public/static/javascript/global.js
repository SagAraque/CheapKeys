let movileIcon = document.querySelector('.header__icon--menu')
    headerContainer = document.querySelector('.header__container')
    headerContainerMovile = document.querySelector('.header__container--movile'),
    movileMenu = document.querySelector('.header__nav'),
    searchForm = document.querySelector('.header__form'),
    searchInput = document.querySelector('.header__input'),
    searchContainer = document.querySelector('.header__container--search'),
    menuMobileIcon = document.querySelector('.control__icon--menu'),
    menuList = document.querySelector('.control__list'),
    searchXhr = "";

// Index variables
let indexCardButton = document.querySelectorAll('.card__button--index'),
    indexGallery = document.querySelector('.index__gallery'),
    indexWrapper = document.querySelector('.gallery__wrapper'),
    indexGalleryImg = document.querySelectorAll('.gallery__asset--index'),
    wrapperPos = 0,
    indexGalleryArrows = document.querySelectorAll('.index__arrow'),
    indexPaginatorGallery = document.querySelectorAll('[class*="gallery__ball"]');

// Contact variables
let faqHeader = document.querySelectorAll('.faq__header');

// Product variables
let min = document.querySelectorAll('[class*="gallery__min"]'),
    gallery = document.querySelector('.gallery__asset'),
    arrows = document.querySelectorAll('.gallery__arrow'),
    objectIndex = 0,
    productWishlist = document.querySelector('.info__button--wish'),
    productWishlistIcon = document.querySelector('.info_icon--wish'),
    productCartButton = document.querySelector('.info__button--buy'),
    reviewsButton = document.querySelector('.reviews__button'),
    reviewsForm = document.querySelector('.reviews__form--container'),
    cartNum = document.querySelector('.header__cartCant');

// Mobile product gallery variables
let slider = document.querySelector('.slider'),
    wrapper = document.querySelector('.gallery__wrapper'),
    wrapperImg = document.querySelectorAll('.gallery__asset--mobile'),
    sliderPaginator = document.querySelectorAll('[class*="gallery__ball"]');

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
    wishXhr = "";

// Paginator variables
let lastPage = document.querySelector('.paginator__last'),
    actual = document.querySelector('.paginator__actual'),
    pageBtnWish = document.querySelectorAll('.paginator__button--wish'),
    pageBtnOrders = document.querySelectorAll('.paginator__button--orders'),
    pageBtnReviews = document.querySelectorAll('.paginator__button--reviews'),
    pageBtnReviewsUser = document.querySelectorAll('.paginator__button--reviewsUser'),
    page = 1;

//Cart variables
let cartDeleteButton = document.querySelectorAll('.card__icon--delete'),
    cartPrice = document.querySelector('.cart__text--total'),
    cartTotal = document.querySelector('.cart__text'),
    cartTotalHeader = document.querySelector('.header__cartCant'),
    dashButton = document.querySelectorAll('.bi-dash-square'),
    addButton = document.querySelectorAll('.bi-plus-square'),
    cardsContainer = document.querySelector('.cart__products');

//Reviews variables
let reviewsSection = document.querySelector('.reviews'),
    reviewsContainer = document.querySelector('.reviews__container');

// Keys vasriables
let keysButton = document.querySelectorAll('button[class="keys__button"]');

//User reviews variables
let reviewsUserContainer = document.querySelector('.control__reviews');

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


// -------- Reviews listeners start -------//

if(reviewsButton != 'undefined' && reviewsButton != null){
    reviewsButton.addEventListener('click', ()=>{
        reviewsForm.classList.toggle('displayNone');
        reviewsContainer.hasAttribute('style') ? reviewsContainer.removeAttribute('style') : reviewsContainer.style.minHeight = '550px';
    })
}

if(pageBtnReviews != 'undefined' && pageBtnReviews != null){
    pageBtnReviews.forEach(btn => {
        btn.addEventListener('click', ()=>{
            let game = reviewsSection.getAttribute('game');
            let platform = reviewsSection.getAttribute('platform');
            let direction = btn.getAttribute('direction');
    
            if (!btn.classList.contains('paginator__button--disabled')) getReviews(direction, reviewsContainer, pageBtnReviews, game, platform);
    
        });
    });
}

if(pageBtnReviewsUser != 'undefined' && pageBtnReviewsUser != null){
    pageBtnReviewsUser.forEach(btn => {
        btn.addEventListener('click', ()=>{
            let direction = btn.getAttribute('direction');
            if (!btn.classList.contains('paginator__button--disabled')) getReviews(direction, reviewsUserContainer, pageBtnReviewsUser); 
        });
    });
}

// -------- Reviews listeners end -------//

// -------- Index listeners start -------//


 if(indexWrapper != 'undefined' && indexWrapper != null){
    indexWrapper.addEventListener('touchstart',  (e)=> {
        wrapGallery(indexGalleryImg, indexWrapper, e.touches[0].pageX, indexPaginatorGallery);
    });

    indexWrapper.addEventListener('dragstart',  (e)=> {
        wrapGallery(indexGalleryImg, indexWrapper, e.pageX, indexPaginatorGallery);
    });
} 

indexGalleryArrows.forEach(arrow =>{
    arrow.addEventListener('click', ()=>{
        let direction = arrow.getAttribute('direction') == 'left' ? -1 : 1;
        moveGalleryWrapper( indexWrapper, indexGalleryImg, direction, indexPaginatorGallery);
    });
});

indexCardButton.forEach(button => {
    button.addEventListener('click', ()=>{
        let id = button.getAttribute('game');
        let platform = button.getAttribute('platform');
        setGameCart([id, platform]);
    });
    
});

// -------- Index listeners end -------//

// -------- Product listeners start -------//

// Product gallery buttons
min.forEach(element => {
    element.addEventListener('click', ()=>{
        if(!element.classList.contains('gallery__min--selected')){
            changeGalleryImg(element);
            let img = element.querySelector('.gallery__asset').getAttribute('src');
            img = img.replace('/static/img/games/', '');
            img = img.replace('-min.webp', '');
            objectIndex = Array.prototype.indexOf.call(images, img);
        } 
    });
});

/**
 * Product gallery arrows
 */
arrows.forEach(arrow =>{
    arrow.addEventListener('click', ()=>{
        slide(arrow.getAttribute('slide'));
    });
});

/**
 * Product cart button
 */
if(productCartButton != 'undefined' && productCartButton != null){
    productCartButton.addEventListener('click', ()=>{
        setGameCart(product);
    });
}

/**
 * Mobile product gallery wrapper
 */
if(wrapper != 'undefined' && wrapper != null){
    wrapper.addEventListener('touchstart',  (e)=> {
        wrapGallery(wrapperImg, wrapper, e.touches[0].pageX, sliderPaginator);
    });

    wrapper.addEventListener('dragstart',  (e)=> {
        wrapGallery(wrapperImg, wrapper, e.pageX, sliderPaginator);
    });
}

// Product wishlist button
if(productWishlist != 'undefined' && productWishlist != null){
    productWishlist.addEventListener('click', ()=>{
        setWishlist(product);
    });
}

// -------- Product listeners end -------//

// -------- Cart listeners start -------//

if(cartDeleteButton != 'undefined' && cartDeleteButton != null){
    cartDeleteButton.forEach(button => {
        button.addEventListener('click', () =>{
            console.log(button);
            let container = button.parentNode;
            let card = container.parentNode;
            removeGameCart(card);
        })
    });
    
}

if(dashButton != 'undefined' && dashButton != null){
    dashButton.forEach(button =>{
        button.addEventListener('click', () =>{
            let container = button.parentNode.parentNode;
            let card = container.parentNode;
            changeCantCart(-1, card)
        });
    });
}


if(addButton != 'undefined' && addButton != null){
    addButton.forEach(button =>{
        button.addEventListener('click', () =>{
            let container = button.parentNode.parentNode;
            let card = container.parentNode;
            changeCantCart(1, card)
        });
    });
}

// -------- Cart listeners end -------//

// -------- FAQ listeners start -------//

if(faqHeader != 'undefined' && faqHeader != null){
    faqHeader.forEach(header => {
        header.addEventListener('click', ()=>{
            let parent = header.parentNode;
            let text = parent.querySelector('.faq__answer');
            let icon = parent.querySelector('.faq__icon');
            collapse('collapsed', text, icon);
        });
    });
}

// -------- FAQ listeners end -------//

// -------- Search listeners start -------//

searchInput.addEventListener('input', ()=>{
    if(searchXhr != "") searchXhr.abort();
    searchXhr = new XMLHttpRequest();
    let input = searchInput.value;

    searchXhr.open('GET', `/ajax/searchBarResult?string=${input}`);
    searchXhr.send();
    
    let searchLoading = setTimeout(()=>{
        setLoading(searchContainer);
    },200);

    searchXhr.onreadystatechange = ()=>{
        if(searchXhr.readyState == 4 && searchXhr.status == 200){
            searchContainer.innerHTML = searchXhr.responseText;
            clearTimeout(searchLoading);
            searchXhr = "";
        }else if(searchXhr.readyState == 4 && searchXhr.status == 404){
            searchContainer.innerHTML = "";
            clearTimeout(searchLoading);
        }
    }
});

document.addEventListener('click', (e)=>{
    if(e.target != searchInput || e.target != searchContainer){
        searchContainer.innerHTML = "";
        if(typeof variable != 'undefined' && variable != null) clearTimeout(searchLoading);
        if(searchXhr != "") searchXhr.abort();
    }
});

// -------- Search listeners end -------//

// -------- Menu mobile icon listeners start -------//

movileIcon.addEventListener('click', ()=>{
    movileMenu.classList.toggle('header__nav--visible');
    setTimeout(()=>{
        movileMenu.classList.toggle('header__nav--hidde');
    }, 300);
});

if(menuMobileIcon != 'undefined' && menuMobileIcon != null){
    menuMobileIcon.addEventListener('click', ()=>{
        collapse('collapsed--unset', menuList, menuMobileIcon);
    });
}

// -------- Menu mobile icon listeners end -------//


/**
 * Prints a loading symbol on the indicated container
 * @param {*} div  Parent container
 * @param {*} elementClass  Loading symbol class
 */
function setLoading(div, elementClass = 'reviews__loading')
{
    let loading = document.createElement('div');
    loading.classList.add(elementClass);
    div.innerHTML = "";
    div.appendChild(loading);
}

/**
 *  Modify the maximum height so that the delivered element is collapsible.
 * @param {*} collapseClass  Collapsible class
 * @param {*} element  Collapsible element
 * @param {*} icon  Icon which triggers the action
 */
function collapse(collapseClass, element, icon)
{
    if(element.classList.contains(collapseClass)){
        element.style.maxHeight = element.scrollHeight + 'px';

        setTimeout(()=>{
            element.classList.toggle(collapseClass);
            element.removeAttribute('style')
        }, 400);
    }else{
        element.style.maxHeight = element.clientHeight + 'px';

        setTimeout(()=>{
            element.classList.toggle(collapseClass);
            element.removeAttribute('style');
        }, 10);
    }

    icon.classList.toggle('control__icon--rotate');
}

/**
 *  Changes the buttons of the pager depending on the current page
 * @param {*} page Current page of the paginator
 * @param {*} btnLeft  Left button of the paginator
 * @param {*} btnRight Left button of the paginator
 * @param {*} lastPage  Last page of the paginator
 */
function changeButtons(page, btnLeft, btnRight, lastPage)
{
    if(page == 1){
        btnLeft.classList.replace('paginator__button', 'paginator__button--disabled');
    }else{
        btnLeft.classList.replace('paginator__button--disabled', 'paginator__button');
    }

    if(page == lastPage){
        btnRight.classList.replace('paginator__button', 'paginator__button--disabled');
    }else{
        btnRight.classList.replace('paginator__button--disabled', 'paginator__button');
    }
}

/**
 * Set a game to the user
 * 
 * @param {*} gameData Game if and platform id
 */
 function setGameCart(gameData)
 {
     let xhr = new XMLHttpRequest();
 
     let data = new FormData();
     data.append('game', gameData[0]);
     data.append('platform', gameData[1]);
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


 /**
 * Do mobile gallery wrap function when mouse is moving to detect th direction
 * of the movement and change the image and paginator
 * 
 * @param {*} imgs Images used to extract the correct width
 * @param {*} wrapper Wraper container with all images
 * @param {*} initialPos Mouse initial position
 * @param {*} paginator Gallery paginator
 */
function wrapGallery(imgs, wrapper, initialPos, paginator = null)
{
    wrapper.addEventListener('touchmove', (e)=>{
        e.touches[0].pageX > initialPos ? direction = -1 : direction = 1;
        moveGalleryWrapper(wrapper, imgs, direction, paginator);

    }, {once : true});

    wrapper.addEventListener('mousemove', (e)=>{
        e.pageX > initialPos ? direction = -1 : direction = 1;
        moveGalleryWrapper(wrapper, imgs, direction, paginator);

    }, {once : true});
}

/**
 * Move wrap gallery images
 * @param {*} wrapper  Wrapper container
 * @param {*} imgs  Gallery images
 * @param {*} direction Wrap direction
 * @param {*} paginator  Images paginator
 */
function moveGalleryWrapper(wrapper, imgs, direction, paginator = null)
{
    let imgWidth = imgs[0].offsetWidth,
        max = imgWidth * imgs.length;

    wrapperPos -= imgWidth * direction;

    if(Math.abs(wrapperPos) >= max) wrapperPos = 0;
    if(wrapperPos > 0) wrapperPos = -max + imgWidth;

    wrapper.style.transform = `translateX(${wrapperPos}px)`;

    // Change paginator classes
    let index = Math.abs(wrapperPos / imgWidth);
    
    if(paginator != null)
    {
        paginator.forEach(ball => {
            ball.classList.replace('gallery__ball--selected', 'gallery__ball');
        });
        paginator[index].classList.replace('gallery__ball', 'gallery__ball--selected');
    }
}

/**
 * Change the gallery image using the src atributte from a miniature
 * @param {*} min Image miniature
 */
 function changeGalleryImg(min)
 {
     let minSelected = document.querySelector('.gallery__min--selected');
     let src = min.querySelector('.gallery__asset').getAttribute('src');
     src = src.replace('-min', '');
 
     minSelected.classList.replace('gallery__min--selected', 'gallery__min');
     min.classList.replace('gallery__min', 'gallery__min--selected');
 
     gallery.setAttribute('src', src);
 }

 /**
 * Set the parameters to change gallery image and miniature images
 * @param {*} direction Direction of the slide 
 */
function slide(direction)
{
    let minSelected = document.querySelector('.gallery__min--selected');
    let index = Array.prototype.indexOf.call(min, minSelected);
    let max = images.length >= 4 ? 4 : images.lenght;

    if(direction == 'right'){
        index += 1;
        objectIndex +=1;

        if(index > 3 && objectIndex < images.length){
            changeMinImg(index - 3, images.length);
            index = 3;
        }else if(objectIndex >= images.length){
            objectIndex = 0;
            index = 0;
            changeMinImg(0, max);   
        }
    }else{
        index -= 1;
        objectIndex -=1;

        if(index < 0){ 
            if(objectIndex < 0){
                if(images.lenght > 4) changeMinImg(images.length - 4, max);
                index = 3;
                objectIndex = images.length - 1;
            }else{
                changeMinImg(0, max);
                index = 0;
                objectIndex = 0;
            }
        }
    }

    changeGalleryImg(min[index]);
}

/**
 * Chnage the gallery miniatures
 * @param {*} init 
 * @param {*} max 
 */
 function changeMinImg(init, max)
 {   
    console.log(init);
     let minindex = 0;
     for (let i = init; i < max; i++) {
         img = min[minindex].querySelector('.gallery__asset');
         img.setAttribute('src', `/static/img/games/${images[i]}-min.webp`);
         minindex +=1;
     }
 }
 
 /**
  * Add the game to the user wishlist
  * @param {*} gameData Array with game id and platform id
  */
 function setWishlist(gameData)
 {
     let xhr = new XMLHttpRequest();
 
     let data = new FormData();
     data.append('game', gameData[0]);
     data.append('platform', gameData[1]);
 
     xhr.open('POST', `/ajax/wishlist`, true);
     xhr.send(data);
 
     if(productWishlistIcon.classList.contains('bi-heart-fill')){
        productWishlistIcon.classList.replace('bi-heart-fill', 'bi-heart');
     }else{
        productWishlistIcon.classList.replace('bi-heart', 'bi-heart-fill');
     }
 
     xhr.onreadystatechange = ()=>{
         if(xhr.readyState == 4 && xhr.status == 302){
             window.location.href = '/users/login'; 
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
   * Change paginator page from orders view
   * @param {*} direction Paginator action direction
   */
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
 * Delete user pay method or billing direction
 * @param {*} card Card that we want to remove
 * @param {*} type card or  billing
 */
function deleteUserInfo(card, type)
{
    let id = card.getAttribute('identifier');
    let cardsContainer = card.parentNode;
    let xhr = new XMLHttpRequest();

    type == 'card' ?  xhr.open('PUT', '/ajax/deleteCard?id='+id, true) : xhr.open('PUT', '/ajax/deleteBilling?id='+id, true);
    xhr.send();

    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200) cardsContainer.removeChild(card);
    }
}

/**
 *  Get games from user wishlist using a paginator
 * @param {*} direction  Paginator action direction
 */
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
 * Remove a game cart from cart view
 * @param {*} card The cart that we want to remove
 */
function removeGameCart(card)
{
    let xhr = new XMLHttpRequest();

    let data = new FormData();
    data.append('game', card.getAttribute('targetgame'));
    data.append('platform',  card.getAttribute('targetplatform'));

    xhr.open('POST', '/ajax/removeCartProduct', true);
    xhr.send(data);

    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 302){
            window.location.href = '/users/login'; 
        }else if(xhr.readyState == 4 && xhr.status == 200){
            let response = JSON.parse(xhr.responseText);

            cartPrice.textContent = parseFloat(response.totalPrice).toFixed(2) + ' €';
            cartTotalHeader.textContent = response.cartTotal;
            cartTotal.textContent = response.cartTotal;
            cardsContainer.removeChild(card);
        }
    }
}


/**
 * Change cart cant and price from cart view
 * @param {*} changeValue 
 * @param {*} card 
 */
function changeCantCart(changeValue, card)
{
    let xhr = new XMLHttpRequest();

    let data = new FormData();
    data.append('game', card.getAttribute('targetgame'));
    data.append('platform',  card.getAttribute('targetplatform'));
    data.append('changeValue', changeValue);

    xhr.open('POST', '/ajax/changeCartCant', true);
    xhr.send(data);

    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200){
            let response = JSON.parse(xhr.responseText);
            let cartCant = card.querySelector('.cart__cant');
            let newCant = parseInt(cartCant.textContent) + parseInt(changeValue);

            cartPrice.textContent = parseFloat(response.totalPrice).toFixed(2) + '€';
            cartTotalHeader.textContent = response.cartTotal;
            cartTotal.textContent = response.cartTotal;

            newCant <= 0 ?  cardsContainer.removeChild(card) : cartCant.textContent = newCant;
            
        }
    }

}


/**
 * Get reviews from data base using AJAX and print them into a container
 * @param {*} direction Set the direction of the paginator
 * @param {*} container  Reviews container
 * @param {*} buttons  Paginator buttons
 * @param {*} id  Game id. Can be null if you want to load all reviews by user
 */
function getReviews(direction, container, buttons, id = null, platform = null)
{
    direction == 'left' ? page -= 1 : page += 1;

    xhr = new XMLHttpRequest();
    xhr.open('GET', id ==  null ? '/ajax/reviews_user?page='+page : '/ajax/reviews?id='+id+'&platform='+platform+'&page='+page, true);
    xhr.send();

    setLoading(container);
    changeButtons(page, buttons[0], buttons[1], lastPage.textContent);
    actual.innerHTML = page;

    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200){
            container.innerHTML = xhr.responseText;
            actual.innerHTML = page;
            changeButtons(page, buttons[0], buttons[1], lastPage.textContent);
        }
    }

    container.scrollIntoView({ behavior:"smooth" });
}

/**
 * Reload data section listeners
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


/**
 * Reload orders listeners
 */
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

    keysButton.forEach(button =>{
        button.addEventListener('click', () =>{
            let container = button.parentNode;
            let key = container.querySelector('.keys__key').textContent;

            navigator.clipboard.writeText(key);
            button.textContent = 'Copiado';
            setTimeout(()=>{
                button.textContent = 'Copiar';
             }, 2000);
        });
    });
}

/**
 * Reload wisahlist listeners
 */
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
            let container = button.parentNode.parentNode;
            setGameCart([container.getAttribute('game'), container.getAttribute('platform')])
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
 * Reload variables and listeners functions and call orders listeners reload function
*/

function reloadOrders()
{
    button = document.querySelectorAll('.order__icon');
    orderListeners()
}

/**
 * Reload wishlist variables and call wishlist listeners reload function
 */
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

 
