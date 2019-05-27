/*
*
@package mkt-recipe-plugin

     ===================================
          MYSCRIPT.JS
     ===================================
*
*
*/
/* Import the files for code-prettify */
import 'code-prettify';
/* The function that handles the tabs */
window.addEventListener ( "load" , function ()
{
     /* Load the code prettify function */
     PR.prettyPrint();
     //Store tabs variables
     var tabs = document.querySelectorAll ("ul.nav-tabs > li");
     for (var i = 0; i < tabs.length; i++ )
     {
          tabs[i].addEventListener( "click" , switchTab );
     }

     function switchTab ( event )
     {
          //Prevent from modifying the url
          event.preventDefault();

          //Remove all active classes
          document.querySelector("ul.nav-tabs > li.active").classList.remove("active");
          document.querySelector(".tab-pane.active").classList.remove("active");

          //Assing the clicked tab to a variable
          var clickedTab = event.currentTarget;
          var anchor = event.target;
          var activePaneId = anchor.getAttribute("href");

          //Assign the active class
          clickedTab.classList.add("active");
          document.querySelector(activePaneId).classList.add("active");

     }
});
/* Access the jquery */
//only when the document is ready
jQuery(document).ready( function ($) {
     /* Event listener*/
     //when the document is clicked,
     //on an elements with this class js-image-upload
     //ejecutes the function sending the target element e
     $(document).on('click', 'js-image-upload', function (e){
          /*  Prevent the default behavior of the element */
          e.preventDefault();
          var $button = $(this);
          var file_frame = wp.media.frames.file_frame = wp.media({
               title: 'Select or Upload an Image',
               library: {
                    /* All the elements that we are going to allow the user to select */
                    type: 'image' // mime type
               },
               button: {
                    /* Customize the button text */
                    text: 'Select Image'
               },
               multiple: false
               /* Has many more options */
          });

          file_frame.on ('select', function (){
               var attachment = file_frame.state().get('slection').first().toJSON();
               $button.siblings('.image-upload').val(attachment.url);
          });

          file_frame.open();
     });
} );
