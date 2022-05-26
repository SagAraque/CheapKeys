let checkbox = document.querySelectorAll('.store__checkBox'),
container = document.querySelector('.store__container--products')
developerData = [],
platformData = [],
pegiData = [],
stockData = [],
actualPage = document.querySelector('.store__actual');


checkbox.forEach(input => {
    input.addEventListener('change', ()=>{
        let value = input.getAttribute('value');
        let list = input.parentNode.parentNode.parentNode;

        switch(list.getAttribute('data-type'))
        {
            case 'developer':
                input.checked ? developerData.push(value) : modifyArray(value, developerData);
                break;
            case 'platform':
                input.checked ? platformData.push(value) : modifyArray(value, platformData);
                break;
            case 'pegi':
                input.checked ? pegiData.push(value) : modifyArray(value, pegiData);
                break;
            case 'stock':
                input.checked ? stockData.push(value) : modifyArray(value, stockData);
                break;
        }

        getData();
    })
});


function modifyArray(value, arr)
{
    let i = arr.indexOf(value);
    if(i !== -1) arr.splice(i, 1);
}

function getData()
{
    let xhr = new XMLHttpRequest();
    let data = new FormData();
    
    data.append('dev', developerData);
    data.append('platform', platformData);
    data.append('pegi', pegiData);
    data.append('stock', stockData)
    data.append('page', actualPage == null ? 1: actualPage.textContent);

    xhr.open('POST', '/ajax/changeStoreProducts', true);
    xhr.send(data);

    let loading = setTimeout(()=>{
        setLoading();
    },200);

    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200){
            clearTimeout(loading);
            container.innerHTML = xhr.responseText;
        }else if(xhr.readyState == 4 && xhr.status == 404){
            clearTimeout(loading);
            setError()
        }
    }
}

function setLoading()
{
    let loading = document.createElement('div');
    loading.classList.add('reviews__loading');
    container.innerHTML = "";
    container.appendChild(loading);
}

function setError()
{
    let div = document.createElement('div');
    let text = document.createElement('span');
    let icon = document.createElement('i');

    icon.classList.add('bi');
    icon.classList.add('store__error--icon');
    icon.classList.add('bi-exclamation-triangle');

    text.classList.add('store__error--text');
    text.textContent = "Parece que no encontramos lo que buscas";

    div.classList.add('store__error');
    div.appendChild(icon);
    div.appendChild(text);
    
    container.innerHTML = "";
    container.appendChild(div);
}