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

movileIcon.addEventListener('click', ()=>{
    movileMenu.classList.toggle('header__nav--visible');
    setTimeout(()=>{
        movileMenu.classList.toggle('header__nav--hidde');
    }, 300);
});

try {
    menuMobileIcon.addEventListener('click', ()=>{
        collapseMenu();
    });
} catch (error) {}


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

function collapseMenu()
{
    if(menuList.classList.contains('collapsed--unset')){
        menuList.style.maxHeight = menuList.scrollHeight + 'px';

        setTimeout(()=>{
            menuList.classList.toggle('collapsed--unset');
            menuList.removeAttribute('style')
        }, 400);
    }else{
        menuList.style.maxHeight = menuList.clientHeight + 'px';

        setTimeout(()=>{
            menuList.classList.toggle('collapsed--unset');
            menuList.removeAttribute('style');
        }, 10);
    }

    menuMobileIcon.classList.toggle('control__icon--rotate');
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

