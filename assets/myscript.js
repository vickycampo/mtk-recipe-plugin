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
console.log ('uncomment 13');
//import 'code-prettify';
/* The function that handles the tabs */
window.addEventListener ( "load" , function ()
{
     /* Load the code prettify function */
     console.log ('uncomment 19');
     //PR.prettyPrint();

     //   -----------------------------------------
     //        Add the event to the tab buttons
     //   -----------------------------------------
     //Store tabs variables
     var tabs = document.querySelectorAll ("ul.nav-tabs > li");
     var optionsArray = new Array;
     /* We create an array with all the values from a previous field */
     optionsArray = createInputArray();

     function createInputArray()
     {
          /* we look for a previous created select */
          var options = document.querySelector('.customFields_Type_select').options;
          if ( options )
          {
               /* Convert to an array  */
               var inputArrayValues = new Array;
               var j=0;
               for ( var i in options)
               {
                    if ( options[i].value != '')
                    {
                         inputArrayValues[j] = options[i].value;
                         j++;
                    }


               }

               return (inputArrayValues);
          }
          else
          {
               /* if we can't find one we use the default values */
               /* add the select */
               /* We create an array with all the select values */
               /* We get the values from a predefined select */

               var inputArrayValues = new Array;
               var i = 0;

               inputArrayValues[i] = 'button';
               i++;
               inputArrayValues[i] = 'checkbox';
               i++;
               inputArrayValues[i] = 'button';
               i++;
               inputArrayValues[i] = 'checkbox';
               i++;
               inputArrayValues[i] = 'color';
               i++;
               inputArrayValues[i] = 'date';
               i++;
               inputArrayValues[i] = 'datetime-local';
               i++;
               inputArrayValues[i] = 'email';
               i++;
               inputArrayValues[i] = 'file';
               i++;
               inputArrayValues[i] = 'hidden';
               i++;
               inputArrayValues[i] = 'image';
               i++;
               inputArrayValues[i] = 'month';
               i++;
               inputArrayValues[i] = 'number';
               i++;
               inputArrayValues[i] = 'password';
               i++;
               inputArrayValues[i] = 'radio';
               i++;
               inputArrayValues[i] = 'range';
               i++;
               inputArrayValues[i] = 'reset';
               i++;
               inputArrayValues[i] = 'search';
               i++;
               inputArrayValues[i] = 'submit';
               i++;
               inputArrayValues[i] = 'tel';
               i++;
               inputArrayValues[i] = 'text';
               i++;
               inputArrayValues[i] = 'time';
               i++;
               inputArrayValues[i] = 'url';
               i++;
               inputArrayValues[i] = 'week';
               i++;
               return (inputArrayValues);
          }



     }
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
     //        MANAGE THE CUSTOM FIELDS PART
     //   --------------------------------------------------
     var index = 0;
     var addFieldsButton = new Array();
     var removeFieldsButton = new Array();

     addEventListeners ();
     function addEventListeners ()
     {
          /* add event listener to the add and remove buttons */
          var addFieldsButton = document.querySelectorAll (".customFields_addButton");
          var removeFieldsButton = document.querySelectorAll (".customFields_removeButton");
          var customFields_ID_input = document.querySelectorAll (".customFields_ID_input");
          var customFields_Name_input = document.querySelectorAll (".customFields_Name_input");
          var customFields_Type_select = document.querySelectorAll (".customFields_Type_select");

          index = addFieldsButton.length-1;
          for (var i = 0; i < addFieldsButton.length; i++ )
          {
               addFieldsButton[i].addEventListener( "click" , addField );
          }
          for (var i = 0; i < removeFieldsButton.length; i++ )
          {
               removeFieldsButton[i].addEventListener( "click" , removeField );
          }
          for (var i = 0; i < customFields_ID_input.length; i++ )
          {
               customFields_ID_input[i].addEventListener( "change" , updateParentSelector );
               customFields_Name_input[i].addEventListener( "change" , updateParentSelector );
               customFields_Type_select[i].addEventListener( "change" , updateParentSelector );
          }


     }

     function addField ( event )
     {
          /* next index */
          index ++;
          /* We have to add an element like the previous*/
          var inputElement = '<div class="customFields_div" id="customFields_container_' + index + '">';
          inputElement += '<input type="text" class="regular-text customFields_input customFields_ID_input" name="mtk_plugin_cpt[customFields][' + index + '][ID]" placeholder="author_name" value="">';
          inputElement += '<input type="text" class="regular-text customFields_input customFields_Name_input" name="mtk_plugin_cpt[customFields][' + index + '][Name]" placeholder="author_name" value="">';


          /* Create the select */
          inputElement += '<select class="regular-text customFields_input customFields_Type_select" name="mtk_plugin_cpt[customFields][' + index + '][Type]">';
          inputElement += '<option value="">Input Type</option>';
          /* Add the options in the array */
          if ( Array.isArray(optionsArray) )
          {
               for (var i = 0; i < optionsArray.length; i++ )
               {
                    inputElement += '<option value="' + optionsArray[i] + '" >' + optionsArray[i]  + '</option>';
               }

          }

          inputElement += '</select>';


          /* add the parent selec  */
          inputElement += '<select id="Parent_' + index + '" class="regular-text customFields_input customFields_Parent_select" name="mtk_plugin_cpt[customFields][' + index + '][Parent]" >';
          inputElement += '<option value="">Choose Parent</option>';
          inputElement += '</select>';
          /* add the add and remove buttons */
          inputElement += '<span class="dashicons dashicons-plus-alt add-substract-button customFields_addButton" id="add_' + index + '" ></span>';
          inputElement += '<span class="dashicons dashicons-dismiss add-substract-button customFields_removeButton" id="remove_' + index + '"></span>';
          inputElement += '</div>';
          /* Append the elements */
          $(".customFields_container").append( inputElement );

          /* Adda elements to the select object */
          if ( ! Array.isArray(optionsArray) )
          {
               console.log ('[name="mtk_plugin_cpt[customFields][' + index + '][Type]"]');
               var target = document.querySelector('[name="mtk_plugin_cpt[customFields][' + index + '][Type]"]');
               console.log (target);
               target.append(optionsArray);
          }
          /* Add event Listeners */
          addEventListeners ();
          updateParentSelector();


     }
     function removeField ( event )
     {
          if ( index > 0 )
          {
               /* Get the parent */

               var targetId = event.target.id.replace ( 'remove_' , '' );
               $('#customFields_container_' + targetId).remove();
               addEventListeners ();
          }
     }
     function updateParentSelector ( e )
     {
          console.log ( e );
          var customFields_ID_input = document.querySelectorAll (".customFields_ID_input");
          var customFields_Name_input = document.querySelectorAll (".customFields_Name_input");
          var customFields_Type_select = document.querySelectorAll (".customFields_Type_select");

          var optionsArray = new Array;
          var optionText = '<option value="">Choose Parent</option>';
          /* Get the combination that is needed for the select into an array */
          for (var i = 0; i < customFields_ID_input.length; i++ )
          {
               console.log (customFields_Type_select[i].value);
               if ( (customFields_Type_select[i].value === 'Section') || (customFields_Type_select[i].value === 'SubSection') )
               {
                    optionText += '<option value="' + customFields_ID_input[i].value + '">' + customFields_Name_input[i].value + '</option>';
               }

          }
          /* update the customFields_Parent_select*/
          var customFields_Parent_select = document.querySelectorAll (".customFields_Parent_select");
          for (var i = 0; i < customFields_Parent_select.length; i++ )
          {
               var select_id = '#' + customFields_Parent_select[i].id;
               $(select_id)
                   .empty()
                   .append(optionText);


          }



     }
     //   --------------------------------------------------
     //        SANITIZE THE CPT SETTING FORM
     //   --------------------------------------------------

});
//   --------------------------------------------------
//        IMAGE FIELD OF THE WIDGET
//   --------------------------------------------------
/* Function to add the image to the widget field */
/* Access the jquery */
//only when the document is ready
jQuery(document).ready(function ($)
{
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
			$button.siblings('.image-upload').val(attachment.url);
			var attachment = file_frame.state().get('selection').first().toJSON();
			$button.siblings('.image-upload').val(attachment.url);
               /*  Enable the Widget save button */
               $('.widget-control-save' ,'.widget-control-actions' ).val('Save');
               $('.widget-control-save' , '.widget-control-actions').attr("disabled", false);
          });

          file_frame.open();
     });
} );
