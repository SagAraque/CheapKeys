let pageBtn = document.querySelectorAll('[class*="paginator__button"]');
let reviewsSection = document.querySelector('.reviews');
let reviewsContainer = document.querySelector('.reviews__container');
let lastPage = document.querySelector('.paginator__last').textContent;
let actual = document.querySelector('.paginator__actual');
let page = 1;

pageBtn.forEach(btn => {
    btn.addEventListener('click', ()=>{

        let id = reviewsSection.getAttribute('target');
        let direction = btn.getAttribute('direction');

        if (!btn.classList.contains('paginator__button--disabled')) getReviews(direction, id);

    });
});


function getReviews(direction, id)
{
    direction == 'left'  ?     page -= 1 :     page += 1;

    xhr = new XMLHttpRequest();
    xhr.open('GET', '/ajax/reviews?id='+id+'&page='+page, true);
    xhr.send();

    setLoading(reviewsContainer);

    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200){
            reviewsContainer.innerHTML = xhr.responseText;
            actual.innerHTML = page;
            changeButtons(page, pageBtn[0], pageBtn[1], lastPage);
        }
    }

    reviewsSection.scrollIntoView({
        behavior:"smooth"
    });
}