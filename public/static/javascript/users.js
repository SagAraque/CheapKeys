let buttons = document.querySelectorAll('.control__x');
let container = document.querySelector('.control__container--billing');
let closeCardForm = document.querySelector('.card__icon--deletCard');
let addCardButton = document.querySelector('.control__add--card');
let formCard = document.querySelector('.control__form--card');

buttons.forEach(button => {
    button.addEventListener('click', ()=>{
        let id = button.getAttribute('target');
        deleteBillingDirection(id);
        container.removeChild(button.parentNode);
    });
});

addCardButton.addEventListener('click', ()=>{
    let container = formCard.parentNode;
    container.classList.toggle('control__container--none');
});

closeCardForm.addEventListener('click', ()=>{
    let container = formCard.parentNode;
    container.classList.toggle('control__container--none');
});


function deleteBillingDirection(id)
{
    let xhr = new XMLHttpRequest();

    let data = new FormData()
    data.append('id', id);

    xhr.open('POST', '/ajax/deleteBilling', true);
    xhr.send(data);
}