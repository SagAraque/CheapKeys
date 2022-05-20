let buttons = document.querySelectorAll('.control__x');
let container = document.querySelector('.control__container--billing');

buttons.forEach(button => {
    button.addEventListener('click', ()=>{
        let id = button.getAttribute('target');
        deleteBillingDirection(id);
        container.removeChild(button.parentNode);
    });
});


function deleteBillingDirection(id)
{
    let xhr = new XMLHttpRequest();

    let data = new FormData()
    data.append('id', id);

    xhr.open('POST', '/ajax/deleteBilling', true);
    xhr.send(data);
}