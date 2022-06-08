let button = document.querySelectorAll('.order__icon');
        pageBtn = document.querySelectorAll('[class*="paginator__button"]'),
        ordersContainer = document.querySelector('.control__order'),
        lastPage = document.querySelector('.paginator__last').textContent,
        actual = document.querySelector('.paginator__actual'),
        page = 1,
        orderXhr = "";

init();

pageBtn.forEach(button => {
    button.addEventListener('click', ()=>{
        let direction = button.getAttribute('direction');
        changePage(direction);
    });
});

function changePage(direction)
{
    direction == 'left'  ?     page -= 1 :     page += 1;
    
    if(orderXhr != "") orderXhr.abort();
    orderXhr = new XMLHttpRequest();

    orderXhr.open('GET', '/ajax/get_orders?page='+page, true);
    orderXhr.send();

    setLoading(ordersContainer);
    actual.innerHTML = page;
    changeButtons(page, pageBtn[0], pageBtn[1], lastPage);

    orderXhr.onreadystatechange = ()=>{
        if(orderXhr.readyState == 4 && orderXhr.status == 200){
            ordersContainer.innerHTML = orderXhr.responseText;
            init();
        }
    }
}


function init()
{
    button = document.querySelectorAll('.order__icon');

    button.forEach(arrow => {
        arrow.addEventListener('click', ()=>{
            let container = arrow.parentNode.parentNode;
            let bottom = container.querySelector('.order__bottom');
            collapse('collapsed', bottom, arrow);    
        })
    });
}
