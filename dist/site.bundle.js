/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ([
/* 0 */,
/* 1 */
/***/ (function(__unused_webpack_module, __unused_webpack_exports, __webpack_require__) {

__webpack_require__(2)(__webpack_require__(3))

/***/ }),
/* 2 */
/***/ (function(module) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/
module.exports = function(src) {
	function log(error) {
		(typeof console !== "undefined")
		&& (console.error || console.log)("[Script Loader]", error);
	}

	// Check for IE =< 8
	function isIE() {
		return typeof attachEvent !== "undefined" && typeof addEventListener === "undefined";
	}

	try {
		if (typeof execScript !== "undefined" && isIE()) {
			execScript(src);
		} else if (typeof eval !== "undefined") {
			eval.call(null, src);
		} else {
			log("EvalError: No eval function available");
		}
	} catch (error) {
		log(error);
	}
}


/***/ }),
/* 3 */
/***/ (function(module) {

module.exports = "(function(factory) {\r\n  // Establish the root object, `window` (`self`) in the browser, or `global` on the server.\r\n  // We use `self` instead of `window` for `WebWorker` support.\r\n  var root = (typeof self == 'object' && self.self === self && self) ||\r\n    (typeof global == 'object' && global.global === global && global);\r\n\r\n    // Set up animatedModal appropriately for the environment. Start with AMD.\r\n    if (typeof define === 'function' && define.amd) {\r\n      define(['underscore', 'jquery', 'exports'], function(_, $, exports) {\r\n        // Export global even in AMD case in case this script is loaded with\r\n        // others that may still expect a global animatedModal.\r\n        root.animatedModal = factory(root, $);\r\n      });\r\n\r\n      // Next for Node.js or CommonJS. jQuery may not be needed as a module.\r\n    } else if (typeof exports !== 'undefined') {\r\n      var _ = require('underscore'), $;\r\n      try { $ = require('jquery'); } catch (e) {}\r\n      factory(root, $);\r\n\r\n      // Finally, as a browser global.\r\n    } else {\r\n      root.$animatedModal = factory(root, (root.jQuery || root.Zepto || root.ender || root.$));\r\n    }\r\n})(function(window, $) {\r\n  $.fn.animatedModal = function(options) {\r\n    var modal = $(this),\r\n      currentContext = this;\r\n\r\n      //Defaults\r\n      var settings = $.extend({\r\n        modalTarget:'animatedModal',\r\n        position:'fixed',\r\n        width:'100%',\r\n        height:'100%',\r\n        top:'0px',\r\n        left:'0px',\r\n        zIndexIn: '9999',\r\n        zIndexOut: '-9999',\r\n        color: '#39BEB9',\r\n        opacityIn:'1',\r\n        opacityOut:'0',\r\n        animatedIn:'zoomIn',\r\n        animatedOut:'zoomOut',\r\n        animationDuration:'.6s',\r\n        overflow:'auto',\r\n        // Callbacks\r\n        beforeOpen: function() {},\r\n        afterOpen: function() {},\r\n        beforeClose: function() {},\r\n        afterClose: function() {}\r\n\r\n      }, options);\r\n\r\n      var closeBt = $('.close-'+settings.modalTarget);\r\n\r\n      ['beforeOpen', 'afterOpen', 'beforeClose', 'afterClose'].forEach(function(key) {\r\n        if (key in settings) {\r\n          settings[key] = settings[key].bind(this);\r\n        }\r\n      }, this);\r\n\r\n      var href = $(modal).attr('href')\r\n        , id = $('body').find('#'+settings.modalTarget)\r\n        , idConc = '#'+id.attr('id');\r\n\r\n      // Default Classes\r\n      id.addClass('animated');\r\n      id.addClass(settings.modalTarget+'-off');\r\n\r\n      //Init styles\r\n      var initStyles = {\r\n        'position':settings.position,\r\n        'width':settings.width,\r\n        'height':settings.height,\r\n        'top':settings.top,\r\n        'left':settings.left,\r\n        'background-color':settings.color,\r\n        'overflow-y':settings.overflow,\r\n        'z-index':settings.zIndexOut,\r\n        'opacity':settings.opacityOut,\r\n        '-webkit-animation-duration':settings.animationDuration,\r\n        '-moz-animation-duration':settings.animationDuration,\r\n        '-ms-animation-duration':settings.animationDuration,\r\n        'animation-duration':settings.animationDuration\r\n      };\r\n      //Apply styles\r\n      id.css(initStyles);\r\n\r\n      function openModal() {\r\n        $('body, html').css({'overflow':'hidden'});\r\n\r\n        if (href == idConc) {\r\n          if (id.hasClass(settings.modalTarget+'-off')) {\r\n            id.removeClass(settings.animatedOut);\r\n            id.removeClass(settings.modalTarget+'-off');\r\n            id.addClass(settings.modalTarget+'-on');\r\n          }\r\n\r\n          if (id.hasClass(settings.modalTarget+'-on')) {\r\n            settings.beforeOpen(id);\r\n            id.css({'opacity':settings.opacityIn,'z-index':settings.zIndexIn});\r\n            id.addClass(settings.animatedIn);\r\n            id.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', afterOpen);\r\n          }\r\n        }\r\n      }\r\n\r\n      function closeModal() {\r\n        $('body, html').css({'overflow':'auto'});\r\n\r\n        settings.beforeClose(id); //beforeClose\r\n        if (id.hasClass(settings.modalTarget+'-on')) {\r\n          id.removeClass(settings.modalTarget+'-on');\r\n          id.addClass(settings.modalTarget+'-off');\r\n        }\r\n\r\n        if (id.hasClass(settings.modalTarget+'-off')) {\r\n          id.removeClass(settings.animatedIn);\r\n          id.addClass(settings.animatedOut);\r\n          id.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', afterClose);\r\n        }\r\n      }\r\n\r\n      modal.click(function(e) {\r\n        if (e && e.preventDefault) {\r\n          e.preventDefault();\r\n        }\r\n        openModal();\r\n      });\r\n\r\n      closeBt.click(function(e) {\r\n        if (e && e.preventDefault) {\r\n          e.preventDefault();\r\n        }\r\n        closeModal();\r\n      });\r\n\r\n      function afterClose () {\r\n        id.css({'z-index':settings.zIndexOut});\r\n        settings.afterClose(id); //afterClose\r\n      }\r\n\r\n      function afterOpen () {\r\n        settings.afterOpen(id); //afterOpen\r\n      }\r\n\r\n      return {\r\n        open: openModal,\r\n        close: closeModal\r\n      };\r\n  }; // End animatedModal.js\r\n});\r\n"

/***/ }),
/* 4 */
/***/ (function(__unused_webpack_module, __unused_webpack_exports, __webpack_require__) {

__webpack_require__(2)(__webpack_require__(5))

/***/ }),
/* 5 */
/***/ (function(module) {

module.exports = "!function(){\"use strict\";if(\"undefined\"!=typeof window){var e=window.navigator.userAgent.match(/Edge\\/(\\d{2})\\./),t=e?parseInt(e[1],10):null,n=!!t&&(16<=t&&t<=18);if(!(\"objectFit\"in document.documentElement.style!=!1)||n){var o=function(e){var t=e.parentNode;!function(e){var t=window.getComputedStyle(e,null),i=t.getPropertyValue(\"position\"),n=t.getPropertyValue(\"overflow\"),o=t.getPropertyValue(\"display\");i&&\"static\"!==i||(e.style.position=\"relative\"),\"hidden\"!==n&&(e.style.overflow=\"hidden\"),o&&\"inline\"!==o||(e.style.display=\"block\"),0===e.clientHeight&&(e.style.height=\"100%\"),-1===e.className.indexOf(\"object-fit-polyfill\")&&(e.className=e.className+\" object-fit-polyfill\")}(t),function(e){var t=window.getComputedStyle(e,null),i={\"max-width\":\"none\",\"max-height\":\"none\",\"min-width\":\"0px\",\"min-height\":\"0px\",top:\"auto\",right:\"auto\",bottom:\"auto\",left:\"auto\",\"margin-top\":\"0px\",\"margin-right\":\"0px\",\"margin-bottom\":\"0px\",\"margin-left\":\"0px\"};for(var n in i)t.getPropertyValue(n)!==i[n]&&(e.style[n]=i[n])}(e),e.style.position=\"absolute\",e.style.height=\"100%\",e.style.width=\"auto\",e.clientWidth>t.clientWidth?(e.style.top=\"0\",e.style.marginTop=\"0\",e.style.left=\"50%\",e.style.marginLeft=e.clientWidth/-2+\"px\"):(e.style.width=\"100%\",e.style.height=\"auto\",e.style.left=\"0\",e.style.marginLeft=\"0\",e.style.top=\"50%\",e.style.marginTop=e.clientHeight/-2+\"px\")},i=function(e){if(void 0===e||e instanceof Event)e=document.querySelectorAll(\"[data-object-fit]\");else if(e&&e.nodeName)e=[e];else{if(\"object\"!=typeof e||!e.length||!e[0].nodeName)return!1;e=e}for(var t=0;t<e.length;t++)if(e[t].nodeName){var i=e[t].nodeName.toLowerCase();if(\"img\"===i){if(n)continue;e[t].complete?o(e[t]):e[t].addEventListener(\"load\",function(){o(this)})}else\"video\"===i?0<e[t].readyState?o(e[t]):e[t].addEventListener(\"loadedmetadata\",function(){o(this)}):o(e[t])}return!0};\"loading\"===document.readyState?document.addEventListener(\"DOMContentLoaded\",i):i(),window.addEventListener(\"resize\",i),window.objectFitPolyfill=i}else window.objectFitPolyfill=function(){return!1}}}();"

/***/ }),
/* 6 */
/***/ (function(__unused_webpack_module, __unused_webpack_exports, __webpack_require__) {

__webpack_require__(2)(__webpack_require__(7))

/***/ }),
/* 7 */
/***/ (function(module) {

module.exports = "/*\r\n * HC Off-canvas Nav\r\n * ===================\r\n * Version: 6.1.5\r\n * Author: Some Web Media\r\n * Author URL: https://github.com/somewebmedia/\r\n * Plugin URL: https://github.com/somewebmedia/hc-offcanvas-nav\r\n * Description: JavaScript library for creating off-canvas multi-level navigations\r\n * License: MIT\r\n */\r\n\"use strict\";!function(e,t){if(\"object\"==typeof module&&\"object\"==typeof module.exports){if(!e.document)throw new Error(\"HC Off-canvas Nav requires a browser to run.\");module.exports=t(e)}else\"function\"==typeof define&&define.amd?define(\"hcOffcanvasNav\",[],t(e)):t(e)}(\"undefined\"!=typeof window?window:this,function(re){function i(e,t){if(t=t||{},!(e=\"string\"==typeof e?\"#\"===e.charAt(0)&&-1===e.indexOf(\" \")?ie.querySelector(e):ie.querySelectorAll(e):e))return!1;var ee=i.Helpers;void 0!==t.maxWidth&&(ee.deprecated(\"maxWidth\",\"disableAt\",\"option\"),t.disableAt=t.maxWidth);var te=Object.assign({},{width:280,height:\"auto\",disableAt:!1,pushContent:null,swipeGestures:!0,expanded:!1,position:\"left\",levelOpen:\"overlap\",levelSpacing:40,levelTitles:!0,closeOpenLevels:!0,closeActiveLevel:!1,navTitle:null,navClass:\"\",disableBody:!0,closeOnClick:!0,closeOnEsc:!0,customToggle:null,activeToggleClass:null,bodyInsert:\"prepend\",keepClasses:!0,removeOriginalNav:!1,rtl:!1,insertClose:!0,insertBack:!0,levelTitleAsBack:!0,labelClose:\"\",labelBack:\"Back\"},t);function ne(e){if(ae.length){for(var t=!1,n=(e=\"string\"==typeof e?[e]:e).length,a=0;a<n;a++)-1!==ae.indexOf(e[a])&&(t=!0);return t}}function n(e){if(e.querySelector(\"ul\")||\"UL\"===e.tagName){var b=\"hc-nav-\"+ ++oe,s=ee.printStyle(\"hc-offcanvas-\"+oe+\"-style\"),o=\"keydown.hcOffcanvasNav\",v=te.activeToggleClass||\"toggle-open\",u=ee.createElement(\"nav\",{id:b}),d=ee.createElement(\"div\",{class:\"nav-container\"});u.addEventListener(\"click\",ee.stopPropagation),u.appendChild(d);var n,p,a,f=null,h=null,m=null,t={},g=!1,y=!1,E=null,L=0,A=0,x=0,C=null,O={},k=[],N=!1,T=[],r=null,i=null,l=!1,c=!1;te.customToggle?f=ee.getElements(te.customToggle):(f=[ee.createElement(\"a\",{href:\"#\"},ee.createElement(\"span\"))],e.insertAdjacentElement(\"afterend\",f[0])),f&&f.length&&f.forEach(function(e){e.addEventListener(\"click\",J(e)),e.classList.add(\"hc-nav-trigger\",b),e.setAttribute(\"role\",\"button\"),e.setAttribute(\"aria-label\",(te.ariaLabels||{}).open),e.setAttribute(\"aria-controls\",b),e.setAttribute(\"aria-expanded\",!1),e.addEventListener(\"keydown\",function(e){\"Enter\"!==e.key&&13!==e.keyCode||setTimeout(function(){w(0,0)},0)})});var w=function(e,t,n){var a,r,i,s;\"number\"!=typeof t||\"number\"!=typeof e&&!T.length||(a=Array.prototype.filter.call(d.querySelectorAll(\".nav-wrapper\"),function(e){return e.getAttribute(\"data-level\")==t&&(\"number\"!=typeof n||\"number\"==typeof n&&e.getAttribute(\"data-index\")==n)})[0],a=ee.children(a,\".nav-content\")[0],r=ee.children(a,\".nav-close, .nav-back\"),a=ee.children(a,\"ul\"),a=ee.children(a,\"li\"),a=ee.children(a,\":not(.nav-wrapper)\"),a=[].concat(r,a),a=Array.prototype.map.call(a,function(e){return Array.prototype.slice.call(e.querySelectorAll('[tabindex=\"0\"], a[role=\"menuitem\"], a[href], button, textarea, input[type=\"text\"], input[type=\"radio\"], input[type=\"checkbox\"], select'))}).flat(),(a=Array.prototype.filter.call(a,function(e){return\"-1\"!==e.getAttribute(\"tabindex\")}))&&(u.classList.add(\"user-is-tabbing\"),i=a[0],s=a[a.length-1],\"number\"==typeof e?a[e].focus():(T[T.length-1].focus(),T.pop()),ie.removeEventListener(o),ie.addEventListener(o,function(e){\"Tab\"!==e.key&&9!==e.keyCode||(e.shiftKey?ie.activeElement===i&&(e.preventDefault(),s.focus()):ie.activeElement===s&&(e.preventDefault(),i.focus()))})))},S=function(){ie.removeEventListener(o),h&&setTimeout(function(){h.focus()},p)},M=function(){d.style.transition=\"none\",u.style.display=\"block\";var e=ee.formatSizeVal(A=d.offsetWidth),t=ee.formatSizeVal(x=d.offsetHeight);s.add(\".hc-offcanvas-nav.\"+b+\".nav-position-left .nav-container\",\"transform: translate3d(-\"+e+\", 0, 0)\"),s.add(\".hc-offcanvas-nav.\"+b+\".nav-position-right .nav-container\",\"transform: translate3d(\"+e+\", 0, 0)\"),s.add(\".hc-offcanvas-nav.\"+b+\".nav-position-top .nav-container\",\"transform: translate3d(0, -\"+t+\", 0)\"),s.add(\".hc-offcanvas-nav.\"+b+\".nav-position-bottom .nav-container\",\"transform: translate3d(0, \"+t+\", 0)\"),s.insert(),u.style.display=\"\",d.style.transition=\"\",n=re.getComputedStyle(d).transitionProperty,p=ee.toMs(re.getComputedStyle(d).transitionDuration),a=re.getComputedStyle(d).transitionTimingFunction,te.pushContent&&m&&n&&s.add(ee.getElementCssTag(m),\"transition: \"+n+\" \"+p+\"ms \"+a),s.insert()},j=function(e){var t=!!f&&re.getComputedStyle(f[0]).display,n=!!te.disableAt&&\"max-width: \"+(te.disableAt-1)+\"px\",a=ee.formatSizeVal(te.width),r=ee.formatSizeVal(te.height),i=ee.formatSizeVal(te.levelSpacing);!ee.isNumeric(a)&&-1===a.indexOf(\"px\")||(A=parseInt(a)),!ee.isNumeric(r)&&-1===r.indexOf(\"px\")||(x=parseInt(r)),ne([\"disableAt\",\"position\"])&&s.reset(),s.add(\".hc-offcanvas-nav.\"+b,\"display: block\",n),s.add(\".hc-nav-original.\"+b,\"display: none\",n),t&&s.add(\".hc-nav-trigger.\"+b,\"display: \"+(t&&\"none\"!==t?t:\"block\"),n),-1!==[\"left\",\"right\"].indexOf(te.position)?s.add(\".hc-offcanvas-nav.\"+b+\" .nav-container\",\"width: \"+a):s.add(\".hc-offcanvas-nav.\"+b+\" .nav-container\",\"height: \"+r),s.add(\".hc-offcanvas-nav.\"+b+\".nav-position-left .nav-container\",\"transform: translate3d(-\"+a+\", 0, 0);\"),s.add(\".hc-offcanvas-nav.\"+b+\".nav-position-right .nav-container\",\"transform: translate3d(\"+a+\", 0, 0);\"),s.add(\".hc-offcanvas-nav.\"+b+\".nav-position-top .nav-container\",\"transform: translate3d(0, -\"+r+\", 0);\"),s.add(\".hc-offcanvas-nav.\"+b+\".nav-position-bottom .nav-container\",\"transform: translate3d(0, \"+r+\", 0);\"),s.add(\".hc-offcanvas-nav.\"+b+\".nav-levels-overlap.nav-position-left li.level-open > .nav-wrapper\",\"transform: translate3d(-\"+i+\", 0, 0)\",n),s.add(\".hc-offcanvas-nav.\"+b+\".nav-levels-overlap.nav-position-right li.level-open > .nav-wrapper\",\"transform: translate3d(\"+i+\", 0, 0)\",n),s.add(\".hc-offcanvas-nav.\"+b+\".nav-levels-overlap.nav-position-top li.level-open > .nav-wrapper\",\"transform: translate3d(0, -\"+i+\", 0)\",n),s.add(\".hc-offcanvas-nav.\"+b+\".nav-levels-overlap.nav-position-bottom li.level-open > .nav-wrapper\",\"transform: translate3d(0, \"+i+\", 0)\",n),s.insert(),e&&!ne(\"pushContent\")||(m=te.pushContent?ee.getElements(te.pushContent)[0]:null),d.style.transition=\"none\";n=u.classList.contains(le),n=[\"hc-offcanvas-nav\",te.navClass||\"\",b,\"nav-levels-\"+(te.levelOpen||\"none\"),\"nav-position-\"+te.position,te.disableBody?\"disable-body\":\"\",ee.isIos?\"is-ios\":\"\",ee.isTouchDevice?\"touch-device\":\"\",n?le:\"\",te.rtl?\"rtl\":\"\",!0!==te.insertClose||te.labelClose?\"\":\"nav-close-button-empty\"].join(\" \").trim().replace(/  +/g,\" \");u.removeEventListener(\"click\"),u.className=n,u.setAttribute(\"aria-hidden\",!0),ie.documentElement.style.setProperty(\"--nav-level-spacing\",te.levelSpacing+\"px\"),te.disableBody&&u.addEventListener(\"click\",$),e?M():setTimeout(M,0)},P=function(){t=function l(e,t){var n=[];Array.prototype.forEach.call(e,function(e){var o;(\"UL\"===e.tagName||e instanceof HTMLHeadingElement)&&(o={tagName:e.tagName,id:t,htmlClass:e.getAttribute(\"class\")||null,items:[]},e instanceof HTMLHeadingElement?o.content=ee.clone(e,!1,!0):(null!==e.getAttribute(\"data-nav-active\")&&(E=t,e.removeAttribute(\"data-nav-active\")),Array.prototype.forEach.call(e.children,function(e){var t=null!==e.getAttribute(\"data-nav-custom-content\"),n=t?e.childNodes:Array.prototype.filter.call(e.children,function(e){return\"UL\"!==e.tagName&&!e.querySelector(\"ul\")}).concat(e.children.length?[]:[e.firstChild]),a=t?[]:Array.prototype.slice.call(e.querySelectorAll(\"ul\")),r=a.length?[].concat(Array.prototype.filter.call(a[0].parentNode.children,function(e){return\"UL\"===e.tagName||e instanceof HTMLHeadingElement})):[],a=null;if(!n.length){for(var i=\"\",s=0;s<e.childNodes.length;s++)e.childNodes[s].nodeType===Node.TEXT_NODE&&(i+=e.childNodes[s].textContent.trim());n=[ie.createTextNode(i)]}r.length&&(ee.data(e,\"hc-uniqid\")?a=ee.data(e,\"hc-uniqid\"):(a=Math.random().toString(36).substr(2),ee.data(e,\"hc-uniqid\",a))),null!==e.getAttribute(\"data-nav-active\")&&(E=a,e.removeAttribute(\"data-nav-active\")),o.items.push({id:a,htmlClass:e.getAttribute(\"class\")||\"\",content:n,custom:t,subnav:r.length?l(r,a):[],highlight:null!==e.getAttribute(\"data-nav-highlight\")})})),n.push(o))});return n}(\"UL\"===e.tagName?[e]:Array.prototype.filter.call(e.children,function(e){return\"UL\"===e.tagName||e instanceof HTMLHeadingElement}),null)},_=function(e){if(e){for(;d.firstChild;)d.removeChild(d.firstChild);O={}}!function p(n,e,f,h,t,a){var m=ee.createElement(\"div\",{class:\"nav-wrapper nav-wrapper-\"+f,\"data-level\":f,\"data-index\":t||0});var r=ee.createElement(\"div\",{class:\"nav-content\"});m.addEventListener(\"click\",ee.stopPropagation);m.appendChild(r);e.appendChild(m);h&&(0===f||0<f&&\"overlap\"===te.levelOpen)&&(e=\"string\"==typeof h?h:ee.clone(re.jQuery&&h instanceof re.jQuery&&h.length?h[0]:h,!0,!0),r.insertBefore(ee.createElement(\"h2\",{id:0===f?b+\"-nav-title\":null,class:0===f?\"nav-title\":\"level-title\"},e),r.firstChild),0===f&&\"string\"==typeof h&&u.setAttribute(\"aria-labelledby\",b+\"-nav-title\"));var i=-1;n.forEach(function(e,t){var d;\"UL\"===e.tagName?(i++,d=ee.createElement(\"ul\",{id:e.id?1<n.length?\"menu-\"+e.id+\"-\"+i:\"menu-\"+e.id:null,role:\"menu\",\"aria-level\":f+1}),r.appendChild(d),te.keepClasses&&e.htmlClass&&d.classList.add.apply(d.classList,e.htmlClass.split(\" \")),e.items.forEach(function(t,e){var n=t.content;if(t.custom){var a=ee.createElement(\"li\",{class:\"nav-item nav-item-custom\"},ee.createElement(\"div\",{class:\"nav-custom-content\"},Array.prototype.map.call(n,function(e){return ee.clone(e,!0,!0)})));return te.keepClasses&&t.htmlClass&&a.classList.add.apply(a.classList,t.htmlClass.split(\" \")),void d.appendChild(a)}var r,i=Array.prototype.filter.call(n,function(e){return\"A\"===e.tagName||e.nodeType!==Node.TEXT_NODE&&e.querySelector(\"a\")})[0];i?(r=ee.clone(i,!1,!0)).classList.add(\"nav-item-link\"):r=ee.createElement(t.subnav.length?\"a\":\"span\",{class:\"nav-item-link\"},Array.prototype.map.call(n,function(e){return ee.clone(e,!0,!0)})),\"A\"===r.tagName&&(r.setAttribute(\"tabindex\",\"0\"),r.setAttribute(\"role\",\"menuitem\"),r.getAttribute(\"href\")||r.setAttribute(\"href\",\"#\")),i&&r.addEventListener(\"click\",function(e){e.stopPropagation(),ee.hasListener(i,\"click\")&&i.click()}),\"#\"===r.getAttribute(\"href\")&&r.addEventListener(\"click\",ee.preventDefault),te.closeOnClick&&(W()?\"A\"!==r.tagName||\"false\"===r.dataset.navClose||null!==r.getAttribute(\"disabled\")&&\"false\"!==r.getAttribute(\"disabled\")||t.subnav.length&&(!r.getAttribute(\"href\")||\"#\"===r.getAttribute(\"href\").charAt(0))||r.addEventListener(\"click\",$):\"A\"!==r.tagName||\"false\"===r.dataset.navClose||null!==r.getAttribute(\"disabled\")&&\"false\"!==r.getAttribute(\"disabled\")||r.addEventListener(\"click\",$));var s,o,l,c,v,u=ee.createElement(\"li\",{class:\"nav-item\"});u.appendChild(r),d.appendChild(u),te.keepClasses&&t.htmlClass&&u.classList.add.apply(u.classList,t.htmlClass.split(\" \")),t.highlight&&u.classList.add(\"nav-highlight\"),ee.wrap(r,ee.createElement(\"div\",{class:\"nav-item-wrapper\"})),t.subnav.length&&(s=f+1,o=t.id,l=\"\",O[s]||(O[s]=0),u.classList.add(\"nav-parent\"),W()?(c=O[s],(v=ee.createElement(\"input\",{type:\"checkbox\",id:b+\"-\"+s+\"-\"+c,class:\"hc-chk\",tabindex:-1,\"data-level\":s,\"data-index\":c,value:o})).addEventListener(\"click\",ee.stopPropagation),v.addEventListener(\"change\",Q),u.insertBefore(v,u.firstChild),a=function(e){e.addEventListener(\"click\",function(e){e.stopPropagation(),v.setAttribute(\"checked\",\"true\"!==v.getAttribute(\"checked\")),\"createEvent\"in ie&&((e=ie.createEvent(\"HTMLEvents\")).initEvent(\"change\",!1,!0),v.dispatchEvent(e))}),e.addEventListener(\"keydown\",function(e){\"Enter\"!==e.key&&13!==e.keyCode||(N=!0,T.push(this))}),e.setAttribute(\"aria-controls\",1<t.subnav.length?t.subnav.filter(function(e){return\"UL\"===e.tagName}).map(function(e,t){return\"menu-\"+e.id+\"-\"+t}).join(\" \"):\"menu-\"+o),e.setAttribute(\"aria-haspopup\",\"overlap\"===te.levelOpen),e.setAttribute(\"aria-expanded\",!1)},-1!==k.indexOf(o)&&(m.classList.add(\"sub-level-open\"),m.addEventListener(\"click\",function(){return Z(s,c)}),u.classList.add(\"level-open\"),v.setAttribute(\"checked\",!0)),l=!0===te.levelTitles?n[0].textContent.trim():\"\",r.getAttribute(\"href\")&&\"#\"!==r.getAttribute(\"href\")?((n=ee.createElement(\"a\",{href:\"#\",class:\"nav-next\",\"aria-label\":(te.ariaLabels||{}).submenu+\": \"+l,role:\"menuitem\",tabindex:0},ee.createElement(\"span\"))).addEventListener(\"click\",ee.preventClick()),a(n),te.rtl?r.parentNode.appendChild(n):r.parentNode.insertBefore(n,r.nextSibling)):(r.appendChild(ee.createElement(\"span\",{class:\"nav-next\"},ee.createElement(\"span\"))),a(r))):r.setAttribute(\"aria-expanded\",!0),O[s]++,p(t.subnav,u,s,l,O[s]-1,\"string\"==typeof h?h:\"\"))})):r.appendChild(e.content)});f&&void 0!==t&&!1!==te.insertBack&&\"overlap\"===te.levelOpen&&(s=ee.children(r,\"ul\"),a=te.levelTitleAsBack&&a||te.labelBack||\"\",l=ee.createElement(\"a\",{href:\"#\",class:\"nav-back-button\",role:\"menuitem\",tabindex:0},[a,ee.createElement(\"span\")]),!0===te.insertBack||0===te.insertBack?(a=ee.createElement(\"div\",{class:\"nav-back\"},l),r.insertBefore(a,ee.children(r,\":not(.level-title)\")[0])):(o=ee.createElement(\"li\",{class:\"nav-item nav-back\"},l),ee.insertAt(o,!0===te.insertBack?0:te.insertBack,s)),o=function(){return Z(f,t)},ee.wrap(l,ee.createElement(\"div\",{class:\"nav-item-wrapper\"})),l.addEventListener(\"click\",ee.preventClick(o)),l.addEventListener(\"keydown\",function(e){\"Enter\"!==e.key&&13!==e.keyCode||(N=!0)}));{var s,o,l;0===f&&!1!==te.insertClose&&((s=ee.createElement(\"a\",{href:\"#\",class:\"nav-close-button\"+(te.labelClose?\" has-label\":\"\"),role:\"menuitem\",tabindex:0,\"aria-label\":te.labelClose?\"\":(te.ariaLabels||{}).close},[te.labelClose||\"\",ee.createElement(\"span\")])).addEventListener(\"click\",ee.preventClick($)),s.addEventListener(\"keydown\",function(e){\"Enter\"!==e.key&&13!==e.keyCode||S()}),h&&!0===te.insertClose?r.insertBefore(ee.createElement(\"div\",{class:\"nav-close\"},s),r.children[1]):!0===te.insertClose?r.insertBefore(ee.createElement(\"div\",{class:\"nav-close\"},s),r.firstChild):(o=ee.children(r,\"ul\"),l=ee.createElement(\"li\",{class:\"nav-item nav-close\"},s),ee.wrap(s,ee.createElement(\"div\",{class:\"nav-item-wrapper\"})),ee.insertAt(l,te.insertClose,o)))}}(t,d,0,te.navTitle)},B=function(t){return function(e){\"left\"!==te.position&&\"right\"!==te.position||(r=e.touches[0].clientX,i=e.touches[0].clientY,\"doc\"===t?c||(ie.addEventListener(\"touchmove\",D,ee.supportsPassive),ie.addEventListener(\"touchend\",U,ee.supportsPassive)):(c=!0,d.addEventListener(\"touchmove\",z,ee.supportsPassive),d.addEventListener(\"touchend\",I,ee.supportsPassive)))}},q=function(e,t){re.addEventListener(\"touchmove\",ee.preventDefault,ee.supportsPassive),u.style.visibility=\"visible\",d.style[ee.browserPrefix(\"transition\")]=\"none\",ee.setTransform(d,e,te.position),m&&(m.style[ee.browserPrefix(\"transition\")]=\"none\",ee.setTransform(m,t,te.position))},H=function(e,t,n,a){void 0===t&&(t=!0),void 0===n&&(n=!1),void 0===a&&(a=!1),re.removeEventListener(\"touchmove\",ee.preventDefault,ee.supportsPassive),d.style[ee.browserPrefix(\"transition\")]=\"\",ee.setTransform(d,n,te.position),m&&(m.style[ee.browserPrefix(\"transition\")]=\"\",ee.setTransform(m,a,te.position)),\"open\"===e?K():($(),t?setTimeout(function(){u.style.visibility=\"\"},p):u.style.visibility=\"\")},D=function(e){var t=0-(r-e.touches[0].clientX),e=\"overlap\"===te.levelOpen?Y()*te.levelSpacing:0,e=A+e,t=\"left\"===te.position?Math.min(Math.max(t,0),e):Math.abs(Math.min(Math.max(t,-e),0));(\"left\"===te.position&&r<50||\"right\"===te.position&&r>ie.body.clientWidth-50)&&(l=!0,q(0-(A-t),Math.abs(t)))},U=function e(t){var n;ie.removeEventListener(\"touchmove\",D),ie.removeEventListener(\"touchend\",e),l&&(n=t.changedTouches[t.changedTouches.length-1],t=0-(r-n.clientX),n=\"overlap\"===te.levelOpen?Y()*te.levelSpacing:0,n=A+n,(t=\"left\"===te.position?Math.min(Math.max(t,0),n):Math.abs(Math.min(Math.max(t,-n),0)))?H(70<t?\"open\":\"close\"):H(\"close\",!1),i=r=null,l=!1)},z=function(e){var t=0-(r-e.touches[0].clientX),n=0-(i-e.touches[0].clientY);Math.abs(t)<Math.abs(n)||(e=\"overlap\"===te.levelOpen?Y()*te.levelSpacing:0,n=A+e,t=\"left\"===te.position?Math.min(Math.max(t,-n),0):Math.min(Math.max(t,0),n),(\"left\"===te.position&&t<0||\"right\"===te.position&&0<t)&&(l=!0,q(-Math.abs(t)+e,n-Math.abs(t))))},I=function e(t){var n,a;d.removeEventListener(\"touchmove\",z),d.removeEventListener(\"touchend\",e),c=!1,l&&(n=t.changedTouches[t.changedTouches.length-1],a=0-(r-n.clientX),t=\"overlap\"===te.levelOpen?Y()*te.levelSpacing:0,n=A+t,(a=\"left\"===te.position?Math.abs(Math.min(Math.max(a,-n),0)):Math.abs(Math.min(Math.max(a,0),n)))===n?H(\"close\",!1):50<a?H(\"close\"):H(\"open\",!0,t,n),i=r=null,l=!1)};j(),P(),_(),!0===te.removeOriginalNav?e.parentNode.removeChild(e):e.classList.add(\"hc-nav-original\",b),\"prepend\"===te.bodyInsert?ie.body.insertBefore(u,ie.body.firstChild):\"append\"===te.bodyInsert&&ie.body.appendChild(u),!0===te.expanded&&(y=!0,K()),te.swipeGestures&&(d.addEventListener(\"touchstart\",B(\"nav\"),ee.supportsPassive),ie.addEventListener(\"touchstart\",B(\"doc\"),ee.supportsPassive)),te.closeOnEsc&&ie.addEventListener(\"keydown\",function(e){!g||\"Escape\"!==e.key&&27!==e.keyCode||(0===(e=Y())?($(),S()):(Z(e,G()),w(null,e-1)))});B=ee.debounce(M,500);re.addEventListener(\"resize\",B,ee.supportsPassive);var X=function(e,t,n){var a,r,i=ie.querySelector(\"#\"+b+\"-\"+e+\"-\"+t);i&&(a=i.value,t=(r=i.parentNode).closest(\".nav-wrapper\"),i.setAttribute(\"checked\",!1),t.classList.remove(\"sub-level-open\"),r.classList.remove(\"level-open\"),r.querySelectorAll(\"[aria-controls]\")[0].setAttribute(\"aria-expanded\",!1),-1!==k.indexOf(a)&&k.splice(k.indexOf(a),1),n&&\"overlap\"===te.levelOpen&&(t.removeEventListener(\"click\"),t.addEventListener(\"click\",ee.stopPropagation),ee.setTransform(d,(e-1)*te.levelSpacing,te.position),m&&(t=\"x\"===ee.getAxis(te.position)?A:x,ee.setTransform(m,t+(e-1)*te.levelSpacing,te.position))))};return u.on=function(e,t){u.addEventListener(e,t)},u.off=function(e,t){u.removeEventListener(e,t)},u.getSettings=function(){return Object.assign({},te)},u.isOpen=F,u.open=K,u.close=$,u.toggle=J(null),u.update=function(e,t){if(ae=[],\"object\"==typeof e){for(var n in e)te[n]!==e[n]&&ae.push(n);te=Object.assign({},te,e)}!0===e||!0===t?te.removeOriginalNav?console.warn(\"%c! HC Offcanvas Nav:%c Can't update because original navigation has been removed. Disable `removeOriginalNav` option.\",\"color: #fa253b\",\"color: default\"):(j(!0),P(),_(!0)):(j(!0),_(!0))},u}function Q(){var e=Number(this.dataset.level),t=Number(this.dataset.index);(\"true\"===this.getAttribute(\"checked\")?R:Z)(e,t)}function V(e){e.classList.remove(v),e.setAttribute(\"aria-expanded\",!1)}function W(){return!1!==te.levelOpen&&\"none\"!==te.levelOpen}function F(){return g}function Y(){return k.length?Number(Array.prototype.filter.call(d.querySelectorAll(\".hc-chk\"),function(e){return e.value==k[k.length-1]})[0].dataset.level):0}function G(){return k.length?Number(Array.prototype.filter.call(d.querySelectorAll(\".hc-chk\"),function(e){return e.value==k[k.length-1]})[0].dataset.index):0}function K(e,t){var n,a;if((!g||void 0!==t)&&(g||(g=!0,u.style.visibility=\"visible\",u.setAttribute(\"aria-hidden\",!1),u.classList.add(le),f&&(f.forEach(V),h&&(h.classList.add(v),h.setAttribute(\"aria-expanded\",!0))),\"expand\"===te.levelOpen&&C&&clearTimeout(C),te.disableBody&&(L=re.pageYOffset||se.scrollTop||ie.documentElement.scrollTop||ie.body.scrollTop,ie.documentElement.scrollHeight>ie.documentElement.clientHeight&&se.classList.add(\"hc-nav-yscroll\"),ie.body.classList.add(\"hc-nav-open\"),L&&(ie.body.style.top=-L+\"px\")),m&&(n=\"x\"===ee.getAxis(te.position)?A:x,ee.setTransform(m,n,te.position)),y?y=!1:(u._eventListeners.toggle&&u._eventListeners.toggle.forEach(function(e){e.fn(ee.customEventObject(\"toggle\",u,u,{action:\"open\"}),Object.assign({},te))}),setTimeout(function(){u._eventListeners.open&&u._eventListeners.open.forEach(function(e){e.fn(ee.customEventObject(\"open\",u,u),Object.assign({},te))})},p))),W())){if(\"number\"!=typeof e&&!ee.isNumeric(e)||\"number\"!=typeof t&&!ee.isNumeric(t))E?(a=Array.prototype.filter.call(d.querySelectorAll(\".hc-chk\"),function(e){return e.value==E})[0],!te.closeActiveLevel&&te.closeOpenLevels||(E=null)):!1===te.closeOpenLevels&&(a=(a=Array.prototype.filter.call(d.querySelectorAll(\".hc-chk\"),function(e){return\"true\"===e.getAttribute(\"checked\")}))[a.length-1]);else if(!(a=ie.querySelector(\"#\"+b+\"-\"+e+\"-\"+t)))return void console.warn(\"HC Offcanvas Nav: level \"+e+\" doesn't have index \"+t);if(a){var r=[];if(e=Number(a.dataset.level),t=Number(a.dataset.index),1<e){for(var i=[];a&&a!==ie;a=a.parentNode)a.matches(\".nav-wrapper\")&&i.push(a);for(var s=0;s<i.length;s++){var o=i[s],l=Number(o.dataset.level);0<l&&r.push({level:l,index:Number(o.dataset.index)})}r=r.reverse()}r.push({level:e,index:t});for(var c=0;c<r.length;c++)R(r[c].level,r[c].index,!1)}}}function $(){var e;g&&(g=!1,m&&ee.setTransform(m,!1),u.classList.remove(le),u.classList.remove(\"user-is-tabbing\"),u.setAttribute(\"aria-hidden\",!0),d.removeAttribute(\"style\"),f&&f.forEach(V),\"expand\"===te.levelOpen&&-1!==[\"top\",\"bottom\"].indexOf(te.position)?Z(0):W()&&(C=setTimeout(function(){Z(0)},\"expand\"===te.levelOpen?p:0)),te.disableBody&&(ie.body.classList.remove(\"hc-nav-open\"),se.classList.remove(\"hc-nav-yscroll\"),L&&(ie.body.style.top=\"\",ie.body.scrollTop=L,se.scrollTop=L,\"bottom\"===te.position&&(e=L,setTimeout(function(){ie.body.scrollTop=e,se.scrollTop=e},0)),L=0)),u._eventListeners.toggle&&u._eventListeners.toggle.forEach(function(e){e.fn(ee.customEventObject(\"toggle\",u,u,{action:\"close\"}),Object.assign({},te))}),setTimeout(function(){u.style.visibility=\"\",u._eventListeners.close&&u._eventListeners.close.forEach(function(e){e.fn(ee.customEventObject(\"close\",u,u),Object.assign({},te))}),u._eventListeners[\"close.once\"]&&u._eventListeners[\"close.once\"].forEach(function(e){e.fn(ee.customEventObject(\"close.once\",u,u),Object.assign({},te))}),u.removeEventListener(\"close.once\")},p))}function J(t){return function(e){e&&(e.preventDefault(),e.stopPropagation()),t&&(h=t),(g?$:K)()}}function R(t,n,e){void 0===e&&(e=!0);var a=ie.querySelector(\"#\"+b+\"-\"+t+\"-\"+n),r=a.value,i=a.parentNode,s=i.closest(\".nav-wrapper\"),o=ee.children(i,\".nav-wrapper\")[0];!1===e&&(o.style.transition=\"none\"),a.setAttribute(\"checked\",!0),s.classList.add(\"sub-level-open\"),i.classList.add(\"level-open\"),i.querySelectorAll(\"[aria-controls]\")[0].setAttribute(\"aria-expanded\",!0),!1===e&&setTimeout(function(){o.style.transition=\"\"},p),-1===k.indexOf(r)&&k.push(r),\"overlap\"===te.levelOpen&&(s.addEventListener(\"click\",function(){return Z(t,n)}),ee.setTransform(d,t*te.levelSpacing,te.position),m&&(s=\"x\"===ee.getAxis(te.position)?A:x,ee.setTransform(m,s+t*te.levelSpacing,te.position))),u._eventListeners[\"open.level\"]&&u._eventListeners[\"open.level\"].forEach(function(e){e.fn(ee.customEventObject(\"open.level\",u,o,{currentLevel:t,currentIndex:n}),Object.assign({},te))}),N&&(w(0,t,n),N=!1)}function Z(t,e){for(var n,a=t;a<=Object.keys(O).length;a++)if(a===t&&void 0!==e)X(t,e,!0);else if(0!==t||te.closeOpenLevels)for(var r=0;r<O[a];r++)X(a,r,a===t);else;0<t&&u._eventListeners[\"close.level\"]&&(n=ie.querySelector(\"#\"+b+\"-\"+t+\"-\"+e).closest(\".nav-wrapper\"),u._eventListeners[\"close.level\"].forEach(function(e){e.fn(ee.customEventObject(\"close.level\",u,n,{currentLevel:t-1,currentIndex:G()}),Object.assign({},te))})),N&&(w(null,t-1),N=!1)}console.error(\"%c! HC Offcanvas Nav:%c Navigation must contain <ul> element.\",\"color: #fa253b\",\"color: default\")}te.ariaLabels=Object.assign({},{open:\"Open Menu\",close:\"Close Menu\",submenu:\"Submenu\"},t.ariaLabels);var ae=[];if(Array.isArray(e)||e instanceof NodeList){for(var a=[],r=0;r<e.length;r++)a.push(n(e[r]));return 1<a.length?a:a[0]}return n(e)}var n,a,ie=re.document,se=ie.getElementsByTagName(\"html\")[0],oe=0,le=\"nav-open\";return void 0!==re.jQuery&&(n=re.jQuery,a=\"hcOffcanvasNav\",n.fn.extend({hcOffcanvasNav:function(t){return this.length?this.each(function(){var e=n.data(this,a);e?e.update(t):(e=new i(this,t),n.data(this,a,e))}):this}})),re.hcOffcanvasNav=re.hcOffcanvasNav||i,i}),function(n){var e=n.hcOffcanvasNav,o=n.document;\"function\"!=typeof Object.assign&&Object.defineProperty(Object,\"assign\",{value:function(e,t){if(null==e)throw new TypeError(\"Cannot convert undefined or null to object\");for(var n=Object(e),a=1;a<arguments.length;a++){var r=arguments[a];if(null!=r)for(var i in r)Object.prototype.hasOwnProperty.call(r,i)&&(n[i]=r[i])}return n},writable:!0,configurable:!0}),Element.prototype.closest||(Element.prototype.closest=function(e){var t=this;do{if(Element.prototype.matches.call(t,e))return t}while(null!==(t=t.parentElement||t.parentNode)&&1===t.nodeType);return null}),Array.prototype.flat||Object.defineProperty(Array.prototype,\"flat\",{configurable:!0,value:function n(){var a=isNaN(arguments[0])?1:Number(arguments[0]);return a?Array.prototype.reduce.call(this,function(e,t){return Array.isArray(t)?e.push.apply(e,n.call(t,a-1)):e.push(t),e},[]):Array.prototype.slice.call(this)},writable:!0}),Element.prototype.matches||(Element.prototype.matches=Element.prototype.msMatchesSelector||Element.prototype.matchesSelector||Element.prototype.mozMatchesSelector||Element.prototype.oMatchesSelector||Element.prototype.webkitMatchesSelector);var t=!1;try{var a=Object.defineProperty({},\"passive\",{get:function(){t={passive:!1}}});n.addEventListener(\"testPassive\",null,a),n.removeEventListener(\"testPassive\",null,a)}catch(e){}function r(e){return!isNaN(parseFloat(e))&&isFinite(e)}function i(e){return\"auto\"===e?\"100%\":r(e)&&0!==e?e+\"px\":e}function s(e){var t=[\"Webkit\",\"Moz\",\"Ms\",\"O\"],n=(o.body||o.documentElement).style,a=e.charAt(0).toUpperCase()+e.slice(1);if(void 0!==n[e])return e;for(var r=0;r<t.length;r++)if(void 0!==n[t[r]+a])return t[r]+a;return!1}function l(e,t){if(e instanceof Element)return t?Array.prototype.filter.call(e.children,function(e){return e.matches(t)}):e.children;var n=[];return Array.prototype.forEach.call(e,function(e){n=t?n.concat(Array.prototype.filter.call(e.children,function(e){return e.matches(t)})):n.concat(Array.prototype.slice.call(e.children))}),n}var c=(/iPad|iPhone|iPod/.test(navigator.userAgent)||!!navigator.platform&&/iPad|iPhone|iPod/.test(navigator.platform))&&!n.MSStream,v=\"ontouchstart\"in n||navigator.maxTouchPoints||n.DocumentTouch&&o instanceof DocumentTouch,u=function(o){var l=Node.prototype[o+\"EventListener\"];return function(e,t,n){if(this){var a=e.split(\".\")[0];if(this._eventListeners=this._eventListeners||{},\"add\"===o){this._eventListeners[e]=this._eventListeners[e]||[];var r={fn:t};n&&(r.options=n),this._eventListeners[e].push(r),l.call(this,a,t,n)}else if(\"function\"==typeof t)for(var i in l.call(this,a,t,n),this._eventListeners)this._eventListeners[i]=this._eventListeners[i].filter(function(e){return e.fn!==t}),this._eventListeners[i].length||delete this._eventListeners[i];else if(this._eventListeners[e]){for(var s=this._eventListeners[e].length;s--;)l.call(this,a,this._eventListeners[e][s].fn,this._eventListeners[e][s].options),this._eventListeners[e].splice(s,1);this._eventListeners[e].length||delete this._eventListeners[e]}}}};Node.prototype.addEventListener=u(\"add\"),Node.prototype.removeEventListener=u(\"remove\");function d(e,t,n){void 0===t&&(t={});var a,r=o.createElement(e);for(a in t)\"class\"!==a?!t[a]&&0!==t[a]||r.setAttribute(a,t[a]):r.className=t[a];if(n){Array.isArray(n)||(n=[n]);for(var i=0;i<n.length;i++)if(\"object\"==typeof n[i]&&n[i].length&&!n[i].nodeType)for(var s=0;s<n[i].length;s++)r.appendChild(n[i][s]);else r.appendChild(\"string\"==typeof n[i]?o.createTextNode(n[i]):n[i])}return r}function p(e){return-1!==[\"left\",\"right\"].indexOf(e)?\"x\":\"y\"}a=function e(t){return\"string\"==typeof t?t:t.getAttribute(\"id\")?\"#\"+t.getAttribute(\"id\"):t.getAttribute(\"class\")?t.tagName.toLowerCase()+\".\"+t.getAttribute(\"class\").replace(/\\s+/g,\".\"):e(t.parentNode)+\" > \"+t.tagName.toLowerCase()},u=function(){s(\"transform\");return function(e,t,n){!1===t||\"\"===t?e.style.transform=\"\":\"x\"===p(n)?e.style.transform=\"translate3d(\"+i(\"left\"===n?t:-t)+\",0,0)\":e.style.transform=\"translate3d(0,\"+i(\"top\"===n?t:-t)+\",0)\"}}();e.Helpers={supportsPassive:t,isIos:c,isTouchDevice:v,isNumeric:r,formatSizeVal:i,toMs:function(e){return parseFloat(e)*(/\\ds$/.test(e)?1e3:1)},stopPropagation:function(e){return e.stopPropagation()},preventDefault:function(e){return e.preventDefault()},preventClick:function(t){return function(e){e.preventDefault(),e.stopPropagation(),\"function\"==typeof t&&t()}},browserPrefix:s,children:l,wrap:function(e,t){e.parentNode.insertBefore(t,e),t.appendChild(e)},data:function(e,t,n){if(e.hcOffcanvasNav=e.hcOffcanvasNav||{},void 0===n)return e.hcOffcanvasNav[t];e.hcOffcanvasNav[t]=n},clone:function(e,t,n){var a=e.cloneNode(n||!1),r=e instanceof Element?[e].concat(Array.prototype.slice.call(e.getElementsByTagName(\"*\"))):[],e=a instanceof Element?[a].concat(Array.prototype.slice.call(a.getElementsByTagName(\"*\"))):[];return t||(r.shift(),e.shift()),n&&function(e,t){for(var n=0;n<e.length;n++)if(e[n]._eventListeners)for(var a in e[n]._eventListeners)for(var r=0;r<e[n]._eventListeners[a].length;r++)t[r].addEventListener(a,e[n]._eventListeners[a][r].fn,e[n]._eventListeners[a][r].options)}(r,e),a},customEventObject:function(e,n,a,r){return new function(e){for(var t in this.bubbles=!1,this.cancelable=!1,this.composed=!1,this.currentTarget=a,this.data=r?{}:null,this.defaultPrevented=!1,this.eventPhase=0,this.isTrusted=!1,this.target=n,this.timeStamp=Date.now(),this.type=e,r)this.data[t]=r[t]}(e)},hasListener:function(e,t){return(t?(e._eventListeners||{})[t]:e._eventListeners)||!1},debounce:function(a,r,i){var s;return function(){var e=this,t=arguments,n=i&&!s;clearTimeout(s),s=setTimeout(function(){s=null,i||a.apply(e,t)},r),n&&a.apply(e,t)}},createElement:d,getElements:function(e){var t=null;return\"string\"==typeof e?t=o.querySelectorAll(e):n.jQuery&&e instanceof n.jQuery&&e.length?t=e.toArray():e instanceof Element&&(t=[e]),t},getElementCssTag:a,printStyle:function(e){var r=d(\"style\",{id:e}),i={},s={};o.head.appendChild(r);function a(e){return\";\"!==e.substr(-1)&&(e+=\";\"!==e.substr(-1)?\";\":\"\"),e}return{reset:function(){i={},s={}},add:function(e,t,n){e=e.trim(),t=t.trim(),n?(n=n.trim(),s[n]=s[n]||{},s[n][e]=a(t)):i[e]=a(t)},remove:function(e,t){e=e.trim(),t?(t=t.trim(),void 0!==s[t][e]&&delete s[t][e]):void 0!==i[e]&&delete i[e]},insert:function(){var e,t,n=\"\";for(e in s){for(var a in n+=\"@media screen and (\"+e+\") {\\n\",s[e])n+=\"  \"+a+\" { \"+s[e][a]+\" }\\n\";n+=\"}\\n\"}for(t in i)n+=t+\" { \"+i[t]+\" }\\n\";r.innerHTML=n}}},insertAt:function(e,t,n){var a=l(n),r=a.length,r=-1<(t=\"last\"===(t=\"first\"===t?0:t)?r:t)?Math.max(0,Math.min(t,r)):Math.max(0,Math.min(r+t,r));0===r?n[0].insertBefore(e,n[0].firstChild):a[r-1].insertAdjacentElement(\"afterend\",e)},getAxis:p,setTransform:u,deprecated:function(e,t,n){console.warn(\"%cHC Off-canvas Nav:%c \"+n+\"%c '\"+e+\"'%c is now deprecated and will be removed in the future. Use%c '\"+t+\"'%c option instead. See details about plugin usage at https://github.com/somewebmedia/hc-offcanvas-nav.\",\"color: #fa253b\",\"color: default\",\"color: #5595c6\",\"color: default\",\"color: #5595c6\",\"color: default\")}}}(window);"

/***/ }),
/* 8 */
/***/ (function() {

/**
 * GutenDevTheme scripts (footer)
 * This file contains any js scripts you want added to the theme's footer. 
 */

// *********************** START CUSTOM JS *********************************

// // grab element for Headroom
// var headroomElement = document.querySelector("#c-page-header");
// console.log(headroomElement);

// // get height of element for Headroom
// var headerHeight = headroomElement.offsetHeight; 
// console.log(headerHeight);

// // construct an instance of Headroom, passing the element
// var headroom = new Headroom(headroomElement, {
//   "offset": headerHeight,
//   "tolerance": 5,
//   "classes": {
//     "initial": "animate__animated",
//     "pinned": "animate__slideInDown",
//     "unpinned": "animate__slideOutUp"
//   }
// });
// headroom.init();

// mobile footer menus
document.addEventListener('DOMContentLoaded', function() {
  var menus = document.querySelectorAll('.c-footer-nav'); 
  menus.forEach(function(menu) {
      var firstLinkText = menu.querySelector('li a').textContent;
      var title = document.createElement('a');
      title.innerHTML = firstLinkText + ' <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M11.178 19.569a.998.998 0 0 0 1.644 0l9-13A.999.999 0 0 0 21 5H3a1.002 1.002 0 0 0-.822 1.569l9 13z"/></svg>';
      title.className = 'menu-title';
      menu.parentNode.insertBefore(title, menu);

      title.addEventListener('click', function() {
          if (menu.style.display === 'block') {
              menu.style.display = 'none';
              title.classList.remove('active');
          } else {
              menu.style.display = 'block';
              title.classList.add('active');
          }
      });
  });
});



document.addEventListener('DOMContentLoaded', function() {
    // Select all menu items that have mega menus and are click-triggered
    const megaMenuItems = document.querySelectorAll('.has-mega-menu[data-trigger-type="click"]');

    megaMenuItems.forEach(item => {
        const button = item.querySelector('button');
        const megaMenuContent = item.querySelector('.mega-menu__content');

        if (button && megaMenuContent) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Close other open mega menus
                document.querySelectorAll('.has-mega-menu.is-active').forEach(activeItem => {
                    if (activeItem !== item) {
                        activeItem.classList.remove('is-active');
                        const activeButton = activeItem.querySelector('button');
                        const activeContent = activeItem.querySelector('.mega-menu__content');
                        activeButton.setAttribute('aria-expanded', 'false');
                        activeContent.classList.remove('is-active');
                        activeContent.setAttribute('aria-hidden', 'true');
                    }
                });

                // Toggle current mega menu
                const isExpanded = button.getAttribute('aria-expanded') === 'true';
                button.setAttribute('aria-expanded', !isExpanded);
                megaMenuContent.setAttribute('aria-hidden', isExpanded);
                item.classList.toggle('is-active');
                megaMenuContent.classList.toggle('is-active'); // Add this line to toggle is-active on content

            });

            // Close mega menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!item.contains(e.target)) {
                    item.classList.remove('is-active');
                    megaMenuContent.classList.remove('is-active'); // Add this line
                    button.setAttribute('aria-expanded', 'false');
                    megaMenuContent.setAttribute('aria-hidden', 'true');
                }
            });
        }
    });

    // Handle escape key
    document.addEventListener('keyup', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.has-mega-menu.is-active').forEach(item => {
                item.classList.remove('is-active');
                const button = item.querySelector('button');
                const content = item.querySelector('.mega-menu__content');
                button.setAttribute('aria-expanded', 'false');
                content.classList.remove('is-active'); // Add this line
                content.setAttribute('aria-hidden', 'true');
            });
        }
    });
});

// document.addEventListener('DOMContentLoaded', function() {
//     var menus = document.querySelectorAll('.c-footer-nav');

//     menus.forEach(function(menu) {
//         var title = document.createElement('li');
//         title.classList.add('menu-title');
//         title.innerText = 'Menu Title'; // Replace with your desired title

//         title.addEventListener('click', function() {
//             menu.classList.toggle('active');
//         });

//         menu.insertBefore(title, menu.firstChild);
//     });
// });

// sticky header
window.onscroll = function() {
  var header = document.getElementById('c-page-header');
  if (window.pageYOffset > 200) {
      header.classList.add('sticky');
  } else {
      header.classList.remove('sticky');
  }
};

// blog pagination
window.onload = function() {
  var navLinks = document.querySelectorAll('.c-post-nav a');
  navLinks.forEach(function(link) {
    link.href += '#c-main-posts';
  });
};

// number counter
document.addEventListener('DOMContentLoaded', function() {
  var observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
          if (entry.isIntersecting) {
              var number = entry.target;
              var toNumber = parseInt(number.innerHTML.replace(/\D/g, ''), 10);
              var suffix = number.innerHTML.replace(/[0-9]/g, '');
              var prefix = '', postfix = '';

              if (number.innerHTML.indexOf(suffix) === 0) {
                  prefix = suffix;
              } else {
                  postfix = suffix;
              }

              var currentNumber = 0;
              var interval = setInterval(function() {
                  if (currentNumber < toNumber) {
                      currentNumber++;
                      number.textContent = prefix + currentNumber + postfix;
                  } else {
                      clearInterval(interval);
                  }
              }, 10);

              observer.unobserve(number);
          }
      });
  });

  var counters = document.querySelectorAll('.number-counter');
  counters.forEach(function(counter) {
      observer.observe(counter);
  });
});


document.addEventListener('DOMContentLoaded', function() {
    const searchTrigger = document.getElementById('search-trigger');
    const searchPopup = document.getElementById('search-popup');
    const closeButton = document.querySelector('.close');
    const searchInput = searchPopup.querySelector('input[type="search"]');
    const submitButton = searchPopup.querySelector('input[type="submit"]');
    const documentationLink = searchPopup.querySelector('a[href*="docs.plixer.com"]');

    // Create array of focusable elements
    const getFocusableElements = () => {
        return [searchInput, submitButton, documentationLink, closeButton].filter(Boolean);
    };

    // Function to handle tab key navigation
    function handleTabKey(e) {
        if (!searchPopup.classList.contains('active')) return;

        const focusableElements = getFocusableElements();
        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];
        const activeElement = document.activeElement;

        // If Shift + Tab
        if (e.shiftKey) {
            if (activeElement === firstElement) {
                e.preventDefault();
                lastElement.focus();
            }
        } 
        // If just Tab
        else {
            if (activeElement === lastElement) {
                e.preventDefault();
                firstElement.focus();
            }
        }
    }

    if (searchTrigger && searchPopup) {
        // Handle both click and keyboard events for search trigger
        searchTrigger.addEventListener('click', openSearch);
        searchTrigger.addEventListener('keydown', function(event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                openSearch(event);
            }
        });

        // Handle keyboard navigation
        document.addEventListener('keydown', function(event) {
            if (searchPopup.classList.contains('active')) {
                if (event.key === 'Tab') {
                    handleTabKey(event);
                }
                if (event.key === 'Escape') {
                    closeSearch(event);
                }
            }
        });

        if (closeButton) {
            closeButton.addEventListener('click', closeSearch);
            closeButton.addEventListener('keydown', function(event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    closeSearch(event);
                }
            });
        }

        // Add click outside functionality
        document.addEventListener('click', function(event) {
            if (searchPopup.classList.contains('active') && 
                !searchPopup.contains(event.target) && 
                !searchTrigger.contains(event.target)) {
                closeSearch(event);
            }
        });
    }

    function openSearch(event) {
        if (event) event.preventDefault();
        searchPopup.classList.add('active');
        
        // Set ARIA attributes
        searchPopup.setAttribute('aria-hidden', 'false');
        searchTrigger.setAttribute('aria-expanded', 'true');
        
        // Focus the search input after a brief delay
        setTimeout(() => {
            searchInput.focus();
        }, 100);
    }

    function closeSearch(event) {
        if (event) event.preventDefault();
        searchPopup.classList.remove('active');
        
        // Reset ARIA attributes
        searchPopup.setAttribute('aria-hidden', 'true');
        searchTrigger.setAttribute('aria-expanded', 'false');
        
        // Return focus to search trigger
        searchTrigger.focus();
    }
});



// Fixed Bar Functionality
document.addEventListener('DOMContentLoaded', function() {
  const fixedBar = document.querySelector('.c-fixed-bar');
  const closeBtn = document.querySelector('.c-fixed-bar-close');
  
  if (fixedBar && closeBtn) {
    closeBtn.addEventListener('click', function() {
      fixedBar.style.display = 'none';
      document.body.classList.add('fixed-bar-closed');
      

    });
    

  }
});




// Info popup script
document.addEventListener('DOMContentLoaded', function() {
    var popupTrigger = document.getElementById('info-popup-trigger');
    var popup = document.getElementById('info-popup');
    var closeButton = document.querySelector('.c-info-popup-close');

    // Only proceed if all required elements exist
    if (!popupTrigger || !popup || !closeButton) {
        // Exit early if any required elements are missing
        return;
    }

    // Function to get a cookie by name
    function getCookie(name) {
        var value = "; " + document.cookie;
        var parts = value.split("; " + name + "=");
        if (parts.length == 2) return parts.pop().split(";").shift();
    }

    // Function to set a cookie
    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    // Function to close the popup and set the cookie
    function closePopup() {
        popup.classList.add('is-closing');
        setTimeout(function() {
            popup.classList.remove('is-visible', 'is-closing');
            popup.setAttribute('aria-hidden', 'true');
            popupTrigger.setAttribute('aria-expanded', 'false');
            setCookie('infoPopupClosed', 'true', 0); // Session cookie
        }, 300); // Match the duration of the slideOut animation
    }

    // Check if the popup should be shown
    if (!getCookie('infoPopupClosed')) {
        setTimeout(function() {
            if (popup) { // Additional check before showing
                popup.classList.add('is-visible');
                popup.setAttribute('aria-hidden', 'false');
                popupTrigger.setAttribute('aria-expanded', 'true');
            }
        }, 2000);
    }

    // Event listener to close the popup with the close button
    closeButton.addEventListener('click', closePopup);

    // Event listener to toggle the popup with the trigger
    popupTrigger.addEventListener('click', function() {
        if (popup.classList.contains('is-visible')) {
            closePopup();
        } else {
            popup.classList.add('is-visible');
            popup.setAttribute('aria-hidden', 'false');
            popupTrigger.setAttribute('aria-expanded', 'true');
        }
    });
});

// end info popup script


// external link accessibility script
class AccessibilityEnhancer {
    constructor() {
        this.newTabText = '(Opens in a new tab)';
        this.externalLinkText = '(External link)';
        this.pdfText = '(PDF file)'; 
    }
  
    enhanceLinks() {
        const links = document.querySelectorAll('a');
        
        links.forEach(link => {
            this.enhanceSingleLink(link);
        });
    }
  
    enhanceSingleLink(link) {
      const isNewTab = link.target === '_blank' || link.target === 'blank';
      const isExternal = this.isExternalLink(link);
      const isPDF = this.isPDFLink(link); // Add this line
      const existingLabel = link.getAttribute('aria-label');
      const linkText = link.textContent || link.innerText;
      
      let newLabel = existingLabel || linkText;
  
      // Add appropriate notices
      if (isNewTab && !newLabel.includes(this.newTabText)) {
          newLabel += ` ${this.newTabText}`;
      }
      if (isExternal && !newLabel.includes(this.externalLinkText)) {
          newLabel += ` ${this.externalLinkText}`;
      }
      if (isPDF && !newLabel.includes(this.pdfText)) { // Add this block
          newLabel += ` ${this.pdfText}`;
      }
  
        // Set the enhanced label
        if (newLabel !== linkText) {
            link.setAttribute('aria-label', newLabel.trim());
        }
  
        // Add security attributes for external links
        if (isNewTab || isExternal) {
            const rel = 'noopener noreferrer';
            const currentRel = link.getAttribute('rel');
            if (!currentRel || !currentRel.includes(rel)) {
                link.setAttribute('rel', rel);
            }
        }
    }
  
    isExternalLink(link) {
        if (!link.href) return false;
        
        const currentDomain = window.location.hostname;
        try {
            const linkDomain = new URL(link.href).hostname;
            return linkDomain !== currentDomain;
        } catch (e) {
            return false;
        }
    }
  
    isPDFLink(link) {
        if (!link.href) return false;
        
        // Check if the URL ends with .pdf
        if (link.href.toLowerCase().endsWith('.pdf')) return true;
        
        // Check if the MIME type is available and is PDF
        if (link.type && link.type.toLowerCase() === 'application/pdf') return true;
        
        // Check if the download attribute exists and the file ends with .pdf
        if (link.hasAttribute('download')) {
            const downloadValue = link.getAttribute('download');
            if (downloadValue && downloadValue.toLowerCase().endsWith('.pdf')) return true;
        }
        
        return false;
    }
    
  
    // Method to handle dynamically added content
    observe() {
        const observer = new MutationObserver((mutations) => {
            mutations.forEach(mutation => {
                mutation.addedNodes.forEach(node => {
                    if (node.nodeType === 1) { // ELEMENT_NODE
                        // Check the added element itself
                        if (node.tagName === 'A') {
                            this.enhanceSingleLink(node);
                        }
                        // Check for links within the added element
                        const links = node.querySelectorAll('a');
                        links.forEach(link => this.enhanceSingleLink(link));
                    }
                });
            });
        });
  
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }
  }
  
  // Usage
  const accessibilityEnhancer = new AccessibilityEnhancer();
  
  document.addEventListener('DOMContentLoaded', () => {
    accessibilityEnhancer.enhanceLinks();
    accessibilityEnhancer.observe(); // Optional: observe for dynamic content
  });
  // END external link accessibility script


document.addEventListener('DOMContentLoaded', function() { 
    const dropdownButtons = document.querySelectorAll('.dropdown-toggle');
    
    function closeAllSubmenus() {
        dropdownButtons.forEach(button => {
            button.setAttribute('aria-expanded', 'false');
            const submenu = button.parentElement.querySelector('ul');
            if (submenu) {
                submenu.classList.remove('is-active');
            }
        });
    }
    
    dropdownButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            // If menu is already open, just close it
            if (isExpanded) {
                this.setAttribute('aria-expanded', false);
                const submenu = this.parentElement.querySelector('ul');
                if (submenu) {
                    submenu.classList.remove('is-active');
                }
                return;
            }
            
            // Close all submenus first
            closeAllSubmenus();
            
            // Then open the clicked submenu
            this.setAttribute('aria-expanded', true);
            const submenu = this.parentElement.querySelector('ul');
            if (submenu) {
                submenu.classList.add('is-active');
            }
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.menu-item-has-children')) {
            closeAllSubmenus();
        }
    });
});



// Video source enhancement for page-id-64562
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on the specific page
    if (document.body.classList.contains('page-id-64562')) {
        const videoPlayerDiv = document.querySelector('.video_player72c2_64562');
        
        if (videoPlayerDiv) {
            const videoElement = videoPlayerDiv.querySelector('video');
            
            if (videoElement) {
                // Check if MOV source already exists
                const existingMovSource = videoElement.querySelector('source[src*=".mov"]');
                
                if (!existingMovSource) {
                    // Find the existing webm source
                    const webmSource = videoElement.querySelector('source[src*="Srutinizer-AI-prompt-copy-vp9-chrome.webm"]');
                    
                    if (webmSource) {
                        // Create MOV source element
                        const movSource = document.createElement('source');
                        movSource.src = webmSource.src.replace('.webm', '.mov');
                        movSource.type = 'video/quicktime';
                        
                        // Insert MOV source before the webm source (MOV as fallback)
                        videoElement.insertBefore(movSource, webmSource);
                    }
                }
            }
        }
    }
});

// *********************** END CUSTOM JS *********************************

// *********************** START CUSTOM JQUERY DOC READY SCRIPTS *******************************
jQuery( document ).ready(function( $ ) {

   // get Template URL
   var templateUrl = object_name.templateUrl;
   

$('#mobile-nav').hcOffcanvasNav({
    disableAt: 1165,
    width: 580,
    customToggle: $('.toggle'),
    pushContent: '.menu-slide',
    levelTitles: true,
    position: 'right',
    levelOpen: 'expand',
    navTitle: $('<div class="c-mobile-menu-header"><a href="/">' + 
        '<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 360 85.61">' +
        '<path class="cls-1" d="M85.44,85.59c-7.33,0-12.47-3.06-12.47-12.84V.02h16.14v66.62c0,4.89,1.22,6.11,6.11,6.11h31.29v12.84h-41.07Z"/>' +
        '<path class="cls-1" d="M133.84,85.59V.02h16.14v85.57h-16.14Z"/>' +
        '<path class="cls-1" d="M206.86,85.59l-15.52-30.8-15.52,30.8h-19.19l24.33-43.39L157.6.02h19.19l14.55,29.58L205.89.02h19.19l-23.35,42.17,24.33,43.39h-19.19Z"/>' +
        '<path class="cls-1" d="M284.56,85.59h-41.44c-7.33,0-12.47-3.06-12.47-12.84V12.86C230.65,3.08,235.78.02,243.12.02h40.95v12.83h-31.17c-3.38,0-6.11,2.74-6.11,6.11v16.5h36.06v12.83h-36.06v18.34c0,3.38,2.74,6.11,6.11,6.11h31.66v12.84Z"/>' +
        '<path class="cls-1" d="M44.68,55.27h1.22c13.08,0,18.89-10.64,18.89-28.24S59.29.02,43.39.02H12.47C5.13.02,0,3.08,0,12.86v72.73h16.14V18.97c0-3.38,2.74-6.11,6.11-6.11h13.81c10.27,0,12.1,4.4,12.1,14.18s-1.34,15.77-10.27,15.77H7.03c-2.47,0-3.94,2.77-2.54,4.82l3.71,5.42c.96,1.4,2.54,2.23,4.23,2.23h32.24Z"/>' +
        '<path class="cls-1" d="M338.57,55.88v-.61h1.22c13.08,0,18.5-10.64,18.5-28.24S352.79.02,336.9.02h-30.93c-7.33,0-12.47,3.06-12.47,12.83v72.73h16.14V18.97c0-3.38,2.74-6.11,6.11-6.11h13.81c10.27,0,12.1,4.4,12.1,14.18s-1.34,15.77-10.27,15.77h-14.06c-2.47,0-3.94,2.77-2.54,4.82l7.18,9.24c.2.33.42.65.64.98l5.38,7.83,14.15,19.92h17.85l-21.43-29.7Z"/>' +
        '</svg></a></div>'),
    levelTitleAsBack: true
});







  

  // modal menu init ----------------------------------
  // var modal_menu = jQuery("#c-modal-nav-button").animatedModal({
  //   modalTarget: 'modal-navigation',
  //   animatedIn: 'slideInDown',
  //   animatedOut: 'slideOutUp',
  //   animationDuration: '0.40s',
  //   color: '#dedede',
  //   afterClose: function() {
  //     $( 'body, html' ).css({ 'overflow': '' });
  //   }
  // });

  // // get last and current hash + update on hash change
  // var currentHash = function() {
  //   return location.hash.replace(/^#/, '')
  // }
  // var last_hash
  // var hash = currentHash()
  // $(window).bind('hashchange', function(event) {
  //   last_hash = hash;
  //   hash = currentHash();
  // });

  // enable back/foward to close/open modal --------------------------
  // $("#c-modal-nav-button").on('click', function(){ window.location.href = ensureHash("#menu"); });
  // function ensureHash(newHash) {
  //   if (window.location.hash) {
  //     return window.location.href.substring(0, window.location.href.lastIndexOf(window.location.hash)) + newHash;
  //   }
  //   return window.location.hash + newHash;
  // }
  // // if back button is pressed, close the modal
  // $(window).on('hashchange', function (event) {
  //   if (last_hash == 'menu' && hash == '') {
  //     modal_menu.close();
  //     history.replaceState('', document.title, window.location.pathname);
  //   } // if forward button, open the modal
  //   else if (window.location.hash == "#menu"){
  //     modal_menu.open();
  //   }
  // });

  // // if close button is clicked, clear the #menu hash added above
  // $('.close-modal-navigation').on('click', function (e) {
  //   history.replaceState('', document.title, window.location.pathname);
  // });

  // // close modal menu if esc key is used ------------------------
  // $(document).keyup(function(ev){
  //   if(ev.keyCode == 27 && hash == 'menu') {
  //     window.history.back();
  //   }
  // });


  // Magnific as menu popup
  // MENU POPUP
  // $('#c-modal-nav-button').magnificPopup({
  //   type: 'inline',
  //   removalDelay: 700, //delay removal by X to allow out-animation
  //   showCloseBtn: false,
  //   closeOnBgClick: false,
  //   autoFocusLast: false,
  //   fixedContentPos: false, 
  //   fixedContentPos: true,
  //   callbacks: {
  //     beforeOpen: function() {
  //        this.st.mainClass = 'mfp-move-from-side menu-popup';
  //        $('body').addClass('mfp-active');
  //     },
  //     open: function() { 
  //       $('#close-modal, .close-modal-navigation').on('click',function(event){
  //         event.preventDefault();
  //         $.magnificPopup.close(); 
  //       }); 
  //   },
  //   beforeClose: function() {
  //   $('body').removeClass('mfp-active');
  // }
  //   },
  //   midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
  // });

});
// *********************** END CUSTOM JQUERY DOC READY SCRIPTS *********************************


/***/ })
/******/ 	]);
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
!function() {
// plugin scripts *****************************
__webpack_require__(1); 
__webpack_require__(4);
// require('script-loader!./js/jquery-accessibleMegaMenu.js');
__webpack_require__(6);
// require('script-loader!../node_modules/aos/dist/aos.js'); 

// require('script-loader!../node_modules/headroom.js/dist/headroom.js');
// require('script-loader!../node_modules/magnific-popup/dist/jquery.magnific-popup.js'); 
// require('script-loader!../node_modules/slick-carousel/slick/slick');
 
 
// custom scripts **************************
// NOTE: enable below if you have DROP DOWN MAIN MENU + UPDATE CLASSES AS NEED BE
// require('./js/touch-navigation');
__webpack_require__(8); 

}();
/******/ })()
;