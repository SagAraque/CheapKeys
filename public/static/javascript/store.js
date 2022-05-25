let checkbox = document.querySelectorAll('.store__checkBox'),
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

    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200){
            let response = xhr.responseText
        }
    }
}