let button = document.querySelectorAll('.order__icon');

button.forEach(arrow => {
    arrow.addEventListener('click', ()=>{
        let parent = arrow.parentNode.parentNode;
        let container = parent.querySelector('.order__bottom');

        if(container.classList.contains('collapsed')){
            container.classList.toggle('collapsed');
            let h = container.offsetHeight;


            console.log(h);
            container.style.maxHeight = h+"px";
            
            setTimeout(()=>{

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