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
        collapse(collapseIcon);
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


function collapse(button)
{
    let container = button.parentNode.parentNode;
    target = container.querySelector('.control__container--collapse');
    // target.classList.toggle('control__container--hidden');

    if(target.classList.contains('collapsed--unset')){
        target.style.maxHeight = target.scrollHeight+'px';

        setTimeout(()=>{
            target.classList.toggle('collapsed--unset');
            onanimationiteration.removeAttribute('style')
        }), 400;
    }else{
        target.style.maxHeight = target.clientHeight+'px';

        setTimeout(()=>{
            target.classList.toggle('collapsed--unset');
            target.removeAttribute('style');
        }, 10);
    }
    button.classList.toggle('control__icon--rotate');
}