let buttons = document.querySelectorAll('.control__x'),
    container = document.querySelector('.control__container--billing'),
    closeForm = document.querySelectorAll('.card__icon--closeForm'),
    addCardButton = document.querySelector('.control__add--card'),
    formCard = document.querySelector('.control__form--card'),
    addBillingButton = document.querySelector('.control__add--billing'),
    formBilling = document.querySelector('.control__form--billing'),
    deleteCardButtons = document.querySelectorAll('.pay__icon--delete'),
    deleteBillingButtons = document.querySelectorAll('.billing__icon--delete'),
    imgFormInput = document.querySelector('.control__input--img');

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
})

closeForm.forEach(button => {
    button.addEventListener('click', ()=>{
        let container = button.parentNode.parentNode;
        container.classList.toggle('control__container--none');
    });
});

imgFormInput.addEventListener('change', ()=>{
    changeImg(imgFormInput);
});

function deleteBillingDirection(id)
{
    let xhr = new XMLHttpRequest();

    let data = new FormData()
    data.append('id', id);

    xhr.open('POST', '/ajax/deleteBilling', true);
    xhr.send(data);
}

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

function changeImg(imgInput)
{
    let formData = new FormData(imgInput.parentNode);
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/ajax/set_user_image', true);
    xhr.send(formData);
}