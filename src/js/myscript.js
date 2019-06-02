/*
*
@package mkt-recipe-plugin

     ===================================
          MYSCRIPT.JS
     ===================================
*
*
*/
/* Function to control the multiple tabs */
/* Import the files for code-prettify */
import 'code-prettify';
/* The function that handles the tabs */
window.addEventListener ( "load" , function ()
{
     /* Load the code prettify function */
     PR.prettyPrint();
     //   -----------------------------------------
     //        Add the event to the tab buttons
     //   -----------------------------------------
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
     //   --------------------------------------------------
     //        Add the event to the add and remove buttons
     //   --------------------------------------------------
     var index = 0;
     var addFieldsButton = new Array();
     var removeFieldsButton = new Array();

     addEventListeners ();
     function addEventListeners ()
     {
          addFieldsButton = document.querySelectorAll (".customFields_addButton");
          removeFieldsButton = document.querySelectorAll (".customFields_removeButton");
          index = addFieldsButton.length-1;
          for (var i = 0; i < addFieldsButton.length; i++ )
          {
               addFieldsButton[i].addEventListener( "click" , addField );
          }
          for (var i = 0; i < removeFieldsButton.length; i++ )
          {
               removeFieldsButton[i].addEventListener( "click" , removeField );
          }
     }

     function addField ( event )
     {
          /* next index */
          index ++;
          console.log ( index );
          /* We have to add an element like the previous*/
          var inputElement = '<div id="customFields_container_' + index + '">';
          inputElement += '<input type="text" class="regular-text customFields_input" name="mtk_plugin_cpt[customFields][][ID]" placeholder="author_name" value=""/>';
          inputElement += '<input type="text" class="regular-text customFields_input" name="mtk_plugin_cpt[customFields][][Name]" placeholder="author_name" value=""/>';
          inputElement += '<input type="text" class="regular-text customFields_input" name="mtk_plugin_cpt[customFields][][Parent]" placeholder="parent_field" value=""/>';
          inputElement += '<span class="dashicons dashicons-plus-alt add-substract-button customFields_addButton" id="add_' + index + '" ></span>';
          inputElement += '<span class="dashicons dashicons-dismiss add-substract-button customFields_removeButton" id="remove_' + index + '"></span>';
          inputElement += '</div>';
          /* Append the elements */
          $(".customFields_container").append( inputElement );
          /* Add event Listeners */
          addEventListeners ();

     }
     function removeField ( event )
     {
          console.log ( index );
          if ( index > 0 )
          {
               /* Get the parent */

               var targetId = event.target.id.replace ( 'remove_' , '' );
               $('#customFields_container_' + targetId).remove();
               console.log ('.customFields_container_' + targetId);
          }

     }
});
/* Function to add the image to the widget field */
/* Access the jquery */
//only when the document is ready
jQuery(document).ready(function ($) {
     /* Event listener*/
     //when the document is clicked,
     //on an elements with this class js-image-upload
     //ejecutes the function sending the target element e
     $(document).on('click', '.js-image-upload', function (e) {
          /*  Prevent the default behavior of the element */
          e.preventDefault();
          var $button = $(this);
          var file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Select or Upload an Image',
			library: {
				type: 'image' // mime type
			},
			button: {
				text: 'Select Image'
			},
			multiple: false
          });
          file_frame.on('select', function()
          {
			var attachment = file_frame.state().get('selection').first().toJSON();
               console.log((attachment.url));
			$button.siblings('.image-upload').val(attachment.url);
			var attachment = file_frame.state().get('selection').first().toJSON();
			$button.siblings('.image-upload').val(attachment.url);
               /*  Enable the Widget save button */
               $('.widget-control-save' ,'.widget-control-actions' ).val('Save');
               $('.widget-control-save' , '.widget-control-actions').attr("disabled", false);
               console.log ('here');
          });

          file_frame.open();
     });
} );
