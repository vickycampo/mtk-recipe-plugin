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
     var index;
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
     function fixSpan ()
     {
          var customFields_input = document.querySelectorAll('.customFields_input');
          for (var i = 0; i < customFields_input.length; i++ )
          {

               inputId =  "#" + customFields_input[i].id;
               if ($(inputId)[0].tagName == 'SPAN')
               {
                    console.log ('fixSpan - ' + i);
                    $(inputId).css("display","inline-block");
                    $(inputId).css("text-align","center");
                    $(inputId).width( '75px' );
               }
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
          FieldsLIst['Show_in_columns']['placeholder'] = true;
          FieldsLIst['Show_in_columns']['type'] = 'checkbox';

          FieldsLIst['add_remove_buttons'] = new Array ();
          FieldsLIst['add_remove_buttons']['placeholder'] = true;
          FieldsLIst['add_remove_buttons']['type'] = 'checkbox';

          FieldsLIst['add'] = new Array ();
          FieldsLIst['add']['class'] = 'dashicons dashicons-plus-alt add-substract-button customFields_addButton';
          FieldsLIst['add']['type'] = 'button';

          FieldsLIst['remove'] = new Array ();
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
     fixSpan ();
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

          index = customFields_ID_input.length-1;
          for (var i = 0; i < addFieldsButton.length; i++ )
          {
               /* add the event Listener to the add/remove button */
               addFieldsButton[i].addEventListener( "click" , addField );
               removeFieldsButton[i].addEventListener( "click" , removeField );

               /* Get the number of the list index */
               index = removeFieldsButton[i].id.replace ( 'remove_' , '' );
               //console.log ('index - ' + index);
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
          var target = document.querySelector(".customFields_container");
          var containerDiv = CreateDiv (id , className, target);


          for (var i in Fields)
          {
               if ( Fields[i]['type'] != 'button' )
               {
                    var id = i + '_' + index;
                    var className = 'regular-text customFields_input customFields_' + i + '_input';
                    var name = 'mtk_plugin_cpt[customFields][' + index + '][' + i + ']';
                    var placeholder = Fields[i]['placeholder'];

                    if (Fields[i]['type'] == 'text')
                    {
                         CreateInputTextType (id, name, className, placeholder, containerDiv);
                    }
                    else if (Fields[i]['type'] == 'select')
                    {
                         var className = 'regular-text customFields_input customFields_' + i + '_select';
                         if ( i === 'Type')
                         {
                              var optionsValues = optionsArray;
                         }
                         else if ( i === 'Parent')
                         {
                              var optionsValues = new Array;
                         }
                         CreateInputSelectType (id, name , className , optionsValues, containerDiv);
                    }
                    else if (Fields[i]['type'] == 'checkbox')
                    {

                         CreateInputCheckBoxType (id, name , className, placeholder, containerDiv);
                    }
               }
               else
               {

                    var id = i + '_' + index;
                    var className = Fields[i]['class'];
                    CrateInputButtonType (id, className, containerDiv);
               }

          }
          /* Add event Listeners */
          addEventListeners ();
          updateParentSelector();
          return;




     }
     //   --------------------------------------------------
     //        CREATE INPUT FIELDS
     //   --------------------------------------------------

     function CreateDiv (id , className, target)
     {
          var d = document.createElement('div');
          d.id = id;
          d.classList.add(className);
          target.append( d );
          return (d);


     }
     function CreateInputTextType (id, name , className, placeholder, target)
     {
          var i = document.createElement('input');
          i.type='text';
          i.id = id;
          i.name = name;
          i.placeholder = placeholder;

          /* To add the class we need to separete in spaces and then add one by one */
          if (className.indexOf (" ") < 0)
          {
               i.classList.add(className);
          }
          else
          {
               classList = className.split(" ");
               for (var j in classList)
               {
                    i.classList.add(classList[j]);
               }
          }
          targetId = "#" + target.id;
          $(targetId).append( i );
     }
     function CreateInputSelectType (id, name , className, optionsValues, target)
     {
          var selectList = document.createElement("select");
          selectList.id = id;
          selectList.name = name;
          target.appendChild(selectList);

          /* To add the class we need to separete in spaces and then add one by one */
          if (className.indexOf (" ") < 0)
          {
               selectList.classList.add(className);
          }
          else
          {
               classList = className.split(" ");
               for (var j in classList)
               {

                    selectList.classList.add(classList[j]);
               }
          }
          targetId = "#" + target.id;
          $(targetId).append( selectList );

          /* Create and append the options */
          if ( Array.isArray(optionsValues) )
          {
               for (var i = 0; i < optionsValues.length; i++)
               {
                    var option = document.createElement("option");
                    option.value = optionsValues[i];
                    option.text = optionsValues[i];
                    selectList.appendChild(option);
               }
          }


     }
     function CreateInputCheckBoxType (id, name , className, placeholder, target)
     {
          //console.log (target);
          /* For the check box we need to create a span element */
          var span = document.createElement('span');
          span.id = id;

          /* To add the class we need to separete in spaces and then add one by one */
          if (className.indexOf (" ") < 0)
          {
               span.classList.add(className);
          }
          else
          {
               classList = className.split(" ");
               for (var j in classList)
               {
                    span.classList.add(classList[j]);
               }
          }
          /* add the styles to the span */
          spanID = "#" + span.id;
          //console.log (spanID);
          /* add the check box */
          targetId = "#" + target.id;
          $(targetId).append( span );

          $(spanID).css("display","inline-block");
          $(spanID).css("text-align","center");
          $(spanID).width( '75px' );

          /* Now we create the check box */
          var xbox = document.createElement('input');
          xbox.type='checkbox';
          xbox.name = name;
          xbox.value = placeholder;

          spanID = "#" + span.id;
          $(spanID).append( xbox );


     }
     function CrateInputButtonType (id, className, target)
     {
          //console.log (target);
          /* For the check box we need to create a span element */
          var span = document.createElement('span');
          span.id = id;
          /* To add the class we need to separete in spaces and then add one by one */
          if (className.indexOf (" ") < 0)
          {
               span.classList.add(className);
          }
          else
          {
               classList = className.split(" ");
               for (var j in classList)
               {
                    span.classList.add(classList[j]);
               }
          }
          /* add the check box */
          targetId = "#" + target.id;
          $(targetId).append( span );
     }
     //   --------------------------------------------------
     //        REMOVES SET OF FIELDS
     //   --------------------------------------------------
     function removeField ( event )
     {
          var customFields_div = document.querySelectorAll('.customFields_div');
          // console.log (customFields_div.length);
          if ( customFields_div.length > 1 )
          {
               /* Get the parent */

               var targetId = event.target.id.replace ( 'remove_' , '' );
               // console.log (index + ' - ' + targetId);
               $('#customFields_container_' + targetId).remove();

          }
     }
     //   --------------------------------------------------
     //        UPDATES THE PARENT SELECT BASED ON NEW VALUES
     //   --------------------------------------------------
     function updateParentSelector ( e )
     {
          var customFields_ID_input = document.querySelectorAll (".customFields_ID_input");
          var customFields_Name_input = document.querySelectorAll (".customFields_Name_input");
          var customFields_Type_select = document.querySelectorAll (".customFields_Type_select");

          var optionsArray = new Array;
          var optionText = '<option value="">Choose Parent</option>';
          /* Get the combination that is needed for the select into an array */
          //console.log (customFields_Type_select);
          for (var i = 0; i < customFields_ID_input.length; i++ )
          {

               if ( (customFields_Type_select[i].value === 'Section') || (customFields_Type_select[i].value === 'SubSection') || (customFields_Type_select[i].value === 'Item') )
               {
                    optionText += '<option value="' + customFields_ID_input[i].value + '">' + customFields_Name_input[i].value + '</option>';
               }

          }
          /* update the customFields_Parent_select*/
          var customFields_Parent_select = document.querySelectorAll (".customFields_Parent_select");
          for (var i = 0; i < customFields_Parent_select.length; i++ )
          {
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
