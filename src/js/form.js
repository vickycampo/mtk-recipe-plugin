document.addEventListener('DOMContentLoaded' , function (e)
     {
          /* We need to prevent the form submit */
          let testimonialForm = document.getElementById('mtk-testimonial-form');
          /* (e) => is the equivalent of writing function (e) */
          testimonialForm.addEventListener( 'submit' , (e) => {
               e.preventDefault();

               //Reset the form Messeges
               resetMessages ();

               //collect all the data
               /* let is another way of definining a variable */
               let data = {
                    /* We use the [] to specify an attribute */
                    name: testimonialForm.querySelector('[name="name"]').value,
                    email: testimonialForm.querySelector('[name="email"]').value,
                    message: testimonialForm.querySelector('[name="message"]').value,
                    nonce: testimonialForm.querySelector('[name="nonce"]').value
               };

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
               /* We are going to use the fetch method of VanillaJS so we need to prepare the parameters.*/
               let params = new URLSearchParams ( new FormData( testimonialForm ) );
               /* We display something to show the user the form is being processed */
               testimonialForm.querySelector('.js-form-submission').classList.add('show');
               fetch ( url , {
                    method: "POST",
                    body: params,
               } )  .then( res => res.json() )
                    .catch( error => {
                         resetMessages();
                         testimonialForm.querySelector('.js-form-error').classList.add('show');
                    } )
                    .then ( response => {
                         resetMessages();
                         // console.log (response);
                         /* Deal with the response */
                         if ( response === 0  || response.status === 'error')
                         {
                              testimonialForm.querySelector('.js-form-error').classList.add('show');
                              return;
                         }
                         testimonialForm.querySelector('.js-form-success').classList.add('show');
				     testimonialForm.reset();
                    })

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
