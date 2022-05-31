let movileIcon = document.querySelector('.header__icon--menu')
headerContainer = document.querySelector('.header__container')
headerContainerMovile = document.querySelector('.header__container--movile'),
movileMenu = document.querySelector('.header__nav'),
searchForm = document.querySelector('.header__form'),
searchInput = document.querySelector('.header__input'),
searchContainer = document.querySelector('.header__container--search'),
xhr = "";

movileIcon.addEventListener('click', ()=>{
    movileMenu.classList.toggle('header__nav--visible');
    setTimeout(()=>{
        movileMenu.classList.toggle('header__nav--hidde');
    }, 300);
});

searchInput.addEventListener('input', ()=>{
    if(xhr != "") xhr.abort();
    xhr = new XMLHttpRequest();
    let input = searchInput.value;

    xhr.open('GET', `/ajax/searchBarResult?string=${input}`);
    xhr.send();
    
    let searchLoading = setTimeout(()=>{
        setLoading(searchContainer);
    },200);

    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200){
            searchContainer.innerHTML = xhr.responseText;
            clearTimeout(searchLoading);
            xhr = "";
        }else if(xhr.readyState == 4 && xhr.status == 404){
            searchContainer.innerHTML = "";
            clearTimeout(searchLoading);
        }
    }
});


document.addEventListener('click', (e)=>{
    if(e.target != searchInput || e.target != searchContainer){
        searchContainer.innerHTML = "";
        clearTimeout(searchLoading);
        if(xhr != "") xhr.abort();
    }
})

function setLoading(div, elementClass = 'reviews__loading')
{
    let loading = document.createElement('div');
    loading.classList.add(elementClass);
    div.innerHTML = "";
    div.appendChild(loading);
}

