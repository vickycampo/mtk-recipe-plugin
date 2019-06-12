// global Variables
//Variable that you cannot update
const     sliderView = document.querySelector('.mtk-slider--view'),
          sliderViewSlides = document.querySelectorAll('.mtk-slider--view__slides'),
          arrowLeft = document.querySelector('.mtk-slider--arrows__left'),
          arrowRight = document.querySelector('.mtk-slider--arrows__right'),
          sliderLength = sliderViewSlides.length;

// Sliding function
const slideMe = ( sliderViewItems , isActiveItem ) => {
     //update the clases
     /* Remove the active item */
     isActiveItem.classList.remove('is-active');
     /* Add the class */
     sliderViewItems.classList.add('is-active');
     //css transfrom the active slide position
     console.log (sliderViewItems);
     sliderView.setAttribute( 'style' , 'transform:translateX(-'+ sliderViewItems.offsetLeft +'px)' );
}

// before sliding function
const beforeSliding = i => {
    let isActiveItem = document.querySelector('.mtk-slider--view__slides.is-active'),
        currentItem = Array.from(sliderViewSlides).indexOf(isActiveItem) + i,
        nextItem = currentItem + i,
        sliderViewItems = document.querySelector(`.mtk-slider--view__slides:nth-child(${nextItem})`);

    // if nextItem is bigger than the # of slides
    if (nextItem > sliderLength) {
        sliderViewItems = document.querySelector('.mtk-slider--view__slides:nth-child(1)');
    }

    // if nextItem is 0
    if (nextItem == 0) {
        sliderViewItems = document.querySelector(`.mtk-slider--view__slides:nth-child(${sliderLength})`);
    }

    // trigger the sliding method
    slideMe(sliderViewItems, isActiveItem);
}

// Trigger arrows
arrowRight.addEventListener( 'click' , () => beforeSliding (1) );
arrowLeft.addEventListener( 'click' , () => beforeSliding (0) );
