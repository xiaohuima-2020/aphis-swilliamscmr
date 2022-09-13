/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "drupal":
/*!*************************!*\
  !*** external "Drupal" ***!
  \*************************/
/***/ (function(module) {

module.exports = Drupal;

/***/ })

/******/ 	});
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
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
!function() {
/*!*************************************************************!*\
  !*** ./source/04-components/back-to-top/back-to-top.es6.ts ***!
  \*************************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var drupal__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! drupal */ "drupal");
/* harmony import */ var drupal__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(drupal__WEBPACK_IMPORTED_MODULE_0__);

(drupal__WEBPACK_IMPORTED_MODULE_0___default().behaviors.backToTop) = {
    attach(context, settings) {
        var _a, _b, _c, _d;
        const threshold = (_b = (_a = settings === null || settings === void 0 ? void 0 : settings.gesso) === null || _a === void 0 ? void 0 : _a.backToTopThreshold) !== null && _b !== void 0 ? _b : 200;
        const smoothScroll = (_d = (_c = settings === null || settings === void 0 ? void 0 : settings.gesso) === null || _c === void 0 ? void 0 : _c.backToTopSmoothScroll) !== null && _d !== void 0 ? _d : true;
        const backToTop = context.querySelector('.c-back-to-top');
        if (!backToTop) {
            return;
        }
        if (!Number.isNaN(threshold) && threshold > 0) {
            backToTop.setAttribute('aria-hidden', 'true');
            backToTop.setAttribute('tabIndex', '-1');
            const scrollHandler = () => {
                if (window.scrollY >= threshold &&
                    backToTop.getAttribute('aria-hidden') === 'true') {
                    backToTop.setAttribute('aria-hidden', 'false');
                    backToTop.removeAttribute('tabIndex');
                }
                else if (window.scrollY < threshold &&
                    backToTop.getAttribute('aria-hidden') === 'false') {
                    backToTop.setAttribute('aria-hidden', 'true');
                    backToTop.setAttribute('tabIndex', '-1');
                }
            };
            let stillScrolling;
            window.addEventListener('scroll', () => {
                if (typeof stillScrolling !== 'undefined') {
                    window.clearTimeout(stillScrolling);
                }
                stillScrolling = window.setTimeout(scrollHandler, 60);
            });
        }
        else {
            backToTop.setAttribute('aria-hidden', 'false');
            backToTop.removeAttribute('tabIndex');
        }
        if (smoothScroll) {
            backToTop.addEventListener('click', event => {
                const targetId = backToTop.getAttribute('href');
                const target = document.querySelector(targetId);
                if (target instanceof HTMLElement) {
                    event.preventDefault();
                    const coords = target.getBoundingClientRect();
                    target.setAttribute('tabIndex', '-1');
                    window.scrollTo({
                        top: coords.top,
                        behavior: 'smooth',
                    });
                    target.focus();
                }
            });
        }
    },
};

}();
/******/ })()
;
//# sourceMappingURL=back-to-top.es6.js.map