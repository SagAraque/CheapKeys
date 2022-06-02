let min = document.querySelectorAll('[class*="gallery__min"]'),
    gallery = document.querySelector('.gallery__asset'),
    arrows = document.querySelectorAll('.gallery__arrow'),
    objectIndex = 0,
    wishlist = document.querySelector('.info__button--wish'),
    wishlistIcon = document.querySelector('.info_icon--wish'),
    cartButton = document.querySelector('.info__button--buy'),
    cartNum = document.querySelector('.header__cartCant');

// Mobile gallery variables
let slider = document.querySelector('.slider'),
    wrapper = document.querySelector('.gallery__wrapper'),
    wrapperImg = document.querySelectorAll('.gallery__asset--mobile'),
    sliderPaginator = document.querySelectorAll('[class*="gallery__ball"]'),
    wrapperPos = 0;


wrapper.addEventListener('dragstart',  (e)=> {
    wrapGallery(wrapperImg, wrapper, e.pageX, sliderPaginator);
});

window.addEventListener('resize', ()=>{
    wrapperPos = 0;
    wrapper.style.transform = `translateX(0px)`;
});

// Wishlist button
wishlist.addEventListener('click', ()=>{
   setWishlist(product);
});


// Gallery buttons
min.forEach(element => {
    element.addEventListener('click', ()=>{
        if(!element.classList.contains('gallery__min--selected')){
            changeGalleryImg(element);
            let img = element.querySelector('.gallery__asset').getAttribute('src');
            img = img.replace('/static/img/games/', '');
            img = img.replace('-min.webp', '');
            objectIndex = Array.prototype.indexOf.call(images, img);
        } 
    });
});

arrows.forEach(arrow =>{
    arrow.addEventListener('click', ()=>{
        slide(arrow.getAttribute('slide'));
    });
});


// Cart button
cartButton.addEventListener('click', ()=>{
    setGameCart(product);
});



// Gallery functions
function changeGalleryImg(min)
{
    let minSelected = document.querySelector('.gallery__min--selected');
    let src = min.querySelector('.gallery__asset').getAttribute('src');
    src = src.replace('-min', '');

    minSelected.classList.replace('gallery__min--selected', 'gallery__min');
    min.classList.replace('gallery__min', 'gallery__min--selected');

    gallery.setAttribute('src', src);
}

function slide(direction)
{
    let minSelected = document.querySelector('.gallery__min--selected');
    let index = Array.prototype.indexOf.call(min, minSelected);

    if(direction == 'right'){
        index += 1;
        objectIndex +=1;

        if(index > 3 && objectIndex < images.length){
            changeMinImg(index - 3, images.length);
            index = 3;
        }else if(objectIndex >= images.length){
            objectIndex = 0;
            index = 0;
            changeMinImg(0, 4);   
        }
    }else{
        index -= 1;
        objectIndex -=1;

        if(index < 0){ 
            if(objectIndex < 0){
                changeMinImg(images.length - 4, images.length);
                index = 3;
                objectIndex = images.length - 1;
            }else{
                changeMinImg(0, 4);
                index = 0;
                objectIndex = 0;
            }
        }
    }

    changeGalleryImg(min[index]);
}

function changeMinImg(init, max)
{   
    let minindex = 0;
    for (let i = init; i < max; i++) {
        img = min[minindex].querySelector('.gallery__asset');
        img.setAttribute('src', `/static/img/games/${images[i]}-min.webp`);
        minindex +=1;
    }
}


// Wishlist functions


function setWishlist(gameData)
{
    let xhr = new XMLHttpRequest();

    let data = new FormData();
    data.append('_game', gameData[0]);
    data.append('_platform', gameData[1]);

    xhr.open('POST', `/ajax/wishlist`, true);
    xhr.send(data);

    if(wishlistIcon.classList.contains('bi-heart-fill')){
        wishlistIcon.classList.replace('bi-heart-fill', 'bi-heart');
    }else{
        wishlistIcon.classList.replace('bi-heart', 'bi-heart-fill');
    }

    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 302){
            window.location.href = '/users/login'; 
        }
    }
}

// Cart functions

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


function wrapGallery(imgs, wrapper, initialPos, paginator)
{
    wrapper.addEventListener('mousemove', (e)=>{
        let imgWidth = imgs[0].offsetWidth,
            max = imgWidth * imgs.length,
            direction = 0;

        e.pageX > initialPos ? direction = -1 : direction = 1

        wrapperPos -= imgWidth * direction;

        if(Math.abs(wrapperPos) >= max) wrapperPos = 0;
        if(wrapperPos > 0) wrapperPos = -max + imgWidth;

        wrapper.style.transform = `translateX(${wrapperPos}px)`;

        // Change paginator classes
        let index = Math.abs(wrapperPos / imgWidth);
        
        paginator.forEach(ball => {
            ball.classList.replace('gallery__ball--selected', 'gallery__ball');
        });
        paginator[index].classList.replace('gallery__ball', 'gallery__ball--selected');

    }, {once : true});
}

