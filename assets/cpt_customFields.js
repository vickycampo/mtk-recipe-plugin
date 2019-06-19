window.addEventListener ( "load" , function ()
{
     /*1. We are going to add eventst to this buttons - Add and remove */
     /*2. Create the add function - Gets the parent div and multiplies it updating the id's */
     /*3. Create the remove function - updating id's */
     /*4. After Remove - updating id's */
     $( ".addButton" ).click(function( e ) {
          addButtonDown ( e );
     });
     $( ".removeButton" ).click(function( e ) {
          removeButtonDown ( e );
     });
});

function addButtonDown ( e )
{


     /* From the target id we get all the parents information */
     /* We look for the parent - which is the one we are going to duplicate */
     var parent = document.getElementById(e.target.id).parentElement;
     /* We look for the grandparent which is the target */
     var grandparent = parent.parentElement;
     /* We look for the Greatgrandparent which is the target */
     var greatgrandparent = grandparent.parentElement;

     var idsArray = e.target.id.split("[");
     /* we get the last id */
     var i = idsArray.length-2;
     var lastId = idsArray[i];
     console.log ( 'lastId - ' + lastId );

     /* we see if e is a Section */
     if ( parent.classList.contains('Section_div') > -1 )
     {
          /* We are duplicating a whole Section */

          /* we need to duplicate group_0 div*/
          duplicateSection ( lastId );

     }
     else if ( parent.classList.contains('SubSection_main_div') > -1 )
     {
          /* We are duplicating a whole SubSection */
          console.log ("Target classList - " + e.target.id);
          console.log ("parent classList - " + parent.id);
          console.log (parent.classList);
     }
     else if ( parent.classList.contains('Item_content_div') > -1 )
     {
          /* We are duplicating a whole Item */
     }
     else if ( parent.classList.contains('Item_sub_div') > -1 )
     {
          /* We are duplicating a whole Item */
     }
     // console.log ("parent id - " + parent.id );
     // console.log ( parent );
     // console.log ("grandparent id - " + grandparent.id );
     // console.log ( grandparent );




}
/* all the functions to duplicate elements */
function duplicateSection ( Id )
{
     /* we look for the last one */
     var BaseId = getBaseId ( Id );
     /* Search for the maximum id */
     var IdArray = getlastValidId (BaseId);
     LastValidId = IdArray['LastValidId'];
     FirstAvailable = IdArray['FirstAvailable'];
     console.log (BaseId + ' - '+ LastValidId + ' - '+  FirstAvailable );
     newSection = $('#' + LastValidId).clone(true);
     newSection.attr("id",FirstAvailable);
     $( newSection ).insertAfter('#' + LastValidId );
     /* we go through all the the elements */
     /* fix all the children ids */
     FixChildrenId ( LastValidId , FirstAvailable  );

}
function removeButtonDown ( e )
{
     console.log ( e );
}

/* ---------- common function ---------- */
function getBaseId ( id )
{
     var BaseId = id.substring(0, id.lastIndexOf("_"));
     return ( BaseId );
}
function getlastValidId ( BaseId )
{
     var i = 0;
     var FoundQuery = true;
     while ( FoundQuery )
     {
          if ( $('#' + BaseId + '_' + i).length > 0 )
          {
               LastValidId = BaseId + '_' + i;
               i++;

          }
          else
          {
               FirstAvailable = BaseId + '_' + i;
               FoundQuery = false;
          }

     }
     var ReturnArray = new Array;
     ReturnArray['LastValidId'] = LastValidId;
     ReturnArray['FirstAvailable'] = FirstAvailable;
     return ( ReturnArray );
}
function FixChildrenId ( PreviousId , NewId  )
{
     /* look for all the children */
     var Target = document.getElementById(NewId);
     var kids = Target.querySelectorAll('*');
     for (var i = 0; i < kids.length; i++)
     {

          //newSection.attr("id",FirstAvailable);
          if ( kids[i].id.indexOf (PreviousId) > -1 )
          {
               var dirtyId = kids[i].id;
               var cleanId = dirtyId.replace( PreviousId , NewId );
               kids[i].id = cleanId;

               /*fix the name */
               var dirtyName = Target.getElementsByName(dirtyId);
               console.log ( dirtyId );
               //mtk_default_recipe[group_0][recipe_ingredients_0][recipe_ingredient_item_0][recipe_ingredient_quantity_0]
               console.log ( dirtyName );
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
