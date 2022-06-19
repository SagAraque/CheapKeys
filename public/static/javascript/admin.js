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
let productsContainer = document.querySelector('.products__container--column');

let  userController = null;



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
    if(userController) userController.abort();

    userController = new AbortController();

    setLoading(usersContainerData);

    let response = await fetch(`/administracion/user_data?id=${id}`, {
        signal : userController.signal
    });
    await response.text().then((data) => {usersContainerData.innerHTML = data}).then(()=>{userController = null});
    reloadUsersData();

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

function deleteUser(id, container)
{
    fetch(`/administracion/user_delete?id=${id}`);
    let state = container.querySelector('.users__state');
    state.classList.replace('users__state', 'users__state--red');
}

function changeUserView(button)
{
    let buttonActive = document.querySelector('.users__button--active');
    let target = button.getAttribute('target');
    let targetSections = document.querySelectorAll(`[data="${target}"]`);
    let sections = document.querySelectorAll('.users__container--info');

    sections.forEach(section =>{
        if(!section.classList.contains('displayNone')) section.classList.add('displayNone');
    });

    targetSections.forEach(section => {
        section.classList.remove('displayNone');
    });

    buttonActive.classList.remove('users__button--active');
    button.classList.toggle('users__button--active');
}

// ----- Paginator init functions end ----- //


// ----- Data reload functions start ----- //

function reloadUsersData()
{
    userContainer = document.querySelector('.users__container--column');
    usersBtn = document.querySelectorAll('.paginator__button--users');
    userCard = document.querySelectorAll('.users__card');
    modifyUserButtons = document.querySelectorAll('.modify__user');
    usersButtonsMenu = document.querySelectorAll('.users__button--menu');
    deleteUserButtons = document.querySelectorAll('.delete__user');
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
        card.addEventListener('click', (event) => {
            if(event.target != modifyUserButtons[0] && event.target !=deleteUserButtons[0] ){
                let id = card.getAttribute('user');
                getUserData(id);
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

    usersButtonsMenu.forEach(button => {
        button.addEventListener('click', ()=>{
            changeUserView(button);
        })
        
    });
}

function productsListeners()
{
    productsBtn.forEach(button => {
        button.addEventListener('click', ()=> {initProductsChangePage(button)});
    });
}

// ----- Listeners functions end ----- //
