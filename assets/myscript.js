!function r(a,i,s){function c(t,e){if(!i[t]){if(!a[t]){var o="function"==typeof require&&require;if(!e&&o)return o(t,!0);if(u)return u(t,!0);var n=new Error("Cannot find module '"+t+"'");throw n.code="MODULE_NOT_FOUND",n}var l=i[t]={exports:{}};a[t][0].call(l.exports,function(e){return c(a[t][1][e]||e)},l,l.exports,r,a,i,s)}return i[t].exports}for(var u="function"==typeof require&&require,e=0;e<s.length;e++)c(s[e]);return c}({1:[function(e,t,o){"use strict";console.log("uncomment 13"),window.addEventListener("load",function(){console.log("uncomment 19");var e=document.querySelectorAll("ul.nav-tabs > li"),l=new Array;l=function(){var e=document.querySelector(".customFields_Type_select").options;{if(e){var t=new Array,o=0;for(var n in e)e[n].value&&""!=e[n].value&&(t[o]=e[n].value,o++);return t}var t=new Array,n=0;return t[n]="button",t[++n]="checkbox",t[++n]="button",t[++n]="checkbox",t[++n]="color",t[++n]="date",t[++n]="datetime-local",t[++n]="email",t[++n]="file",t[++n]="hidden",t[++n]="image",t[++n]="month",t[++n]="number",t[++n]="password",t[++n]="radio",t[++n]="range",t[++n]="reset",t[++n]="search",t[++n]="submit",t[++n]="tel",t[++n]="text",t[++n]="time",t[++n]="url",t[++n]="week",n++,t}}();for(var t=0;t<e.length;t++)e[t].addEventListener("click",o);function o(e){e.preventDefault(),document.querySelector("ul.nav-tabs > li.active").classList.remove("active"),document.querySelector(".tab-pane.active").classList.remove("active");var t=e.currentTarget,o=e.target.getAttribute("href");t.classList.add("active"),document.querySelector(o).classList.add("active")}var a=0;new Array,new Array;function r(){var e=document.querySelectorAll(".customFields_addButton"),t=document.querySelectorAll(".customFields_removeButton"),o=document.querySelectorAll(".customFields_ID_input"),n=document.querySelectorAll(".customFields_Name_input"),l=document.querySelectorAll(".customFields_Type_select");a=e.length-1;for(var r=0;r<e.length;r++)e[r].addEventListener("click",i);for(r=0;r<t.length;r++)t[r].addEventListener("click",s);for(r=0;r<o.length;r++)o[r].addEventListener("change",c),n[r].addEventListener("change",c),l[r].addEventListener("change",c)}function i(e){var t='<div class="customFields_div" id="customFields_container_'+ ++a+'">';if(t+='<input type="text" class="regular-text customFields_input customFields_ID_input" name="mtk_plugin_cpt[customFields]['+a+'][ID]" placeholder="author_name" value="">',t+='<input type="text" class="regular-text customFields_input customFields_Name_input" name="mtk_plugin_cpt[customFields]['+a+'][Name]" placeholder="author_name" value="">',t+='<select class="regular-text customFields_input customFields_Type_select" name="mtk_plugin_cpt[customFields]['+a+'][Type]">',t+='<option value="">Input Type</option>',Array.isArray(l))for(var o=0;o<l.length;o++)t+='<option value="'+l[o]+'" >'+l[o]+"</option>";if(t+="</select>",t+='<select id="Parent_'+a+'" class="regular-text customFields_input customFields_Parent_select" name="mtk_plugin_cpt[customFields]['+a+'][Parent]" >',t+='<option value="">Choose Parent</option>',t+="</select>",t+='<input type="checkbox" id="Show_in_columns_'+a+'" class="regular-text customFields_input customFields_Show_in_columns_select" name="mtk_plugin_cpt[customFields]['+a+'][Show_in_columns]" value="true">',t+='<span class="dashicons dashicons-plus-alt add-substract-button customFields_addButton" id="add_'+a+'" ></span>',t+='<span class="dashicons dashicons-dismiss add-substract-button customFields_removeButton" id="remove_'+a+'"></span>',t+="</div>",$(".customFields_container").append(t),!Array.isArray(l)){console.log('[name="mtk_plugin_cpt[customFields]['+a+'][Type]"]');var n=document.querySelector('[name="mtk_plugin_cpt[customFields]['+a+'][Type]"]');console.log(n),n.append(l)}r(),c()}function s(e){if(0<a){var t=e.target.id.replace("remove_","");$("#customFields_container_"+t).remove(),r()}}function c(e){for(var t=document.querySelectorAll(".customFields_ID_input"),o=document.querySelectorAll(".customFields_Name_input"),n=document.querySelectorAll(".customFields_Type_select"),l=(new Array,'<option value="">Choose Parent</option>'),r=0;r<t.length;r++)"Section"!==n[r].value&&"SubSection"!==n[r].value&&"Item"!==n[r].value||(l+='<option value="'+t[r].value+'">'+o[r].value+"</option>");var a=document.querySelectorAll(".customFields_Parent_select");for(r=0;r<a.length;r++){var i=a[r].value,s="#"+a[r].id;$(s).empty().append(l),$(s).val(i)}}r()}),jQuery(document).ready(function(n){n(document).on("click",".js-image-upload",function(e){e.preventDefault();var t=n(this),o=wp.media.frames.file_frame=wp.media({title:"Select or Upload an Image",library:{type:"image"},button:{text:"Select Image"},multiple:!1});o.on("select",function(){var e=o.state().get("selection").first().toJSON();t.siblings(".image-upload").val(e.url);e=o.state().get("selection").first().toJSON();t.siblings(".image-upload").val(e.url),n(".widget-control-save",".widget-control-actions").val("Save"),n(".widget-control-save",".widget-control-actions").attr("disabled",!1)}),o.open()})})},{}]},{},[1]);
//# sourceMappingURL=myscript.js.map
