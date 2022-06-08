let controlIconCollapse = document.querySelectorAll('.control__icon--collapse'),
    deleteCardButtons = document.querySelectorAll('.pay__icon--delete'),
    deleteBillingButtons = document.querySelectorAll('.billing__icon--delete'),
    container = document.querySelector('.control__container--billing'),
    closeForm = document.querySelectorAll('.card__icon--closeForm'),
    addCardButton = document.querySelector('.control__add--card'),
    formCard = document.querySelector('.control__form--card'),
    addBillingButton = document.querySelector('.control__add--billing'),
    formBilling = document.querySelector('.control__form--billing');
 

controlIconCollapse.forEach(collapseIcon => {
    collapseIcon.addEventListener('click', ()=>{
        let container = collapseIcon.parentNode.parentNode;
        let target = container.querySelector('.control__container--collapse');
        collapse('collapsed--unset', target, collapseIcon);
    })
});

deleteCardButtons.forEach(deleteButton => {
    deleteButton.addEventListener('click', ()=>{
        let container = deleteButton.parentNode;
        deleteUserInfo(container, 'card');
    });
});

deleteBillingButtons.forEach(deleteButton => {
    deleteButton.addEventListener('click', ()=>{
        let container = deleteButton.parentNode;
        deleteUserInfo(container, 'billing');
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
        if(xhr.readyState == 4 && xhr.status == 200)
            cardsContainer.removeChild(card);
    }
}