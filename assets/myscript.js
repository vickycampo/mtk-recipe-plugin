!function l(s,o,i){function c(t,e){if(!o[t]){if(!s[t]){var n="function"==typeof require&&require;if(!e&&n)return n(t,!0);if(u)return u(t,!0);var r=new Error("Cannot find module '"+t+"'");throw r.code="MODULE_NOT_FOUND",r}var a=o[t]={exports:{}};s[t][0].call(a.exports,function(e){return c(s[t][1][e]||e)},a,a.exports,l,s,o,i)}return o[t].exports}for(var u="function"==typeof require&&require,e=0;e<i.length;e++)c(i[e]);return c}({1:[function(e,t,n){window.PR_SHOULD_USE_CONTINUATION=!0,function(){var E=window,e=["break,continue,do,else,for,if,return,while"],t=[[e,"auto,case,char,const,default,double,enum,extern,float,goto,inline,int,long,register,restrict,short,signed,sizeof,static,struct,switch,typedef,union,unsigned,void,volatile"],"catch,class,delete,false,import,new,operator,private,protected,public,this,throw,true,try,typeof"],n=[t,"alignas,alignof,align_union,asm,axiom,bool,concept,concept_map,const_cast,constexpr,decltype,delegate,dynamic_cast,explicit,export,friend,generic,late_check,mutable,namespace,noexcept,noreturn,nullptr,property,reinterpret_cast,static_assert,static_cast,template,typeid,typename,using,virtual,where"],r=[t,"abstract,assert,boolean,byte,extends,finally,final,implements,import,instanceof,interface,null,native,package,strictfp,super,synchronized,throws,transient"],a=[t,"abstract,add,alias,as,ascending,async,await,base,bool,by,byte,checked,decimal,delegate,descending,dynamic,event,finally,fixed,foreach,from,get,global,group,implicit,in,interface,internal,into,is,join,let,lock,null,object,out,override,orderby,params,partial,readonly,ref,remove,sbyte,sealed,select,set,stackalloc,string,select,uint,ulong,unchecked,unsafe,ushort,value,var,virtual,where,yield"],l=[t,"abstract,async,await,constructor,debugger,enum,eval,export,function,get,implements,instanceof,interface,let,null,set,undefined,var,with,yield,Infinity,NaN"],s="caller,delete,die,do,dump,elsif,eval,exit,foreach,for,goto,if,import,last,local,my,next,no,our,print,package,redo,require,sub,undef,unless,until,use,wantarray,while,BEGIN,END",o=[e,"and,as,assert,class,def,del,elif,except,exec,finally,from,global,import,in,is,lambda,nonlocal,not,or,pass,print,raise,try,with,yield,False,True,None"],i=[e,"alias,and,begin,case,class,def,defined,elsif,end,ensure,false,in,module,next,nil,not,or,redo,rescue,retry,self,super,then,true,undef,unless,until,when,yield,BEGIN,END"],c=[e,"case,done,elif,esac,eval,fi,function,in,local,set,then,until"],u=/^(DIR|FILE|array|vector|(de|priority_)?queue|(forward_)?list|stack|(const_)?(reverse_)?iterator|(unordered_)?(multi)?(set|map)|bitset|u?(int|float)\d*)\b/,d="str",p="com",f="typ",m="lit",v="pun",$="pln",A="src",g="atv";function k(e,t,n,r,a){if(n){var l={sourceNode:e,pre:1,langExtension:null,numberLines:null,sourceCode:n,spans:null,basePos:t,decorations:null};r(l),a.push.apply(a,l.decorations)}}var h=/\S/;function P(e){for(var t=void 0,n=e.firstChild;n;n=n.nextSibling){var r=n.nodeType;t=1===r?t?e:n:3===r&&h.test(n.nodeValue)?e:t}return t===e?void 0:t}function y(u,x){var _,S={};!function(){for(var e=u.concat(x),t=[],n={},r=0,a=e.length;r<a;++r){var l=e[r],s=l[3];if(s)for(var o=s.length;0<=--o;)S[s.charAt(o)]=l;var i=l[1],c=""+i;n.hasOwnProperty(c)||(t.push(i),n[c]=null)}t.push(/[\0-\uffff]/),_=function(e){for(var c=0,u=!1,t=!1,n=0,r=e.length;n<r;++n)if((o=e[n]).ignoreCase)t=!0;else if(/[a-z]/i.test(o.source.replace(/\\u[0-9a-f]{4}|\\x[0-9a-f]{2}|\\[^ux]/gi,""))){t=!(u=!0);break}var a={b:8,t:9,n:10,v:11,f:12,r:13};function f(e){var t=e.charCodeAt(0);if(92!==t)return t;var n=e.charAt(1);return(t=a[n])||("0"<=n&&n<="7"?parseInt(e.substring(1),8):"u"===n||"x"===n?parseInt(e.substring(2),16):e.charCodeAt(1))}function m(e){if(e<32)return(e<16?"\\x0":"\\x")+e.toString(16);var t=String.fromCharCode(e);return"\\"===t||"-"===t||"]"===t||"^"===t?"\\"+t:t}function d(e){var t=e.substring(1,e.length-1).match(new RegExp("\\\\u[0-9A-Fa-f]{4}|\\\\x[0-9A-Fa-f]{2}|\\\\[0-3][0-7]{0,2}|\\\\[0-7]{1,2}|\\\\[\\s\\S]|-|[^-\\\\]","g")),n=[],r="^"===t[0],a=["["];r&&a.push("^");for(var l=r?1:0,s=t.length;l<s;++l){var o=t[l];if(/\\[bdsw]/i.test(o))a.push(o);else{var i,c=f(o);l+2<s&&"-"===t[l+1]?(i=f(t[l+2]),l+=2):i=c,n.push([c,i]),i<65||122<c||(i<65||90<c||n.push([32|Math.max(65,c),32|Math.min(i,90)]),i<97||122<c||n.push([-33&Math.max(97,c),-33&Math.min(i,122)]))}}n.sort(function(e,t){return e[0]-t[0]||t[1]-e[1]});var u=[],d=[];for(l=0;l<n.length;++l)(p=n[l])[0]<=d[1]+1?d[1]=Math.max(d[1],p[1]):u.push(d=p);for(l=0;l<u.length;++l){var p=u[l];a.push(m(p[0])),p[1]>p[0]&&(p[1]+1>p[0]&&a.push("-"),a.push(m(p[1])))}return a.push("]"),a.join("")}function l(e){for(var t=e.source.match(new RegExp("(?:\\[(?:[^\\x5C\\x5D]|\\\\[\\s\\S])*\\]|\\\\u[A-Fa-f0-9]{4}|\\\\x[A-Fa-f0-9]{2}|\\\\[0-9]+|\\\\[^ux0-9]|\\(\\?[:!=]|[\\(\\)\\^]|[^\\x5B\\x5C\\(\\)\\^]+)","g")),n=t.length,r=[],a=0,l=0;a<n;++a)"("===(o=t[a])?++l:"\\"===o.charAt(0)&&(s=+o.substring(1))&&(s<=l?r[s]=-1:t[a]=m(s));for(a=1;a<r.length;++a)-1===r[a]&&(r[a]=++c);for(l=a=0;a<n;++a)if("("===(o=t[a]))r[++l]||(t[a]="(?:");else if("\\"===o.charAt(0)){var s;(s=+o.substring(1))&&s<=l&&(t[a]="\\"+r[s])}for(a=0;a<n;++a)"^"===t[a]&&"^"!==t[a+1]&&(t[a]="");if(e.ignoreCase&&u)for(a=0;a<n;++a){var o,i=(o=t[a]).charAt(0);2<=o.length&&"["===i?t[a]=d(o):"\\"!==i&&(t[a]=o.replace(/[a-zA-Z]/g,function(e){var t=e.charCodeAt(0);return"["+String.fromCharCode(-33&t,32|t)+"]"}))}return t.join("")}var s=[];for(n=0,r=e.length;n<r;++n){var o;if((o=e[n]).global||o.multiline)throw new Error(""+o);s.push("(?:"+l(o)+")")}return new RegExp(s.join("|"),t?"gi":"g")}(t)}();var C=x.length,N=function(e){for(var t=e.sourceCode,n=e.basePos,r=e.sourceNode,a=[n,$],l=0,s=t.match(_)||[],o={},i=0,c=s.length;i<c;++i){var u,d=s[i],p=o[d],f=void 0;if("string"==typeof p)u=!1;else{var m=S[d.charAt(0)];if(m)f=d.match(m[1]),p=m[0];else{for(var v=0;v<C;++v)if(m=x[v],f=d.match(m[1])){p=m[0];break}f||(p=$)}!(u=5<=p.length&&"lang-"===p.substring(0,5))||f&&"string"==typeof f[1]||(u=!1,p=A),u||(o[d]=p)}var g=l;if(l+=d.length,u){var h=f[1],y=d.indexOf(h),b=y+h.length;f[2]&&(y=(b=d.length-f[2].length)-h.length);var w=p.substring(5);k(r,n+g,d.substring(0,y),N,a),k(r,n+g+y,h,L(w,h),a),k(r,n+g+b,d.substring(b),N,a)}else a.push(n+g,p)}e.decorations=a};return N}function b(e){var t=[],n=[];e.tripleQuotedStrings?t.push([d,/^(?:\'\'\'(?:[^\'\\]|\\[\s\S]|\'{1,2}(?=[^\']))*(?:\'\'\'|$)|\"\"\"(?:[^\"\\]|\\[\s\S]|\"{1,2}(?=[^\"]))*(?:\"\"\"|$)|\'(?:[^\\\']|\\[\s\S])*(?:\'|$)|\"(?:[^\\\"]|\\[\s\S])*(?:\"|$))/,null,"'\""]):e.multiLineStrings?t.push([d,/^(?:\'(?:[^\\\']|\\[\s\S])*(?:\'|$)|\"(?:[^\\\"]|\\[\s\S])*(?:\"|$)|\`(?:[^\\\`]|\\[\s\S])*(?:\`|$))/,null,"'\"`"]):t.push([d,/^(?:\'(?:[^\\\'\r\n]|\\.)*(?:\'|$)|\"(?:[^\\\"\r\n]|\\.)*(?:\"|$))/,null,"\"'"]),e.verbatimStrings&&n.push([d,/^@\"(?:[^\"]|\"\")*(?:\"|$)/,null]);var r=e.hashComments;r&&(e.cStyleComments?(1<r?t.push([p,/^#(?:##(?:[^#]|#(?!##))*(?:###|$)|.*)/,null,"#"]):t.push([p,/^#(?:(?:define|e(?:l|nd)if|else|error|ifn?def|include|line|pragma|undef|warning)\b|[^\r\n]*)/,null,"#"]),n.push([d,/^<(?:(?:(?:\.\.\/)*|\/?)(?:[\w-]+(?:\/[\w-]+)+)?[\w-]+\.h(?:h|pp|\+\+)?|[a-z]\w*)>/,null])):t.push([p,/^#[^\r\n]*/,null,"#"])),e.cStyleComments&&(n.push([p,/^\/\/[^\r\n]*/,null]),n.push([p,/^\/\*[\s\S]*?(?:\*\/|$)/,null]));var a=e.regexLiterals;if(a){var l=1<a?"":"\n\r",s=l?".":"[\\S\\s]",o="/(?=[^/*"+l+"])(?:[^/\\x5B\\x5C"+l+"]|\\x5C"+s+"|\\x5B(?:[^\\x5C\\x5D"+l+"]|\\x5C"+s+")*(?:\\x5D|$))+/";n.push(["lang-regex",RegExp("^(?:^^\\.?|[+-]|[!=]=?=?|\\#|%=?|&&?=?|\\(|\\*=?|[+\\-]=|->|\\/=?|::?|<<?=?|>>?>?=?|,|;|\\?|@|\\[|~|{|\\^\\^?=?|\\|\\|?=?|break|case|continue|delete|do|else|finally|instanceof|return|throw|try|typeof)\\s*("+o+")")])}var i=e.types;i&&n.push([f,i]);var c=(""+e.keywords).replace(/^ | $/g,"");c.length&&n.push(["kwd",new RegExp("^(?:"+c.replace(/[\s,]+/g,"|")+")\\b"),null]),t.push([$,/^\s+/,null," \r\n\t "]);var u="^.[^\\s\\w.$@'\"`/\\\\]*";return e.regexLiterals&&(u+="(?!s*/)"),n.push([m,/^@[a-z_$][a-z_$@0-9]*/i,null],[f,/^(?:[@_]?[A-Z]+[a-z][A-Za-z_$@0-9]*|\w+_t\b)/,null],[$,/^[a-z_$][a-z_$@0-9]*/i,null],[m,new RegExp("^(?:0x[a-f0-9]+|(?:\\d(?:_\\d+)*\\d*(?:\\.\\d*)?|\\.\\d\\+)(?:e[+\\-]?\\d+)?)[a-z]*","i"),null,"0123456789"],[$,/^\\[\s\S]?/,null],[v,new RegExp(u),null]),y(t,n)}var w=b({keywords:[n,a,r,l,s,o,i,c],hashComments:!0,cStyleComments:!0,multiLineStrings:!0,regexLiterals:!0});function T(e,t,o){for(var i=/(?:^|\s)nocode(?:\s|$)/,c=/\r\n?|\n/,u=e.ownerDocument,n=u.createElement("li");e.firstChild;)n.appendChild(e.firstChild);var r=[n];function d(e){var t=e.nodeType;if(1!=t||i.test(e.className)){if((3==t||4==t)&&o){var n=e.nodeValue,r=n.match(c);if(r){var a=n.substring(0,r.index);e.nodeValue=a;var l=n.substring(r.index+r[0].length);if(l)e.parentNode.insertBefore(u.createTextNode(l),e.nextSibling);p(e),a||e.parentNode.removeChild(e)}}}else if("br"===e.nodeName)p(e),e.parentNode&&e.parentNode.removeChild(e);else for(var s=e.firstChild;s;s=s.nextSibling)d(s)}function p(e){for(;!e.nextSibling;)if(!(e=e.parentNode))return;for(var t,n=function e(t,n){var r=n?t.cloneNode(!1):t,a=t.parentNode;if(a){var l=e(a,1),s=t.nextSibling;l.appendChild(r);for(var o=s;o;o=s)s=o.nextSibling,l.appendChild(o)}return r}(e.nextSibling,0);(t=n.parentNode)&&1===t.nodeType;)n=t;r.push(n)}for(var a=0;a<r.length;++a)d(r[a]);t===(0|t)&&r[0].setAttribute("value",t);var l=u.createElement("ol");l.className="linenums";for(var s=Math.max(0,t-1|0)||0,f=(a=0,r.length);a<f;++a)(n=r[a]).className="L"+(a+s)%10,n.firstChild||n.appendChild(u.createTextNode(" ")),l.appendChild(n);e.appendChild(l)}var x={};function _(e,t){for(var n=t.length;0<=--n;){var r=t[n];x.hasOwnProperty(r)?E.console&&console.warn("cannot override language handler %s",r):x[r]=e}}function L(e,t){return e&&x.hasOwnProperty(e)||(e=/^\s*</.test(t)?"default-markup":"default-code"),x[e]}function F(e){var t=e.langExtension;try{var n=function(e,s){var o=/(?:^|\s)nocode(?:\s|$)/,i=[],c=0,u=[],d=0;return function e(t){var n=t.nodeType;if(1==n){if(o.test(t.className))return;for(var r=t.firstChild;r;r=r.nextSibling)e(r);var a=t.nodeName.toLowerCase();"br"!==a&&"li"!==a||(i[d]="\n",u[d<<1]=c++,u[d++<<1|1]=t)}else if(3==n||4==n){var l=t.nodeValue;l.length&&(l=s?l.replace(/\r\n?/g,"\n"):l.replace(/[ \t\r\n]+/g," "),i[d]=l,u[d<<1]=c,c+=l.length,u[d++<<1|1]=t)}}(e),{sourceCode:i.join("").replace(/\n$/,""),spans:u}}(e.sourceNode,e.pre),r=n.sourceCode;e.sourceCode=r,e.spans=n.spans,e.basePos=0,L(t,r)(e),function(e){var t=/\bMSIE\s(\d+)/.exec(navigator.userAgent);t=t&&+t[1]<=8;var n,r,a=/\n/g,l=e.sourceCode,s=l.length,o=0,i=e.spans,c=i.length,u=0,d=e.decorations,p=d.length,f=0;for(d[p]=s,r=n=0;r<p;)d[r]!==d[r+2]?(d[n++]=d[r++],d[n++]=d[r++]):r+=2;for(p=n,r=n=0;r<p;){for(var m=d[r],v=d[r+1],g=r+2;g+2<=p&&d[g+1]===v;)g+=2;d[n++]=m,d[n++]=v,r=g}p=d.length=n;var h=e.sourceNode,y="";h&&(y=h.style.display,h.style.display="none");try{for(;u<c;){i[u];var b,w=i[u+2]||s,x=d[f+2]||s,_=(g=Math.min(w,x),i[u+1]);if(1!==_.nodeType&&(b=l.substring(o,g))){t&&(b=b.replace(a,"\r")),_.nodeValue=b;var S=_.ownerDocument,C=S.createElement("span");C.className=d[f+1];var N=_.parentNode;N.replaceChild(C,_),C.appendChild(_),o<w&&(i[u+1]=_=S.createTextNode(l.substring(g,w)),N.insertBefore(_,C.nextSibling))}w<=(o=g)&&(u+=2),x<=o&&(f+=2)}}finally{h&&(h.style.display=y)}}(e)}catch(e){E.console&&console.log(e&&e.stack||e)}}function S(e,t,n){var r=n||!1,a=t||null,l=document.createElement("div");return l.innerHTML="<pre>"+e+"</pre>",l=l.firstChild,r&&T(l,r,!0),F({langExtension:a,numberLines:r,sourceNode:l,pre:1,sourceCode:null,basePos:null,spans:null,decorations:null}),l.innerHTML}function C(y,e){var t=e||document.body,b=t.ownerDocument||document;function n(e){return t.getElementsByTagName(e)}for(var r=[n("pre"),n("code"),n("xmp")],w=[],a=0;a<r.length;++a)for(var l=0,s=r[a].length;l<s;++l)w.push(r[a][l]);r=null;var x=Date;x.now||(x={now:function(){return+new Date}});var _=0,S=/\blang(?:uage)?-([\w.]+)(?!\S)/,C=/\bprettyprint\b/,N=/\bprettyprinted\b/,$=/pre|xmp/i,A=/^code$/i,k=/^(?:pre|code|xmp)$/i,L={};!function e(){for(var t=E.PR_SHOULD_USE_CONTINUATION?x.now()+250:1/0;_<w.length&&x.now()<t;_++){for(var n=w[_],r=L,a=n;a=a.previousSibling;){var l=a.nodeType,s=(7===l||8===l)&&a.nodeValue;if(s?!/^\??prettify\b/.test(s):3!==l||/\S/.test(a.nodeValue))break;if(s){r={},s.replace(/\b(\w+)=([\w:.%+-]+)/g,function(e,t,n){r[t]=n});break}}var o=n.className;if((r!==L||C.test(o))&&!N.test(o)){for(var i=!1,c=n.parentNode;c;c=c.parentNode){var u=c.tagName;if(k.test(u)&&c.className&&C.test(c.className)){i=!0;break}}if(!i){n.className+=" prettyprinted";var d,p,f=r.lang;if(f||(!(f=o.match(S))&&(d=P(n))&&A.test(d.tagName)&&(f=d.className.match(S)),f&&(f=f[1])),$.test(n.tagName))p=1;else{var m=n.currentStyle,v=b.defaultView,g=m?m.whiteSpace:v&&v.getComputedStyle?v.getComputedStyle(n,null).getPropertyValue("white-space"):0;p=g&&"pre"===g.substring(0,3)}var h=r.linenums;(h="true"===h||+h)||(h=!!(h=o.match(/\blinenums\b(?::(\d+))?/))&&(!h[1]||!h[1].length||+h[1])),h&&T(n,h,p),F({langExtension:f,sourceNode:n,numberLines:h,pre:p,sourceCode:null,basePos:null,spans:null,decorations:null})}}}_<w.length?E.setTimeout(e,250):"function"==typeof y&&y()}()}_(w,["default-code"]),_(y([],[[$,/^[^<?]+/],["dec",/^<!\w[^>]*(?:>|$)/],[p,/^<\!--[\s\S]*?(?:-\->|$)/],["lang-",/^<\?([\s\S]+?)(?:\?>|$)/],["lang-",/^<%([\s\S]+?)(?:%>|$)/],[v,/^(?:<[%?]|[%?]>)/],["lang-",/^<xmp\b[^>]*>([\s\S]+?)<\/xmp\b[^>]*>/i],["lang-js",/^<script\b[^>]*>([\s\S]*?)(<\/script\b[^>]*>)/i],["lang-css",/^<style\b[^>]*>([\s\S]*?)(<\/style\b[^>]*>)/i],["lang-in.tag",/^(<\/?[a-z][^<>]*>)/i]]),["default-markup","htm","html","mxml","xhtml","xml","xsl"]),_(y([[$,/^[\s]+/,null," \t\r\n"],[g,/^(?:\"[^\"]*\"?|\'[^\']*\'?)/,null,"\"'"]],[["tag",/^^<\/?[a-z](?:[\w.:-]*\w)?|\/?>$/i],["atn",/^(?!style[\s=]|on)[a-z](?:[\w:-]*\w)?/i],["lang-uq.val",/^=\s*([^>\'\"\s]*(?:[^>\'\"\s\/]|\/(?=\s)))/],[v,/^[=<>\/]+/],["lang-js",/^on\w+\s*=\s*\"([^\"]+)\"/i],["lang-js",/^on\w+\s*=\s*\'([^\']+)\'/i],["lang-js",/^on\w+\s*=\s*([^\"\'>\s]+)/i],["lang-css",/^style\s*=\s*\"([^\"]+)\"/i],["lang-css",/^style\s*=\s*\'([^\']+)\'/i],["lang-css",/^style\s*=\s*([^\"\'>\s]+)/i]]),["in.tag"]),_(y([],[[g,/^[\s\S]+/]]),["uq.val"]),_(b({keywords:n,hashComments:!0,cStyleComments:!0,types:u}),["c","cc","cpp","cxx","cyc","m"]),_(b({keywords:"null,true,false"}),["json"]),_(b({keywords:a,hashComments:!0,cStyleComments:!0,verbatimStrings:!0,types:u}),["cs"]),_(b({keywords:r,cStyleComments:!0}),["java"]),_(b({keywords:c,hashComments:!0,multiLineStrings:!0}),["bash","bsh","csh","sh"]),_(b({keywords:o,hashComments:!0,multiLineStrings:!0,tripleQuotedStrings:!0}),["cv","py","python"]),_(b({keywords:s,hashComments:!0,multiLineStrings:!0,regexLiterals:2}),["perl","pl","pm"]),_(b({keywords:i,hashComments:!0,multiLineStrings:!0,regexLiterals:!0}),["rb","ruby"]),_(b({keywords:l,cStyleComments:!0,regexLiterals:!0}),["javascript","js","ts","typescript"]),_(b({keywords:"all,and,by,catch,class,else,extends,false,finally,for,if,in,is,isnt,loop,new,no,not,null,of,off,on,or,return,super,then,throw,true,try,unless,until,when,while,yes",hashComments:3,cStyleComments:!0,multilineStrings:!0,tripleQuotedStrings:!0,regexLiterals:!0}),["coffee"]),_(y([],[[d,/^[\s\S]+/]]),["regex"]);var N=E.PR={createSimpleLexer:y,registerLangHandler:_,sourceDecorator:b,PR_ATTRIB_NAME:"atn",PR_ATTRIB_VALUE:g,PR_COMMENT:p,PR_DECLARATION:"dec",PR_KEYWORD:"kwd",PR_LITERAL:m,PR_NOCODE:"nocode",PR_PLAIN:$,PR_PUNCTUATION:v,PR_SOURCE:A,PR_STRING:d,PR_TAG:"tag",PR_TYPE:f,prettyPrintOne:S,prettyPrint:C},R=E.define;"function"==typeof R&&R.amd&&R("google-code-prettify",[],function(){return N})}()},{}],2:[function(e,t,n){"use strict";e("code-prettify"),window.addEventListener("load",function(){PR.prettyPrint();for(var e=document.querySelectorAll("ul.nav-tabs > li"),t=0;t<e.length;t++)e[t].addEventListener("click",n);function n(e){e.preventDefault(),document.querySelector("ul.nav-tabs > li.active").classList.remove("active"),document.querySelector(".tab-pane.active").classList.remove("active");var t=e.currentTarget,n=e.target.getAttribute("href");t.classList.add("active"),document.querySelector(n).classList.add("active")}}),$(".customFields_container").ready(function(){var i,c,e,u=new Array,p=!1;function d(){var e=document.querySelectorAll(".customFields_addButton"),t=document.querySelectorAll(".customFields_removeButton"),n=document.querySelectorAll(".customFields_ID_input"),r=document.querySelectorAll(".customFields_Name_input"),a=document.querySelectorAll(".customFields_Type_select");i=n.length-1;for(var l=0;l<e.length;l++)e[l].addEventListener("click",s),t[l].addEventListener("click",o),i=t[l].id.replace("remove_",""),n[l].addEventListener("change",h),r[l].addEventListener("change",h),a[l].addEventListener("change",h)}function s(e){var t=function(e,t,n){var r=document.createElement("div");return r.id=e,r.classList.add(t),n.append(r),r}(r="customFields_container_"+ ++i,a="customFields_div",document.querySelector(".customFields_container"));for(var n in c)if("button"!=c[n].type){var r=n+"_"+i,a="regular-text customFields_input customFields_"+n+"_input",l="mtk_plugin_cpt[customFields]["+i+"]["+n+"]",s=c[n].placeholder;if("text"==c[n].type)f(r,l,a,s,t);else if("select"==c[n].type){a="regular-text customFields_input customFields_"+n+"_select";if("Type"===n)var o=u;else if("Parent"===n)o=new Array;m(r,l,a,o,t)}else"checkbox"==c[n].type&&v(r,l,a,s,t)}else{g(r=n+"_"+i,a=c[n].class,t)}d()}function f(e,t,n,r,a){var l=document.createElement("input");if(l.type="text",l.id=e,l.name=t,l.placeholder=r,n.indexOf(" ")<0)l.classList.add(n);else{var s=n.split(" ");for(var o in s)l.classList.add(s[o])}var i="#"+a.id;$(i).append(l)}function m(e,t,n,r,a){var l=document.createElement("select");if(l.id=e,l.name=t,a.appendChild(l),n.indexOf(" ")<0)l.classList.add(n);else{var s=n.split(" ");for(var o in s)l.classList.add(s[o])}var i="#"+a.id;if($(i).append(l),Array.isArray(r))for(var c=0;c<r.length;c++){var u=document.createElement("option");u.value=r[c],u.text=r[c],l.appendChild(u)}}function v(e,t,n,r,a){var l=document.createElement("span");if(l.id=e,n.indexOf(" ")<0)l.classList.add(n);else{var s=n.split(" ");for(var o in s)l.classList.add(s[o])}var i="#"+l.id,c="#"+a.id;$(c).append(l),$(i).css("display","inline-block"),$(i).css("text-align","center"),$(i).width("75px");var u=document.createElement("input");u.type="checkbox",u.name=t,u.value=r;i="#"+l.id;$(i).append(u)}function g(e,t,n){var r=document.createElement("span");if(r.id=e,t.indexOf(" ")<0)r.classList.add(t);else{var a=t.split(" ");for(var l in a)r.classList.add(a[l])}var s="#"+n.id;$(s).append(r)}function o(e){var t=document.querySelectorAll(".customFields_div");if("string"===jQuery.type(e))$(e).remove();else if(1<t.length){var n=e.target.id.replace("remove_","");$("#customFields_container_"+n).remove()}}function h(){var e=document.querySelectorAll(".customFields_ID_input"),t=document.querySelectorAll(".customFields_Name_input"),n=document.querySelectorAll(".customFields_Type_select"),r=document.querySelectorAll(".customFields_Parent_select"),a=new Array,l=new Array;p=!1;for(var s=0;s<e.length;s++){var o=r[s].value,i="#"+r[s].id,c='<option value="">Choose Parent</option>',u=n[s].value;if("Section"==u)id=e[s].value,name=t[s].value,value=o,c+='<option value="'+id+'">'+name+"</option>",o=id;else if("SubSection"==u)for(var d=0;d<n.length;d++)"Section"===n[d].value&&(id=e[d].value,name=t[d].value,c+='<option value="'+id+'">'+name+"</option>");else if("Item"==u)for(d=0;d<n.length;d++)"Section"!==n[d].value&&"SubSection"!==n[d].value||(id=e[d].value,name=t[d].value,c+='<option value="'+id+'">'+name+"</option>");else if("SubItem"==u)for(d=0;d<n.length;d++)"Item"===n[d].value&&(id=e[d].value,name=t[d].value,c+='<option value="'+id+'">'+name+"</option>");$(i).empty().append(c),$(i).val(o),$("#"+e[s].id).css("background-color","white"),$("#"+t[s].id).css("background-color","white"),$("#"+n[s].id).css("background-color","white"),$("#"+r[s].id).css("background-color","white"),s<e.length-1?(""==e[s].value&&(console.log("#"+e[s].id),p=!0,$("#"+e[s].id).css("background-color","red")),""!=t[s].value&&" "!=t[s].value||(console.log("#"+t[s].id),p=!0,$("#"+t[s].id).css("background-color","yellow")),""==n[s].value&&(console.log("#"+n[s].id),p=!0,$("#"+n[s].id).css("background-color","red")),""==r[s].value&&(console.log("#"+r[s].id),p=!0,$("#"+r[s].id).css("background-color","red"))):s==e.length-1&&""!=t[s].value&&""!=e[s].value&&(""!=t[s].value&&" "!=t[s].value||(console.log("#"+t[s].id),p=!0),""==n[s].value&&(console.log("#"+n[s].id),p=!0),""==r[s].value&&(console.log("#"+r[s].id),p=!0)),""!=e[s].value&&(-1!==jQuery.inArray(e[s].value,a)?($("#"+e[s].id).css("background-color","red"),p=!0):-1<e[s].value.indexOf(" ")&&(p=!0,$("#"+e[s].id).css("background-color","red"))),""!=t[s].value&&(-1!==jQuery.inArray(t[s].value,l)&&($("#"+t[s].id).css("background-color","red"),p=!0)," "==t[s].value&&($("#"+t[s].id).css("background-color","red"),p=!0)),a[s]=e[s].value,l[s]=t[s].value}}u=function(){if(document.querySelector(".customFields_Type_select")){var e=document.querySelector(".customFields_Type_select").options;if(e){var t=new Array,n=0;for(var r in t[n]="Choose a type",n++,e)e[r].value&&""!=e[r].value&&(t[n]=e[r].value,n++);return t}}}(),(e=new Array).ID=new Array,e.ID.placeholder="author_name",e.ID.type="text",e.Name=new Array,e.Name.placeholder="Author Name",e.Name.type="text",e.Type=new Array,e.Type.placeholder="",e.Type.type="select",e.Parent=new Array,e.Parent.placeholder="parent_field",e.Parent.type="select",e.Show_in_columns=new Array,e.Show_in_columns.placeholder=!0,e.Show_in_columns.type="checkbox",e.add_remove_buttons=new Array,e.add_remove_buttons.placeholder=!0,e.add_remove_buttons.type="checkbox",e.add=new Array,e.add.class="dashicons dashicons-plus-alt add-substract-button customFields_addButton",e.add.type="button",e.remove=new Array,e.remove.class="dashicons dashicons-dismiss add-substract-button customFields_removeButton",e.remove.type="button",c=e,function(){for(var e=document.querySelectorAll(".customFields_title"),t=document.querySelectorAll(".customFields_input"),n=0;n<e.length;n++){var r="#"+t[n].id,a="#"+e[n].id;"SPAN"!=$(r)[0].tagName||($(r).css("display","inline-block"),$(r).css("text-align","center"),$(r).width("75px")),$(a).css("display","inline-block"),$(a).css("text-align","center"),$(a).css("word-wrap","break-word"),$(a).width($(r).outerWidth()+"px")}}(),d(),$("form").submit(function(e){if(console.log(p),p)h(),p&&e.preventDefault();else{var t=document.querySelectorAll(".customFields_ID_input"),n=t[t.length-1];if(""==n.value){console.log(n.id);var r=n.id.replace("ID_","");$("#customFields_container_"+r).remove()}}}),function(){for(var e=document.querySelectorAll(".customFields_input"),t=0;t<e.length;t++){var n="#"+e[t].id;"SPAN"==$(n)[0].tagName&&($(n).css("display","inline-block"),$(n).css("text-align","center"),$(n).width("75px"))}}(),h()}),jQuery(document).ready(function(r){r(document).on("click",".js-image-upload",function(e){e.preventDefault();var t=r(this),n=wp.media.frames.file_frame=wp.media({title:"Select or Upload an Image",library:{type:"image"},button:{text:"Select Image"},multiple:!1});n.on("select",function(){var e=n.state().get("selection").first().toJSON();t.siblings(".image-upload").val(e.url);e=n.state().get("selection").first().toJSON();t.siblings(".image-upload").val(e.url),r(".widget-control-save",".widget-control-actions").val("Save"),r(".widget-control-save",".widget-control-actions").attr("disabled",!1)}),n.open()})})},{"code-prettify":1}]},{},[2]);
//# sourceMappingURL=myscript.js.map
