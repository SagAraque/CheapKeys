let movileIcon = document.querySelector('.header__icon--menu')
headerContainer = document.querySelector('.header__container')
headerContainerMovile = document.querySelector('.header__container--movile'),
movileMenu = document.querySelector('.header__nav'),
searchButton = document.querySelector('.header__icon--search'),
searchForm = document.querySelector('.header__form');

movileIcon.addEventListener('click', ()=>{
    movileMenu.classList.toggle('header__nav--visible');
    setTimeout(()=>{
        movileMenu.classList.toggle('header__nav--hidde');
    }, 300)
});

searchButton.addEventListener('click', ()=>{
    searchForm.classList.toggle('header__form--visible');
    headerContainer.classList.toggle('opacityNone');
    headerContainerMovile.classList.toggle('opacityNone');
});