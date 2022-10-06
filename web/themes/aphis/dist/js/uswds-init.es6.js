/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************************!*\
  !*** ./source/02-uswds/uswds-init.es6.js ***!
  \*******************************************/
/* eslint-disable */
!function () {
  "use strict";

  var t,
      e = "usa-js-loading";

  function n() {
    document.documentElement.classList.remove(e);
  }

  document.documentElement.classList.add(e), t = setTimeout(n, 8e3), document.addEventListener("load", function e() {
    window.uswdsPresent && (clearTimeout(t), n(), document.removeEventListener("load", e, !0));
  }, !0);
}();
/* eslint-enable */
/******/ })()
;
//# sourceMappingURL=uswds-init.es6.js.map