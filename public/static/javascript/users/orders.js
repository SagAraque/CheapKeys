let button = document.querySelectorAll('.order__icon');

try {

    var pageBtn = document.querySelectorAll('[class*="paginator__button"]'),
        ordersContainer = document.querySelector('.control__order'),
        lastPage = document.querySelector('.paginator__last').textContent,
        actual = document.querySelector('.paginator__actual'),
        orderXhr = "",
        page = 1;
    
} catch (error) {}  

button.forEach(arrow => {
    arrow.addEventListener('click', ()=>{
        let parent = arrow.parentNode.parentNode;
        let container = parent.querySelector('.order__bottom');

        if(container.classList.contains('collapsed')){
            container.style.maxHeight = container.scrollHeight +"px";
            
            setTimeout(()=>{
                container.classList.toggle('collapsed');
                container.removeAttribute('style');
            },400); 

        }else{

            container.style.maxHeight=container.clientHeight+"px";
            setTimeout(()=>{
                container.classList.toggle('collapsed');
                container.removeAttribute('style');
            },10);
        }

        arrow.classList.toggle('control__icon--rotate');
        
    })
});

pageBtn.forEach(button => {
    let direction = button.getAttribute('direction');

});

function changePage(direction)
{
    direction == 'left'  ?     page -= 1 :     page += 1;

    orderXhr = new XMLHttpRequest();

    orderXhr.open('GET', '/ajax/get_orders?page='+page, true);
    orderXhr.send();

    setLoading();
    actual.innerHTML = page;

    orderXhr.onreadystatechange(()=>{
        if(orderXhr.readyState == 4 && orderXhr.status == 200){
            ordersContainer.innerHTML = orderXhr.responseText;
        }
    });
}
