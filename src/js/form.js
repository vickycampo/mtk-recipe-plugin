document.addEventListener('DOMContentLoaded' , function (e)
     {
          /* We need to prevent the form submit */
          let testimonialForm = document.getElementById('mtk-testimonial-form');
          /* (e) => is the equivalent of writing function (e) */
          testimonialForm.addEventListener( 'submit' , (e) => {
               e.preventDefault();
               console.log( 'Prevent form to submit' );

               //Reset the form Messeges
               resetMessages ();

               //collect all the data
               /* let is another way of definining a variable */
               let data = {
                    /* We use the [] to specify an attribute */
                    name: testimonialForm.querySelector('[name="name"]').value,
                    email: testimonialForm.querySelector('[name="email"]').value,
                    message: testimonialForm.querySelector('[name="message"]').value
               };
               console.log(data);

               //Validate Data
               if ( ! (data.name) )
               {
                    testimonialForm.querySelector('[data-error="invalidName"]').classList.add('show');
                    return;
               }
               if ( ! (data.email) )
               {
                    testimonialForm.querySelector('[data-error="invalidEmail"]').classList.add('show');
                    return;
               }
               if (! validateEmail(data.email))
               {
                    testimonialForm.querySelector('[data-error="invalidEmail"]').classList.add('show');
                    return;
               }
               if ( ! (data.message) )
               {
                    testimonialForm.querySelector('[data-error="invalidMessage"]').classList.add('show');
                    return;
               }

               //ajax http post request
               let url = testimonialForm.dataset.url;
               console.log  (url)
          } );
     }
);
function resetMessages ()
{
     /* Remove the active class from the field messages */
     /* f Stands for field */
     document.querySelectorAll('.field-msg').forEach( f =>  f.classList.remove('show') );
}
function validateEmail(email)
{
    let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}
