// wp.blocks.registerBlockType ( 'mtk-plugin/myfirstblock' , {
//      title: 'My First Block',
//      icon: 'welcome-add-page',
//      category: 'common',
//      attributes: {
//           content: {
//                type: 'array',
//                source: 'children',
//                selector: 'p'
//           },
//      },
//      edit: function ( props ){
//           return wp.element.createElement ( 'p', {
//                tagName: 'p',
//                className: props.className,
//                value: props.attributes.content,
//                onChange: function ( newContent ){
//                     props.setAttributes ( {contet: newContent});
//                }
//           });
//      },
//      save: function ( props ){
//           return wp.element.createElement( 'p' , {
//                className: props.className,
//           }, props.attributes.content);
//      }
// });
/* IIFE function */
(function () {
     var el = wp.element.createElement;
     var registgerBlockType = wp.blocks.registerBlockType;
     var PlainText = wp.editor.PlainText;
     registgerBlockType('mtk-plugin/myfirstblock' , {
          title: 'My First Block',
          icon: 'welcome-add-page',
          category: 'common',
          attributes: {
               text: {
                    source: 'children',
                    selector: 'p',
                    default: ''
               }
          },
          edit: function ( props ){
               console.log ( props );
               return (
                    el
                    (
                         PlainText,
                         {
                              className: 'mtk-block',
                              onChange: function ( value )
                              {
                                   props.setAttributes ( {text: value});
                              },
                              value: props.attributes.text
                         }

                    )
               );
          },
          save: function ( props ){
               return (
                    el
                    (
                         'p',
                         { className: 'mtk-block' },
                         props.attributes.text
                    )
               );
          },
     });

})()
