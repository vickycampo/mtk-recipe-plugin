
/* IIFE function */
jQuery(function ($)
{
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
          var formValues = new Array;
          event.preventDefault();
          /* Check that all the fields are filled */
          var kids = event.target.getElementsByTagName('input');

          console.log (kids.length);
          for ( var i = 0; i < kids.length ; i++ )
          {
               console.log (kids[i].id);
               if (kids[i].value == '')
               {
                    if ( kids[i].name == 'author')
                    {
                         errorMessage ( kids[i] , kids[i].name );

                    }
                    else if ( kids[i].name == 'email')
                    {
                         errorMessage ( kids[i] , kids[i].name );

                    }
                    else if ( kids[i].name == 'phone')
                    {
                         errorMessage ( kids[i] , kids[i].name );

                    }
                    else if ( kids[i].name == 'rating')
                    {
                         errorMessage ( kids[i] , kids[i].name );

                    }
               }
               else
               {
                    ajaxSubmitForm ( event );
               }



          }
          /* now for the text area */
          kids = (event.target.getElementsByTagName('textarea'));
          for ( var i = 0; i < kids.length ; i++ )
          {
               console.log (kids[i].name);
               if (kids[i].value == '')
               {
                    errorMessage ( kids[i] , kids[i].name );

               }
          }
          /* if we reach this point means no errors were found */
          /* ajax submit */
          ajaxSubmitForm ( e );

     });
     function ajaxSubmitForm ( e )
     {
          console.log ('Create the ajax submit form ');
     }
     function errorMessage ( e , fieldName )
     {
          console.log (fieldName);
          return (false);
     }
});
