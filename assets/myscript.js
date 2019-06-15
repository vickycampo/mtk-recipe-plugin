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

//   --------------------------------------------------
//        MANAGES THE TABS
//   --------------------------------------------------
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
//   --------------------------------------------------
//        MANAGE THE CUSTOM POST TYPE FIELDS
//   --------------------------------------------------
$('.customFields_container').ready(function()
{
     var optionsArray = new Array;
     /* We create an array with all the values from a previous field */
     optionsArray = createInputArray();
     Fields = createFieldList ();
     //   --------------------------------------------------
     //        FIX THE TITLES WITH BASED ON THE FIELDS WIDTH
     //   --------------------------------------------------
     var customFields_titles = document.querySelectorAll('.customFields_title');
     /* the div that contains the first row of fields */
     var customFields_input = document.querySelectorAll('.customFields_input');

     for (var i = 0; i < customFields_titles.length; i++ )
     {
          inputId =  "#" + customFields_input[i].id;
          spanId = "#" + customFields_titles[i].id;
          if ($(inputId)[0].tagName != 'SPAN')
          {
               $(spanId).css("display","inline-block");
               $(spanId).css("text-align","center");
               $(spanId).css("word-wrap","break-word");
               $(spanId).width( $(inputId).outerWidth() + 'px' );
          }
          else
          {
               $(inputId).css("display","inline-block");
               $(inputId).css("text-align","center");
               $(inputId).width( '75px' );

               $(spanId).css("display","inline-block");
               $(spanId).css("text-align","center");
               $(spanId).css("word-wrap","break-word");
               $(spanId).width( $(inputId).outerWidth() + 'px' );
          }
     }
     /*Fix the span widths */
     for (var i = 0; i < customFields_input.length; i++ )
     {

          inputId =  "#" + customFields_input[i].id;
          if ($(inputId)[0].tagName == 'SPAN')
          {
               $(inputId).css("display","inline-block");
               $(inputId).css("text-align","center");
               $(inputId).width( '75px' );
          }
     }
     //   --------------------------------------------------
     //        CREATES THE LIST OF THE FIELDS WE ARE GOING TO ADD
     //   --------------------------------------------------
     function createFieldList ()
     {
          var FieldsLIst = new Array ();
          FieldsLIst['ID'] = new Array ();
          FieldsLIst['ID']['placeholder'] = 'author_name';
          FieldsLIst['ID']['type'] = 'text';

          FieldsLIst['Name'] = new Array ();
          FieldsLIst['Name']['placeholder'] = 'Author Name';
          FieldsLIst['Name']['type'] = 'text';

          FieldsLIst['Type'] = new Array ();
          FieldsLIst['Type']['placeholder'] = '';
          FieldsLIst['Type']['type'] = 'select';

          FieldsLIst['Parent'] = new Array ();
          FieldsLIst['Parent']['placeholder'] = 'parent_field';
          FieldsLIst['Parent']['type'] = 'select';

          FieldsLIst['Show_in_columns'] = new Array ();
          FieldsLIst['Show_in_columns']['placeholder'] = false;
          FieldsLIst['Show_in_columns']['type'] = 'checkbox';

          FieldsLIst['add_remove_buttons'] = new Array ();
          FieldsLIst['add_remove_buttons']['placeholder'] = false;
          FieldsLIst['add_remove_buttons']['type'] = 'checkbox';

          FieldsLIst['add'] = new Array ();
          FieldsLIst['add']['class'] = 'dashicons dashicons-plus-alt add-substract-button customFields_addButton';
          FieldsLIst['add']['type'] = 'button';

          FieldsLIst['remove'] = new Array ();
          FieldsLIst['remove']['placeholder'] = false;
          FieldsLIst['remove']['class'] = 'dashicons dashicons-dismiss add-substract-button customFields_removeButton';
          FieldsLIst['remove']['type'] = 'button';




          return (FieldsLIst);
     }

     //   --------------------------------------------------
     //        CREATES THE LIST FOR THE TYPE SELECT
     //   --------------------------------------------------
     function createInputArray()
     {
          /* we look for a previous created select */
          if ( document.querySelector('.customFields_Type_select') )
          {
               var options = document.querySelector('.customFields_Type_select').options;
               if ( options )
               {
                    /* Convert to an array  */
                    var inputArrayValues = new Array;
                    var j=0;
                    for ( var i in options)
                    {
                         if ( ( options[i].value ) && ( options[i].value != '') )
                         {
                              //console.log (options[i]);
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

     }

     addEventListeners ();
     //   --------------------------------------------------
     //        ADDS ALL THE EVENT LISTENERS TO ALL THE FIELDS
     //   --------------------------------------------------
     function addEventListeners ()
     {
          /* get the add/remove buttons  */
          var addFieldsButton = document.querySelectorAll (".customFields_addButton");
          var removeFieldsButton = document.querySelectorAll (".customFields_removeButton");

          /* get the other fields */
          var customFields_ID_input = document.querySelectorAll (".customFields_ID_input");
          var customFields_Name_input = document.querySelectorAll (".customFields_Name_input");
          var customFields_Type_select = document.querySelectorAll (".customFields_Type_select");

          /* The last Index */
          index = addFieldsButton.length-1;


          for (var i = 0; i < addFieldsButton.length; i++ )
          {
               /* add the event Listener to the add/remove button */
               addFieldsButton[i].addEventListener( "click" , addField );
               removeFieldsButton[i].addEventListener( "click" , removeField );

               /* add the event to the other fields */
               customFields_ID_input[i].addEventListener( "change" , updateParentSelector );
               customFields_Name_input[i].addEventListener( "change" , updateParentSelector );
               customFields_Type_select[i].addEventListener( "change" , updateParentSelector );
          }
     }
     //   --------------------------------------------------
     //        ADDS A NEW SET OF FIELDS
     //   --------------------------------------------------
     function addField ( event )
     {
          /* next index */
          index ++;
          /* create the div*/
          var id = 'customFields_container_' + index;
          var className = 'customFields_div';
          var containerDiv = CreateDiv (id , className);


          for (var i in Fields)
          {

               if ( Fields['type'] != 'button' )
               {
                    var id = i + '_' + index;
                    var className = 'regular-text customFields_input customFields_' + i + '_input';
                    var name = 'mtk_plugin_cpt[customFields][' + index + '][' + i + ']';
                    var placeholder = Fields[i]['placeholder'];

                    if (Fields['type'] == 'text')
                    {
                         Fields['input-field'] = CreateInputTextType (id, name, className, placeholder);
                    }
                    else if (Fields['type'] == 'select')
                    {
                         if ( i === 'Type')
                         {
                              var optionsValues = optionsArray;
                         }
                         else if ( i === 'Parent')
                         {
                              var optionsValues = new Array;
                         }
                         Fields['input-field'] = CreateInputTextType (id, name , className, placeholder , optionsValues );
                    }
                    else if (Fields['type'] == 'checkbox')
                    {
                         Fields['input-field'] = CreateInputTextType (id, name , className, placeholder);
                    }
               }
               else
               {

                    var id = i + '_' + index;
                    var className = Fields[i]['class'];
               }

          }






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

          /* Column show checkbox */
          inputElement += '<input type="checkbox" id="Show_in_columns_' + index + '" class="regular-text customFields_input customFields_Show_in_columns_select" name="mtk_plugin_cpt[customFields][' + index + '][Show_in_columns]" value="true">';

          /* add the add and remove buttons */
          inputElement += '<span class="dashicons dashicons-plus-alt add-substract-button customFields_addButton" id="add_' + index + '" ></span>';
          inputElement += '<span class="dashicons dashicons-dismiss add-substract-button customFields_removeButton" id="remove_' + index + '"></span>';
          inputElement += '</div>';
          /* Append the elements */
          $(".customFields_container").append( inputElement );

          /* Add event Listeners */
          addEventListeners ();
          updateParentSelector();


     }
     //   --------------------------------------------------
     //        CREATE INPUT FIELDS
     //   --------------------------------------------------

     function CreateDiv (id , className)
     {
          console.log ('297 - creating a div');
     }
     function CreateInputTextType (id, name , className, placeholder)
     {
          console.log ('357 - CreateInputTextType');
     }
     function CreateInputSelectType (id, name , className, placeholder , optionsValues )
     {
          console.log ('361 - CreateInputSelectType');
     }
     function CreateInputCheckBoxType (id, name , className, placeholder)
     {
          console.log ('365 - CreateInputCheckBoxType');
     }
     //   --------------------------------------------------
     //        REMOVES SET OF FIELDS
     //   --------------------------------------------------
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
     //   --------------------------------------------------
     //        UPDATES THE PARENT SELECT BASED ON NEW VALUES
     //   --------------------------------------------------
     function updateParentSelector ( e )
     {
          //console.log ( e );
          var customFields_ID_input = document.querySelectorAll (".customFields_ID_input");
          var customFields_Name_input = document.querySelectorAll (".customFields_Name_input");
          var customFields_Type_select = document.querySelectorAll (".customFields_Type_select");

          var optionsArray = new Array;
          var optionText = '<option value="">Choose Parent</option>';
          /* Get the combination that is needed for the select into an array */
          for (var i = 0; i < customFields_ID_input.length; i++ )
          {
               //console.log (customFields_Type_select[i].value);
               if ( (customFields_Type_select[i].value === 'Section') || (customFields_Type_select[i].value === 'SubSection') || (customFields_Type_select[i].value === 'Item') )
               {
                    optionText += '<option value="' + customFields_ID_input[i].value + '">' + customFields_Name_input[i].value + '</option>';
               }

          }
          /* update the customFields_Parent_select*/
          var customFields_Parent_select = document.querySelectorAll (".customFields_Parent_select");
          for (var i = 0; i < customFields_Parent_select.length; i++ )
          {
               //console.log (customFields_Parent_select[i].value);
               var previousValue = customFields_Parent_select[i].value;
               var select_id = '#' + customFields_Parent_select[i].id;

               $(select_id)
                   .empty()
                   .append(optionText);

               $(select_id).val(previousValue);


          }



     }
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
