let pageBtn = document.querySelectorAll('[class*="reviews__button"]');
let reviewsSection = document.querySelector('.reviews');
let reviewsContainer = document.querySelector('.reviews__container');
let lastPage = document.querySelector('.reviews__last').textContent;
let actual = document.querySelector('.reviews__actual');
let page = 1;

pageBtn.forEach(btn => {
    btn.addEventListener('click', ()=>{

        let id = reviewsSection.getAttribute('target');
        let direction = btn.getAttribute('direction');

        if (!btn.classList.contains('reviews__button--disabled')) getReviews(direction, id);

    });
});


function getReviews(direction, id)
{
    direction == 'left'  ?     page -= 1 :     page += 1;

    xhr = new XMLHttpRequest();
    xhr.open('GET', `/ajax/reviews?id=${id}&page=${page}`, true);
    xhr.send();

    setLoading(reviewsContainer);

    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200)
            reviewsContainer.innerHTML = xhr.responseText;
            actual.innerHTML = page;
            changeButtons();
    }

    reviewsSection.scrollIntoView({
        behavior:"smooth"
    });
}

function changeButtons()
{
    if(page == 1){
        pageBtn[0].classList.replace('reviews__button', 'reviews__button--disabled');
    }else{
        pageBtn[0].classList.replace('reviews__button--disabled', 'reviews__button');
    }

    if(page == lastPage){
        pageBtn[1].classList.replace('reviews__button', 'reviews__button--disabled');
    }else{
        pageBtn[1].classList.replace('reviews__button--disabled', 'reviews__button');
    }
}