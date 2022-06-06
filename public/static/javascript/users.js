let buttons = document.querySelectorAll('.control__x'),
    imgFormInput = document.querySelector('.control__input--img');

imgFormInput.addEventListener('change', ()=>{
    changeImg(imgFormInput);
});


function changeImg(imgInput)
{
    let formData = new FormData(imgInput.parentNode);
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/ajax/set_user_image', true);
    xhr.send(formData);
}

