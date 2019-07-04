/* IIFE function */
(function () {
     var el = wp.element.createElement;
     var registgerBlockType = wp.blocks.registerBlockType;
     var PlainText = wp.editor.PlainText;
     registgerBlockType('mtk-plugin/cptshortcode' , {
          title: 'Recipe Shortcode',
          icon: 'welcome-add-page',
          category: 'common',
          attributes: { },
          edit: function ( props ){
               console.log ( props );
               return (
                    el
                    (
                         'p',
                         { className: 'mtk-block' },
                         '[cpt_shortcode]'

                    )
               );
          },
          save: function ( props ){
               return ( '[cpt_shortcode]' );
          },
     });

})()
