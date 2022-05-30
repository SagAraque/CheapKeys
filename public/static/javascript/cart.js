let deleteButton = document.querySelectorAll('.card__icon--delete'),
cartPrice = document.querySelector('.cart__text--total'),
cartTotal = document.querySelector('.cart__text'),
cartTotalHeader = document.querySelector('.header__cartCant'),
dashButton = document.querySelectorAll('.bi-dash-square'),
addButton = document.querySelectorAll('.bi-plus-square'),
cardsContainer = document.querySelector('.cart__products');

deleteButton.forEach(button => {
    button.addEventListener('click', () =>{
        let container = button.parentNode;
        let card = container.parentNode;
        removeGame(card);
    })
});

dashButton.forEach(button =>{
    button.addEventListener('click', () =>{
        let container = button.parentNode.parentNode;
        let card = container.parentNode;
        changeCant(-1, card)
    });
});

addButton.forEach(button =>{
    button.addEventListener('click', () =>{
        let container = button.parentNode.parentNode;
        let card = container.parentNode;
        changeCant(1, card)
    });
});


function removeGame(card)
{
    let xhr = new XMLHttpRequest();

    let data = new FormData();
    data.append('game', card.getAttribute('targetgame'));
    data.append('platform',  card.getAttribute('targetplatform'));

    xhr.open('POST', '/ajax/removeCartProduct', true);
    xhr.send(data);

    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 302){
            window.location.href = '/users/login'; 
        }else if(xhr.readyState == 4 && xhr.status == 200){
            let response = JSON.parse(xhr.responseText);

            cartPrice.textContent = parseFloat(response.totalPrice).toFixed(2) + ' €';
            cartTotalHeader.textContent = response.cartTotal;
            cartTotal.textContent = response.cartTotal;
            cardsContainer.removeChild(card);
        }
    }
}

function changeCant(changeValue, card)
{
    let xhr = new XMLHttpRequest();

    let data = new FormData();
    data.append('game', card.getAttribute('targetgame'));
    data.append('platform',  card.getAttribute('targetplatform'));
    data.append('changeValue', changeValue);

    xhr.open('POST', '/ajax/changeCartCant', true);
    xhr.send(data);

    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200){
            let response = JSON.parse(xhr.responseText);
            let cartCant = card.querySelector('.cart__cant');
            let newCant = parseInt(cartCant.textContent) + parseInt(changeValue);

            cartPrice.textContent = parseFloat(response.totalPrice).toFixed(2) + '€';
            cartTotalHeader.textContent = response.cartTotal;
            cartTotal.textContent = response.cartTotal;

            if(newCant <= 0){
                cardsContainer.removeChild(card);
            }else{
                cartCant.textContent = newCant;
            }
        }
    }

}
