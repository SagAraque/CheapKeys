let pageBtn = document.querySelectorAll('[class*="reviews__page"]');
let reviewsSection = document.querySelector('.reviews');
let reviewsContainer = document.querySelector('.reviews__container');

pageBtn.forEach(btn => {
    btn.addEventListener('click', ()=>{
        let id = reviewsSection.getAttribute('target');
        getReviews(btn.textContent, id, btn);
    });
});


function getReviews(page, id, button)
{
    xhr = new XMLHttpRequest();
    xhr.open('GET', `/ajax/reviews?id=${id}&page=${page}`, true);
    xhr.send();

    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200)
            reviewsContainer.innerHTML = xhr.responseText;
            changeSelected(button);
    }

    reviewsSection.scrollIntoView({
        behavior:"smooth"
    });
}

function changeSelected(button)
{
    let selected = document.querySelector('.reviews__page--selected');
    selected.classList.replace('reviews__page--selected', 'reviews__page');
    button.classList.replace('reviews__page', 'reviews__page--selected');
}