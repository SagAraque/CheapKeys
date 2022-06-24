// Paginator variables
let usersBtn = document.querySelectorAll('.paginator__button--users'),
    productsBtn = document.querySelectorAll('.paginator__button--products'),
    actualPage = 1,
    lastPage = document.querySelector('.paginator__last'),
    paginatorActual = document.querySelector('.paginator__actual');

//Users variables
let userContainer = document.querySelector('.users__container--column'),
    usersContainerData = document.querySelector('.users__container--data'),
    modifyUserButtons = document.querySelectorAll('.modify__user'),
    deleteUserButtons = document.querySelectorAll('.delete__user'),
    userFormButton = document.querySelector('.admin__button--form'),
    usersButtonsMenu = document.querySelectorAll('.users__button--menu'),
    userCard = document.querySelectorAll('.users__card');

//Products variables
let productsContainer = document.querySelector('.products__container--column'),
    productsContainerData = document.querySelector('.products__container--data'),
    productsButtonsMenu = document.querySelectorAll('.products__button--menu'),
    deleteProductsButtons = document.querySelectorAll('.delete__product'),
    keysForm = document.querySelector('.products__form--keys'),
    keysInput = document.querySelector('.products__input--none'),
    productCard = document.querySelectorAll('.products__card');

//Add products variables
let textArea = document.querySelector('.admin__textArea'),
    buttonTitle = document.querySelector('.form__button--title'),
    buttonText = document.querySelector('.form__button--text');

// Orders variables
let ordersButtonsMenu = document.querySelectorAll('.orders__button--menu');

let userController = null,
    productController = null;

let searchInputUsers = document.querySelector('.search__input--users'),
    searchInputProducts = document.querySelector('.search__input--products');

try {
    usersListeners();
    reloadUsersInfoData();
} catch (error) {}

try {
    productsListeners();
    reloadProductsInfoData();
} catch (error) {}

try {
    addProductsListeners();
} catch (error) {}

try {
    ordersListeners();
} catch (error) {}


async function changePage(direction, container, route, search)
{
    direction == 'left'  ?     actualPage -= 1 :     actualPage += 1;

    setLoading(container);

    let response = await fetch(route+ actualPage + `&search=${search}`);
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

function setTag(tag, text, selected)
{
    let tagText = tag == 'title' ? `<h2 class="desc__title">\r\t${selected}\r</h2> \r\r` : `<p class="desc__text">\r\t${selected}\r</p> \r\r`;

    return text.replace(selected, tagText);
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
    if(userController) userController.abort();

    userController = new AbortController();

    setLoading(usersContainerData);

    let response = await fetch(`/administracion/user_data?id=${id}`, {
        signal : userController.signal
    });
    await response.text().then((data) => {usersContainerData.innerHTML = data}).then(()=>{userController = null});
    reloadUsersInfoData();
}

async function getGameData(game, platform)
{
    if(productController) productController.abort();

    productController = new AbortController();

    setLoading(productsContainerData);

    let response = await fetch(`/administracion/product_data?game=${game}&platform=${platform}`, {
        signal : productController.signal
    });
    await response.text().then((data) => {productsContainerData.innerHTML = data}).then(()=>{productController = null});
    reloadProductsInfoData();
}


// ----- Paginator init functions start ----- //

async function initUsearChangePage(button)
{
    let direction = button.getAttribute('direction');
    let route = '/administracion/getUsers?page=';
    if (!button.classList.contains('paginator__button--disabled')) 
        await changePage(direction, userContainer, route, searchInputUsers.value); 

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

function deleteUser(id, container)
{
    let state = container.querySelector('.users__state');
    fetch(`/administracion/user_delete?id=${id}`);
    state.classList.replace('users__state', 'users__state--red');
}

function deleteGame(game, platform, container)
{
    fetch(`/administracion/product_delete?game=${game}&platform=${platform}`);
    let state = container.querySelector('.products__state');
    state.classList.replace('products__state', 'products__state--red');
}

function changeView(button, section)
{
    let buttonActive = document.querySelector(`.${section}__button--active`);
    let target = button.getAttribute('target');
    let targetSections = document.querySelectorAll(`[data="${target}"]`);
    let sections = document.querySelectorAll(`.${section}__container--info`);

    sections.forEach(section =>{
        if(!section.classList.contains('displayNone')) section.classList.add('displayNone');
    });

    targetSections.forEach(section => {
        section.classList.remove('displayNone');
    });

    buttonActive.classList.remove(`${section}__button--active`);
    button.classList.toggle(`${section}__button--active`);
}

async function search(value, container, route, reloadFunction)
{
    if(userController) userController.abort();

    userController = new AbortController();

    setLoading(container);

    let response = await fetch(`/administracion/${route}?search=${value}`, {
        signal: userController.signal
    });
    await response.text().then(data => {container.innerHTML = data});
    reloadFunction();
}

async function uploadKeys(form)
{
    let formData = new FormData(form);
    let tableBody = document.querySelector('.keys__body');
    
    let response = await fetch('/administracion/upload_keys',{
        method: 'post',
        body: formData,
    });

    await response.json().then(data =>{
        while(tableBody.hasChildNodes())
        {
            tableBody.removeChild(tableBody.firstChild);
        }

        data.forEach(key => {
            let row = document.createElement('tr'),
                idCol= document.createElement('td'),
                valueCol = document.createElement('td'),
                orderCol = document.createElement('td'),
                icon = document.createAttribute('i'),
                iconCol = document.createElement('td');

            row.classList.add('table__row');
            idCol.classList.add('table__column');
            valueCol.classList.add('table__column');
            orderCol.classList.add('table__column');
            icon.classList.add('bi bi-trash card__icon delete__product')

            idCol.textContent = key.idKey;
            valueCol.textContent = key.keyValue;
            orderCol.textContent = 'Sin pedido';
            iconCol.appendChild(icon);

            row.appendChild(idCol);
            row.appendChild(valueCol);
            row.appendChild(orderCol);
            row.appendChild(iconCol);
            tableBody.appendChild(row);
        });
    }).catch(()=>{
        let error = document.createElement('p');
        error.classList.add('form__error');
        error.textContent = 'Entradas duplicadas';
        tableBody.parentNode.parentNode.appendChild(error);
    });
}

// ----- Paginator init functions end ----- //


// ----- Data reload functions start ----- //

function reloadUsersData()
{
    userContainer = document.querySelector('.users__container--column');
    usersBtn = document.querySelectorAll('.paginator__button--users');
    userCard = document.querySelectorAll('.users__card');
    modifyUserButtons = document.querySelectorAll('.modify__user');
    deleteUserButtons = document.querySelectorAll('.delete__user');
    reloadPaginator();
    usersListeners();
}

function reloadProductsData()
{
    productsContainer = document.querySelector('.products__container--column');
    productsBtn = document.querySelectorAll('.paginator__button--products');
    deleteProductsButtons = document.querySelectorAll('.delete__product');
    productCard = document.querySelectorAll('.products__card');
    reloadPaginator();
    productsListeners();
}

function reloadUsersInfoData()
{
    usersButtonsMenu = document.querySelectorAll('.users__button--menu');
    usersButtonsMenu.forEach(button => {
        button.addEventListener('click', ()=>{ changeView(button, 'users') })
    });
}

function reloadProductsInfoData()
{
    productsButtonsMenu = document.querySelectorAll('.products__button--menu');
    keysForm = document.querySelector('.products__form--keys');
    keysButton = keysForm.querySelector('.admin__button');
    keysInput = document.querySelector('.products__input--none');

    productsButtonsMenu.forEach(button => {
        button.addEventListener('click', ()=>{ changeView(button, 'products') })
    });

    keysButton.addEventListener('click', ()=>{ keysInput.click() });

    keysInput.addEventListener('change', ()=>{ uploadKeys(keysForm) })
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
        card.addEventListener('click', (event) => {

            let modifyButton = card.querySelector('.modify__user'),
                deleteButton = card.querySelector('.delete__user');

            if(event.target != deleteButton && event.target != modifyButton ){
                getUserData(card.getAttribute('user'));
            }
        });
    });

    modifyUserButtons.forEach(modifyButton => {
        modifyButton.addEventListener('click', ()=>{
            let id = modifyButton.getAttribute('user');
            setUserForm(id);
        });
    });

    deleteUserButtons.forEach(deleteButton => {
        deleteButton.addEventListener('click', ()=>{
            let id = deleteButton.getAttribute('user');
            let container = deleteButton.parentNode.parentNode;
            deleteUser(id, container)
        });
    });

    searchInputUsers.addEventListener('input', ()=>{
        search(searchInputUsers.value, userContainer, 'search_users', () =>{reloadUsersData()});
    });
}

function productsListeners()
{
    keysButton = keysForm.querySelector('.admin__button');
    
    productsBtn.forEach(button => {
        button.addEventListener('click', ()=> {initProductsChangePage(button)});
    });

    productCard.forEach(card =>{
        card.addEventListener('click', (event) => {

            let modifyButton = card.querySelector('.modify__product'),
                deleteButton = card.querySelector('.delete__product');

            if(event.target != deleteButton && event.target != modifyButton ){
                let game = card.getAttribute('game');
                let platform = card.getAttribute('platform');
                getGameData(game, platform);
            }
        });
    });

    deleteProductsButtons.forEach(deleteButton => {
        deleteButton.addEventListener('click', ()=>{
            let game = deleteButton.getAttribute('game')
                platform = deleteButton.getAttribute('platform'),
                container = deleteButton.parentNode.parentNode;

            deleteGame(game, platform, container);
        });
    });

    searchInputProducts.addEventListener('input', ()=>{
        search(searchInputProducts.value, productsContainer, 'search_products', () =>{reloadProductsData()});
    });
}

function addProductsListeners()
{
    buttonTitle.addEventListener('click', ()=>{
        let selected = window.getSelection().toString();
        let text = textArea.value;
    
        textArea.value=setTag('title', text, selected);
    });
    
    buttonText.addEventListener('click', ()=>{
        let selected = window.getSelection().toString();
        let text = textArea.value;
    
        textArea.value=setTag('text', text, selected);
    });
}

function ordersListeners()
{
    ordersButtonsMenu.forEach(button => {
        button.addEventListener('click', ()=>{ changeView(button, 'orders') })
    });
}

// ----- Listeners functions end ----- //
