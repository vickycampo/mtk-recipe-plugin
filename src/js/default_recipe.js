
/* IIFE function */
jQuery(function ($)
{
     /* Hide messages */
     /*
     Add the event to the star...
     when clicked the field value is updated
     and the stars are swaped to marked
     */
     $(".input_rating").click(function( e )
     {
          var rating = e.target.id.replace("input_rating_", "");
          $("#rating").val(rating);
          for (var i=1; i<6; i++)
          {
               console.log ("#input_rating_" + i + ' - ' + rating);
               if (i <= rating)
               {
                    $( "#input_rating_" + i ).addClass( "active-star" );
                    $( "#input_rating_" + i ).removeClass( "inactive-star" );
               }
               else
               {
                    $( "#input_rating_" + i ).addClass( "inactive-star" );
                    $( "#input_rating_" + i ).removeClass( "active-star" );
               }
          }

     });
     $("#commentform").submit(function( event )
     {
          var errorfound = false;

          event.preventDefault();
          /* Check that all the fields are filled */
          var kids = event.target.getElementsByTagName('input');
          for ( var i = 0; i < kids.length ; i++ )
          {
               //console.log (kids[i].id + ' - ' + kids[i].value);
               /* Check that is not empty */
               if (kids[i].value == '')
               {
                    if ( (kids[i].name == 'author') || (kids[i].name == 'email') || (kids[i].name == 'comment') || (kids[i].name == 'rating') )
                    {
                         errorfound = errorMessage ( kids[i] , kids[i].name );
                    }
               }
               /* Check that valid */
               else if ( kids[i].name == 'email' )
               {

                    if ( ! ( isEmail(kids[i].value) ) )
                    {
                         errorfound = errorMessage ( kids[i] , kids[i].name );
                    }

               }
               else if ( kids[i].name == 'rating' )
               {
                    if ((kids[i].value != 1) && (kids[i].value != 2) && (kids[i].value != 3) && (kids[i].value != 4) && (kids[i].value != 5))
                    {
                         errorfound = errorMessage ( kids[i] , kids[i].name );
                    }
               }
               else if ( kids[i].name == 'phone' )
               {

                    if ( ! ( phone_validate(kids[i].value) ) )
                    {
                         errorfound = errorMessage ( kids[i] , kids[i].name );
                    }
               }
               else if ( kids[i].name == 'url' )
               {
                    if ( ! (/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test( kids[i].value )) )
                    {
                         errorfound = errorMessage ( kids[i] , kids[i].name );
                    }
               }

          }
          /* now for the text area */
          kids = (event.target.getElementsByTagName('textarea'));
          for ( var i = 0; i < kids.length ; i++ )
          {
               if (kids[i].value == '')
               {
                    errorfound = errorMessage ( kids[i] , kids[i].name );
               }
          }
          /* if we reach this point means no errors were found */
          /* ajax submit */
          if ( errorfound )
          {
               return ( ! errorfound);
          }
          else
          {
               ajaxSubmitForm ( event );
          }


     });
     function isEmail(email)
     {
          var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
          return regex.test(email);
     }
     function phone_validate(phno)
     {
          var regexPattern=new RegExp(/^[0-9-+]+$/);    // regular expression pattern
          return regexPattern.test(phno);
     }
     function ajaxSubmitForm ( event )
     {
          var commentForm = event.target;
          resetMessages(commentForm);
          //ajax http post request
          let url = document.getElementById('data-url').value;

          /* We are going to use the fetch method of VanillaJS so we need to prepare the parameters.*/
          let params = new URLSearchParams ( new FormData( commentForm ) );
          /* We display something to show the user the form is being processed */
          commentForm.querySelector('.js-form-submission').classList.add('show');
          fetch ( url , {
               method: "POST",
               body: params,
          } )  .then( res => res.json() )
               .catch( error => {
                    resetMessages(commentForm);
                    commentForm.querySelector('.js-form-submission').classList.add('show');
               } )
               .then ( response => {
                    resetMessages(commentForm);
                    console.log (response);
                    /* Deal with the response */
                    if ( response === 0  || response.status === 'error')
                    {
                         alert (response.message);
                         commentForm.querySelector('.js-form-error').classList.add('show');
                         return;
                    }
                    commentForm.querySelector('.js-form-success').classList.add('show');
                    commentForm.reset();
                    resetStars ();
               })

     }
     function errorMessage ( e , fieldName )
     {
          console.log ('errorMessage - ' + fieldName);
          return ( true );
     }
     function resetStars ()
     {
          for (var i=1; i<6; i++)
          {
               $( "#input_rating_" + i ).addClass( "inactive-star" );
               $( "#input_rating_" + i ).removeClass( "active-star" );
          }
     }
     function resetMessages (commentForm)
     {
          commentForm.querySelector('.js-form-submission').classList.remove('show');
          commentForm.querySelector('.js-form-error').classList.remove('show');
          commentForm.querySelector('.js-form-success').classList.remove('show');
     }
});
