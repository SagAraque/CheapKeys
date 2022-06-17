// Paginator variables
let usersBtn = document.querySelectorAll('.paginator__button--users'),
    productsBtn = document.querySelectorAll('.paginator__button--products'),
    actualPage = 1,
    lastPage = document.querySelector('.paginator__last'),
    paginatorActual = document.querySelector('.paginator__actual');

//Users variables
let userContainer = document.querySelector('.users__container--column'),
    usersContainerData = document.querySelector('.users__container--data'),
    userCard = document.querySelectorAll('.users__card');

//Products variables
let productsContainer = document.querySelector('.products__container--column');


try {
    usersListeners();
} catch (error) {}

try {
    productsListeners();
} catch (error) {}



async function changePage(direction, container, route)
{
    direction == 'left'  ?     actualPage -= 1 :     actualPage += 1;

    setLoading(container);

    let response = await fetch(route+ actualPage);
    await response.text().then((data) => {container.innerHTML = data});
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

     paginatorActual.innerHTML = page;
 }
 

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

async function getUserData(id)
{
    setLoading(usersContainerData);

    let response = await fetch('/administracion/user_data?id='+id);
    await response.text().then((data) => {usersContainerData.innerHTML = data}) 
}


// ----- Paginator init functions start ----- //

async function initUsearChangePage(button)
{
    let direction = button.getAttribute('direction');
    let route = '/administracion/getUsers?page=';
    if (!button.classList.contains('paginator__button--disabled')) 
        await changePage(direction, userContainer, route); 

    await reloadUsersData();
    changeButtons(actualPage, usersBtn[0], usersBtn[1], lastPage.textContent);
}

async function initProductsChangePage(button)
{
    let direction = button.getAttribute('direction');
    let route = '/administracion/getGames?page=';
    if (!button.classList.contains('paginator__button--disabled')) 
        await changePage(direction, productsContainer, route); 

    await reloadProductsData();
    changeButtons(actualPage, productsBtn[0], productsBtn[1], lastPage.textContent);
}

// ----- Paginator init functions end ----- //


// ----- Data reload functions start ----- //

function reloadUsersData()
{
    userContainer = document.querySelector('.users__container--column');
    usersBtn = document.querySelectorAll('.paginator__button--users');
    userCard = document.querySelectorAll('.users__card');
    reloadPaginator();
    usersListeners();
}

function reloadProductsData()
{
    productsContainer = document.querySelector('.products__container--column');
    productsBtn = document.querySelectorAll('.paginator__button--products');
    reloadPaginator();
    productsListeners();
}


function reloadPaginator()
{
    lastPage = document.querySelector('.paginator__last');
    paginatorActual = document.querySelector('.paginator__actual');
    lastPage = document.querySelector('.paginator__last');
}

// ----- Data reload functions end ----- //

// ----- Listeners functions start ----- //

function usersListeners()
{
    usersBtn.forEach(button => {
        button.addEventListener('click', ()=> {initUsearChangePage(button)});
    });

    userCard.forEach(card =>{
        card.addEventListener('click', () => {
            let id = card.getAttribute('user');
            getUserData(id);
        });
    });
}

function productsListeners()
{
    productsBtn.forEach(button => {
        button.addEventListener('click', ()=> {initProductsChangePage(button)});
    });
}

// ----- Listeners functions end ----- //
