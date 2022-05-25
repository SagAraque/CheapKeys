let checkbox = document.querySelectorAll('.store__checkBox'),
container = document.querySelector('.store__container--products')
developerData = [];


checkbox.forEach(input => {
    input.addEventListener('change', (event)=>{
        let value = input.getAttribute('value');

        event.currentTarget.checked ? developerData.push(value) : modifyArray(value, developerData);

        console.log(developerData)
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

    xhr.open('POST', '/ajax/changeStoreProducts', true);
    xhr.send(data);

    let loading = setTimeout(()=>{
        setLoading();
    },200);

    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200){
            clearTimeout(loading);
            container.innerHTML = xhr.responseText;
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