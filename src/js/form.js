document.addEventListener('DOMContentLoaded' , function (e)
     {
          /* We need to prevent the form submit */
          let testimonialForm = document.getElementById('mtk-testimonial-form');
          testimonialForm.addEventListener( 'submit' , (e) => {
               e.preventDefault();
               console.log( 'Prevent form to submit' );
               //Reset the form Messeges
               //Validate Email address
               //collect all the data
               //ajax http post request
          } );
     }
);
