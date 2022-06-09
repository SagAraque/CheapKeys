let checkbox = document.querySelectorAll('.store__checkBox'),
    container = document.querySelector('.store__container--products'),
    storeContainer = document.querySelector('.store__container--content'),
    select = document.querySelector('.store__select'),
    cardButtons = document.querySelectorAll('.card__button'),
    cartNum = document.querySelector('.header__cartCant'),
    developerData = [],
    platformData = [],
    pegiData = [],
    stockData = [];

// Menu variables
let filterButton = document.querySelector('.store__filter'),
    closeMenuButton = document.querySelector('.store__icon--close'),
    filtersMenu = document.querySelector('.store__container--menu'),
    filterMenuBackground = document.querySelector('[class*="main__background"]');

// Paginator variables
let page = 1,
    actualPage = document.querySelector('.paginator__actual'),
    lastPage = document.querySelector('.paginator__last'),
    pageBtnStore = document.querySelectorAll('[class*="paginator__button"]');


// Filters listeners
checkbox.forEach(input => {
    input.addEventListener('change', ()=>{
        let value = input.getAttribute('value');
        let list = input.parentNode.parentNode.parentNode;

        switch(list.getAttribute('data-type'))
        {
            case 'developer':
                input.checked ? developerData.push(value) : modifyArray(value, developerData);
                break;
            case 'platform':
                input.checked ? platformData.push(value) : modifyArray(value, platformData);
                break;
            case 'pegi':
                input.checked ? pegiData.push(value) : modifyArray(value, pegiData);
                break;
            case 'stock':
                input.checked ? stockData.push(value) : modifyArray(value, stockData);
                break;
        }
        page = 1;
        getData();
    })
});


select.addEventListener('change', ()=>{
    getData(page);
});

//Listeners
listeners();

/**
 * Delete a value from a filter array
 * 
 * @param {*} value Value to be removed
 * @param {*} arr Filter array
 */
function modifyArray(value, arr)
{
    let i = arr.indexOf(value);
    if(i !== -1) arr.splice(i, 1);
}

/**
 * Get games card from data base 
 * 
 * @param {*} pageValue Paginator page value
 */
function getData(pageValue = 1)
{
    let xhr = new XMLHttpRequest();
    let data = new FormData();
    
    data.append('dev', developerData);
    data.append('platform', platformData);
    data.append('pegi', pegiData);
    data.append('stock', stockData);
    data.append('page', actualPage == null ? 1: actualPage.textContent);
    data.append('platformLimit', platformLimit);
    data.append('order', select.value);
    data.append('offers', offersValue);
    data.append('page', pageValue);

    xhr.open('POST', '/ajax/changeStoreProducts', true);
    xhr.send(data);

    let loading = setTimeout(()=>{
        setLoading(container, 'store__loading');
    },200);

    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200){
            clearTimeout(loading);
            storeContainer.innerHTML = xhr.responseText;
            listeners();
            changeButtons(page, pageBtnStore[0], pageBtnStore[1], lastPage.textContent);
        }else if(xhr.readyState == 4 && xhr.status == 404){
            clearTimeout(loading);
            setError();
        }
    }
}

/**
 * Set an error message
 */
function setError()
{
    let div = document.createElement('div');
    let text = document.createElement('span');
    let icon = document.createElement('i');

    icon.classList.add('bi');
    icon.classList.add('store__error--icon');
    icon.classList.add('bi-exclamation-triangle');

    text.classList.add('store__error--text');
    text.textContent = "Parece que no encontramos lo que buscas";

    div.classList.add('store__error');
    div.appendChild(icon);
    div.appendChild(text);
    
    container.innerHTML = "";
    container.appendChild(div);
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

function displayFiltersMenu(menu, background)
{
    menu.style.maxWidth = '210px';
    background.classList.replace('main__background', 'main__background--visible');

}

function hideFiltersMenu(menu, background)
{
    menu.style.maxWidth = '0px';
    setTimeout(()=>{
        menu.removeAttribute('style');
    }, 360);

    background.classList.replace('main__background--visible', 'main__background');
}

/**
 * Reload some variables and listeners when it is call
 */
function listeners()
{
    container = document.querySelector('.store__container--products');

    // Cards button
    cardButtons = document.querySelectorAll('.card__button'),

    cardButtons.forEach(button => {
        button.addEventListener('click', ()=>{
            let game = button.getAttribute('game');
            let platform = button.getAttribute('platform');
            setGameCart([game, platform]);
        });
    });

    // Paginator listener
    pageBtnStore = document.querySelectorAll('[class*="paginator__button"]');
    actualPage = document.querySelector('.paginator__actual');
    if(actualPage != 'undefined' && actualPage != null) actualPage.textContent = page;
    lastPage = document.querySelector('.paginator__last');

    pageBtnStore.forEach(btn => {
        btn.addEventListener('click', ()=>{
            let direction = btn.getAttribute('direction');
            if (!btn.classList.contains('paginator__button--disabled')){
                direction == 'left'  ?     page -= 1 :     page += 1;
                getData(page);
            }
        });
    });

    filterButton.addEventListener('click', ()=>{
        displayFiltersMenu(filtersMenu, filterMenuBackground);
    });

    closeMenuButton.addEventListener('click', ()=>{
        hideFiltersMenu(filtersMenu, filterMenuBackground);
    });
}