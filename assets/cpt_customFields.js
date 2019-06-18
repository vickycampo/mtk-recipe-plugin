window.addEventListener ( "load" , function ()
{
     /*1. we are going to get all the add and remove buttons from the sections and move them to the location we want */
     moveAddRemoveButtons ();
     /*2. We are going to add eventst to this buttons - Add and remove */
     /*3. Create the add function - Gets the parent div and multiplies it updating the id's */
     /*4. Create the remove function - updating id's */


});
/* ------------ Move Buttons ------------ */
function moveAddRemoveButtons ()
{
     var addButton = document.querySelectorAll('.addButton');
     for ( var i in addButton )
     {

          if (addButton[i].id != undefined)
          {
               var ButtonId = '#' + addButton[i].id;
               if ( ButtonId.split('[').length == 3 )
               {
                    var NewParentId = "#" + ButtonId.substring( ButtonId.indexOf('[')+1 , ButtonId.indexOf(']') );

               }
               else
               {

               }
          }

     }
}
function getAllClasses ()
{
     var allClasses = [];
     var postbox = document.querySelector("#postbox-container-2");
     var allElements = postbox.querySelectorAll('*');

     for (var i = 0; i < allElements.length; i++) {
       var classes = allElements[i].className.toString().split(/\s+/);
       for (var j = 0; j < classes.length; j++) {
         var cls = classes[j];
         if ((cls.indexOf('wp')==-1)&&(cls.indexOf('menu')==-1)&&(cls.indexOf('sidebar')==-1))
         {
              if (cls && allClasses.indexOf(cls) === -1)
                allClasses.push(cls);
         }

       }
     }

     console.log(allClasses);
}
