let deleteButton = document.querySelectorAll('.cart__icon--delete'),
cartPrice = document.querySelector('.cart__text--total'),
cartTotal = document.querySelector('.cart__text'),
cartTotalHeader = document.querySelector('.header__cartCant'),
cardsContainer = document.querySelector('.cart__products');

deleteButton.forEach(button => {
    button.addEventListener('click', () =>{
        let container = button.parentNode;
        let card = container.parentNode;
        removeGame(card);
    })
});


function removeGame(card)
{
    let xhr = new XMLHttpRequest()

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
