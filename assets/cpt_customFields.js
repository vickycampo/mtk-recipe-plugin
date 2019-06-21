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
/* ---------------------------------------------- */
/*                   add functions                */
/* ---------------------------------------------- */
function addButtonDown ( e )
{


     /* From the target id we get all the parents information */
     /* We look for the parent - which is the one we are going to duplicate */
     var Parent = document.getElementById(e.target.id).parentElement;
     /* We look for the grandparent which is the target */
     var GrandParent = Parent.parentElement;
     /* We look for the Greatgrandparent which is the target */
     var GreatGrandParent = GrandParent.parentElement;


     var idsArray = e.target.id.split("-");
     /* we get the last id */
     var i = idsArray.length-4;
     var lastId = idsArray[i];

     /* we see if e is a Section */
     if ( Parent.classList.contains('Section_div')  )
     {
          /* We are duplicating a whole Section */
          /* we need to duplicate group_0 div*/
          duplicateSection ( lastId );
     }
     else if ( Parent.classList.contains('SubSection_title_h3') )
     {
          /* We are duplicating a whole SubSection */
          duplicateSubSection ( lastId , GreatGrandParent );
     }
     else if ( Parent.classList.contains('Item_sub_td') )
     {
          /* Items */
          duplicateSubSection ( lastId , GrandParent );

     }
     else if ( Parent.classList.contains ('Item_input_div') )
     {
          duplicateSubSection ( lastId , Parent );
     }
     else
     {
          console.log ('Why am I here?-------------------------');
          console.log ("parent id - " + Parent.id );
          console.log ( Parent );
          console.log ("grandparent id - " + GrandParent.id );
          console.log ( GrandParent );
          console.log ("GreatGrandParent id - " + GreatGrandParent.id );
          console.log ( GreatGrandParent );
          console.log ("lastId id - " + lastId );
     }





}
/* all the functions to duplicate elements */
function duplicateSection ( Id )
{
     /* we look for the last one */
     var BaseId = getBaseId ( Id );
     /* Search for the maximum id */
     var IdArray = getlastSectionValidId (BaseId);
     LastValidId = IdArray['LastValidId'];
     FirstAvailable = IdArray['FirstAvailable'];

     newSection = $('#' + LastValidId).clone(true);
     newSection.attr("id",FirstAvailable);
     $( newSection ).insertAfter('#' + LastValidId );
     /* we go through all the the elements */
     /* fix all the children ids */
     FixChildrenId ( LastValidId , FirstAvailable  );

}
function duplicateSubSection ( Id , GreatGrandParent )
{
     /* we look for the last one */
     var BaseId = getBaseId ( Id );
     var SearchId = Id.replace ( ']' , '');
     var TargetId = GreatGrandParent.id;

     /* Search for the maximum id */
     var IdArray = getlastSubSectionValidId (BaseId , SearchId , TargetId);


     /* clone element */
     var NewObject = $( '#' + IdArray['parent']['LastValidId'] ).clone(true);
     NewObject.attr( "id",IdArray['parent']['FirstAvailable'] );
     $( NewObject ).insertAfter('#' + IdArray['parent']['LastValidId'] );
     /* we go through all the the elements */
     /* fix all the children ids */
     FixChildrenId ( IdArray['simple']['LastValidId'] , IdArray['simple']['FirstAvailable'] , IdArray['parent']['FirstAvailable'] );

}

/* ---------------------------------------------- */
/*                  remove function               */
/* ---------------------------------------------- */
function removeButtonDown ( e )
{

     var IdsArray = e.target.id.split("-");

     /* we get the last id */
     var i = IdsArray.length-4;
     var LastTargetId = IdsArray[i];
     i = IdsArray.length-6;
     var ParentId = IdsArray[i];



     /* From the target id we get all the parents information */
     /* We look for the parent - which is the one we are going to duplicate */
     var Parent = document.getElementById(e.target.id).parentElement;
     /* We look for the grandparent which is the target */
     var GrandParent = Parent.parentElement;
     /* We look for the Greatgrandparent which is the target */
     var GreatGrandParent = GrandParent.parentElement;

     /* We need to erase the grandparent */

     if ( Parent.classList.contains('Section_div')  )
     {
          /* Remove section */
          var BaseId = getBaseId ( LastTargetId );
          var IdCombination = getlastSectionValidId ( BaseId );
          /* Only Item we don't erase id */
          if ((LastTargetId === BaseId + '_0') && (IdCombination['LastValidId'] === BaseId + '_0'))
          {
               // console.log ('Cant erase ' + BaseId + '_0');
               return;
          }
          else if (IdCombination['LastValidId'] === LastTargetId)
          {
               /* We just remove the item, no need to update anyting */

               $( "#" + LastTargetId ).remove();
               return;
          }
          /* update ids */
          $( "#" + LastTargetId ).remove();
          var erasedExtension = LastTargetId.replace(BaseId+"_", "");
          var FirstAvailable = IdCombination['LastValidId'].replace(BaseId+"_", "");
          while ( erasedExtension < FirstAvailable )
          {
               erasedExtension ++;
               previousExtension = erasedExtension -1;
               Section = document.getElementById( BaseId + "_" + erasedExtension );

               Section.id = BaseId + "_" + previousExtension;
               console.log (BaseId + "_" + erasedExtension + ' - ' + BaseId + "_" + previousExtension + ' - ' + Section.id);
          }
          return;
     }
     else
     {
          if ( Parent.classList.contains('SubSection_title_h3') )
          {
               /* Remove subsection */
               var RemoveTarget = GreatGrandParent;

          }
          else if ( Parent.classList.contains('Item_sub_td') )
          {
               /* Items */
               var RemoveTarget = GrandParent;
          }
          else if ( Parent.classList.contains ('Item_input_div') )
          {
               var RemoveTarget = Parent;
          }
          else
          {
               console.log ('Why am I here?-------------------------');
               // console.log ('Parent -----------------------------');
               // console.log (Parent);
               // console.log ('GrandParent -----------------------------');
               // console.log (GrandParent);
               // console.log ('Greatgrandparent -----------------------------');
               // console.log (Greatgrandparent);
               return;
          }



          var BaseId = getBaseId ( LastTargetId );
          var RemoveTarget_id = RemoveTarget.id;
          var IdCombination = getlastSubSectionValidId (BaseId , LastTargetId , RemoveTarget_id);
          /* Only Item we don't erase id */
          if ((LastTargetId === BaseId + '_0') && (IdCombination['simple']['LastValidId'] === BaseId + '_0'))
          {

               return;
          }
          if ( IdCombination['parent']['LastValidId'] === LastTargetId)
          {
               /* We just remove the item, no need to update anyting */
               $( "#" + LastTargetId ).remove();
               return;
          }


          var erasedExtension = parseInt(LastTargetId.replace(BaseId+"_", ""));
          var LastValidId = parseInt(IdCombination['simple']['LastValidId'].replace(BaseId+"_", ""));
          var i =  erasedExtension;
          $( "#" + RemoveTarget_id ).remove();
          while  (  i < LastValidId)
          {
               /* update the parent information */
               i ++;
               /* This Fixes the parent elements */
               previousExtension = i - 1;
               /*swap in the parent id */
               oldTargetId = RemoveTarget_id.replace(LastTargetId, BaseId + "_" + i);
               newTargetId = RemoveTarget_id.replace(LastTargetId, BaseId + "_" + previousExtension);

               Section = document.getElementById( oldTargetId );
               if ( Section )
               {
                    Section.id = newTargetId;
               }
               else
               {
                    console.log ('not found - ' + i + ' - '+ FirstAvailable);
               }
               /* change the id's of all the child elements */
               FixChildrenId ( BaseId + "_" + i , BaseId + "_" + previousExtension , newTargetId );

          }
          return;


     }


}
function removeThisItem ( Target )
{
     // console.log ( 'removeSection' );
     // console.log ( Target );
}
function UpdateIds ( BaseId , RemovedExtension,  LastExtension )
{
     // console.log ( 'removeSection' );
     // console.log ( BaseId + ' - ' + RemovedExtension + ' - ' + LastExtension );
}

/* ---------------------------------------------- */
/*                  common function               */
/* ---------------------------------------------- */
function getBaseId ( id )
{
     var BaseId = id.substring(0, id.lastIndexOf("_"));
     return ( BaseId );
}
function getlastSectionValidId ( BaseId )
{
     var i = 0;
     var FoundQuery = true;
     while ( FoundQuery )
     {
          // console.log (BaseId + '_' + i);
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
function getlastSubSectionValidId (BaseId , SearchId , TargetId)
{
     var i = 0;
     var FoundQuery = true;
     var ReturnArray = new Array;
     ReturnArray['simple'] = new Array;
     ReturnArray['parent'] = new Array;
     while ( FoundQuery )
     {
          var NewId = TargetId.replace ( SearchId , BaseId + '_' + i );
          ReturnArray['parent']['FirstAvailable'] = NewId;
          if ( $('#' + NewId).length > 0 )
          {
               ReturnArray['parent']['LastValidId'] = NewId;
               LastValidId = BaseId + '_' + i;
               i++;
          }
          else
          {
               FirstAvailable = BaseId + '_' + i;
               FoundQuery = false;
          }
     }
     ReturnArray['simple']['LastValidId'] = LastValidId;
     ReturnArray['simple']['FirstAvailable'] = FirstAvailable;
     return ( ReturnArray );
}
function FixChildrenId ( PreviousId , NewId , targetID=''  )
{
     //console.log (PreviousId + ' - ' + NewId + ' - ' + targetID);
     if ( targetID == '' )
     {
          /* look for all the children */
          var Target = document.getElementById(NewId);
     }
     else
     {
          var Target = document.getElementById(targetID);
     }

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

               for (j in kids[i].attributes )
               {
                    if ( kids[i].attributes[j].name === 'name' )
                    {
                         var dirtyName = kids[i].attributes[j].value;
                         var cleanName = dirtyName.replace( PreviousId , NewId );
                         kids[i].attributes[j].value = cleanName;
                    }

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
