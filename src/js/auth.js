document.addEventListener ( 'DOMContentLoaded' , function (e) {
     const     showAuthBtn = document.getElementById('mtk-show-auth-form'),
               authContainer = document.getElementById('mtk-auth-container'),
               close = document.getElementById('mtk-auth-close');
               
     showAuthBtn.addEventListener( 'click' , () => {
          authContainer.classList.add('show');
          showAuthBtn.parentElement.classList.add('hide');
     } );

     close.addEventListener( 'click' , () => {
          authContainer.classList.remove('show');
          showAuthBtn.parentElement.classList.remove('hide');
     } );
} )
