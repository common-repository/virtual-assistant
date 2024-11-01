/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/scss/public.scss":
/*!******************************!*\
  !*** ./src/scss/public.scss ***!
  \******************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


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
/*!**************************************!*\
  !*** ./src/js/public/core-public.js ***!
  \**************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var SCSS_public_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! SCSS/public.scss */ "./src/scss/public.scss");
// CSS

(function ($) {
  $('body').on('submit', '#directorist_helgent_config', function (e) {
    var submitButton = this.querySelector(".directorist-btn-profile-save");
    submitButton.classList.add('hdi_loading');
    e.preventDefault();
    var form_data = $(this).serialize();
    $.post(CoreScriptData.ajax_url, form_data, function (response) {
      submitButton.classList.remove('hdi_loading');
      if (!response.success) {
        $('#directorist-user-config-notice').html('<span class="directorist-alert directorist-alert-danger">' + response.data.message + '</span>');
      } else {
        $('#directorist-user-config-notice').html('<span class="directorist-alert directorist-alert-success">' + response.data.message + '</span>');
      }
    }, 'json');
  });
  $('body').on('click', '.exlac-vm-note__single .exlac-vm-note__single--label', function (e) {
    // Get the text to copy
    var text = this.innerText;

    // Use the Clipboard API to write the text to the clipboard
    navigator.clipboard.writeText(text);
    var toggleText = document.createElement("span");
    toggleText.classList.add("toggle-text");
    toggleText.innerHTML = "Text Copied";
    this.appendChild(toggleText);
    setTimeout(function () {
      toggleText.classList.add("fadeOut");
      setTimeout(function () {
        toggleText.remove();
      }, 500);
    }, 1000);
  });
  window.addEventListener('load', function () {
    var formLink = document.querySelector('#exlac-vm-form-edit .exlac-vm-form-top__left a');
    if (formLink) {
      formLink.setAttribute("href", "dashboard/#active_dhgi_forms");
    }
    var formContentEdit = document.getElementById('exlac-vm-form-edit');
    if (formContentEdit) {
      var menuLink = document.querySelector('.atbd-dashboard-nav li a[target="dhgi_forms"]');
      menuLink.addEventListener("click", function () {
        location.reload();
        if (formContent) {
          formParent.appendChild(formContent);
        }
      });
    }
  });
})(jQuery);
}();
/******/ })()
;
//# sourceMappingURL=core-public.js.map