let movileIcon = document.querySelector('.header__icon--menu')
    headerContainer = document.querySelector('.header__container')
    headerContainerMovile = document.querySelector('.header__container--movile'),
    movileMenu = document.querySelector('.header__nav'),
    searchForm = document.querySelector('.header__form'),
    searchInput = document.querySelector('.header__input'),
    searchContainer = document.querySelector('.header__container--search'),
    menuMobileIcon = document.querySelector('.control__icon--menu'),
    menuList = document.querySelector('.control__list'),
    searchXhr = "";

// Index variables
let indexCardButton = document.querySelectorAll('.card__button'),
    indexGallery = document.querySelector('.index__gallery'),
    indexWrapper = document.querySelector('.gallery__wrapper'),
    indexGalleryImg = document.querySelectorAll('.gallery__asset--index'),
    wrapperPos = 0,
    indexGalleryArrows = document.querySelectorAll('.index__arrow'),
    indexPaginatorGallery = document.querySelectorAll('[class*="gallery__ball"]');


if(indexWrapper != 'undefined' && indexWrapper != null){
    indexWrapper.addEventListener('dragstart',  (e)=> {
        wrapGallery(indexGalleryImg, indexWrapper, e.pageX, indexPaginatorGallery);
    });
} 

indexGalleryArrows.forEach(arrow =>{
    arrow.addEventListener('click', ()=>{
        let direction = arrow.getAttribute('direction') == 'left' ? -1 : 1;
        moveGalleryWrapper( indexWrapper, indexGalleryImg, direction, indexPaginatorGallery);
    });
});


indexCardButton.forEach(button => {
    button.addEventListener('click', ()=>{
        let id = button.getAttribute('game');
        let platform = button.getAttribute('platform');
        setGameCart([id, platform]);
    });
    
});

movileIcon.addEventListener('click', ()=>{
    movileMenu.classList.toggle('header__nav--visible');
    setTimeout(()=>{
        movileMenu.classList.toggle('header__nav--hidde');
    }, 300);
});

if(menuMobileIcon != 'undefined' && menuMobileIcon != null){
    menuMobileIcon.addEventListener('click', ()=>{
        collapse('collapsed--unset', menuList, menuMobileIcon);
    });
}


searchInput.addEventListener('input', ()=>{
    if(searchXhr != "") searchXhr.abort();
    searchXhr = new XMLHttpRequest();
    let input = searchInput.value;

    searchXhr.open('GET', `/ajax/searchBarResult?string=${input}`);
    searchXhr.send();
    
    let searchLoading = setTimeout(()=>{
        setLoading(searchContainer);
    },200);

    searchXhr.onreadystatechange = ()=>{
        if(searchXhr.readyState == 4 && searchXhr.status == 200){
            searchContainer.innerHTML = searchXhr.responseText;
            clearTimeout(searchLoading);
            searchXhr = "";
        }else if(searchXhr.readyState == 4 && searchXhr.status == 404){
            searchContainer.innerHTML = "";
            clearTimeout(searchLoading);
        }
    }
});


document.addEventListener('click', (e)=>{
    if(e.target != searchInput || e.target != searchContainer){
        searchContainer.innerHTML = "";
        if(typeof variable != 'undefined' && variable != null) clearTimeout(searchLoading);
        if(searchXhr != "") searchXhr.abort();
    }
})

function setLoading(div, elementClass = 'reviews__loading')
{
    let loading = document.createElement('div');
    loading.classList.add(elementClass);
    div.innerHTML = "";
    div.appendChild(loading);
}

function collapse(collapseClass, element, icon)
{
    if(element.classList.contains(collapseClass)){
        element.style.maxHeight = element.scrollHeight + 'px';

        setTimeout(()=>{
            element.classList.toggle(collapseClass);
            element.removeAttribute('style')
        }, 400);
    }else{
        element.style.maxHeight = element.clientHeight + 'px';

        setTimeout(()=>{
            element.classList.toggle(collapseClass);
            element.removeAttribute('style');
        }, 10);
    }

    icon.classList.toggle('control__icon--rotate');
}

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
}

/**
 * Set a game to the user
 * 
 * @param {*} gameData Game if and platform id
 */
 function setGameCart(gameData)
 {
     let xhr = new XMLHttpRequest();
 
     let data = new FormData();
     data.append('game', gameData[0]);
     data.append('platform', gameData[1]);
     try {
         data.append('cartCount', cartNum.textContent);
     } catch (error) {
         data.append('cartCount', 0);
     }
    
     xhr.open('POST', '/ajax/addProductCart', true);
     xhr.send(data);
 
     xhr.onreadystatechange = ()=>{
         if(xhr.readyState == 4 && xhr.status == 302){
             window.location.href = '/users/login'; 
         }else if(xhr.readyState == 4 && xhr.status == 200){
             cartNum.textContent = xhr.responseText;
         }
     }
 }


 /**
 * Do mobile gallery wrap function when mouse is moving to detect th direction
 * of the movement and change the image and paginator
 * @param {*} imgs Images used to extract the correct width
 * @param {*} wrapper Wraper container with all images
 * @param {*} initialPos Mouse initial position
 * @param {*} paginator Gallery paginator
 */
function wrapGallery(imgs, wrapper, initialPos, paginator = null)
{
    wrapper.addEventListener('mousemove', (e)=>{
        e.pageX > initialPos ? direction = -1 : direction = 1;

        moveGalleryWrapper(wrapper, imgs, direction, paginator);

    }, {once : true});
}

function moveGalleryWrapper(wrapper, imgs, direction, paginator = null)
{
    let imgWidth = imgs[0].offsetWidth,
        max = imgWidth * imgs.length;

    wrapperPos -= imgWidth * direction;

    if(Math.abs(wrapperPos) >= max) wrapperPos = 0;
    if(wrapperPos > 0) wrapperPos = -max + imgWidth;

    wrapper.style.transform = `translateX(${wrapperPos}px)`;

    // Change paginator classes
    let index = Math.abs(wrapperPos / imgWidth);
    
    if(paginator != null)
    {
        paginator.forEach(ball => {
            ball.classList.replace('gallery__ball--selected', 'gallery__ball');
        });
        paginator[index].classList.replace('gallery__ball', 'gallery__ball--selected');
    }
}

