/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 40);
/******/ })
/************************************************************************/
/******/ ({

/***/ 12:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var emitter = window.top.jsEmailBuilderEmitter;

function dialogSendTestEmail() {
    swal({
        title: "Send test email",
        text: "Enter email address to send:",
        type: "input",
        showCancelButton: true,
        closeOnConfirm: false,
        animation: "slide-from-top",
        inputPlaceholder: "john@example.com",
        showLoaderOnConfirm: true
    }, function (inputValue) {
        if (inputValue === false) return false;

        if (inputValue === "") {
            swal.showInputError("Please enter email address to send.");
            return false;
        }

        var templateHTML = $('.templateHTML').val();

        var data = {};
        data.action = 'send-test-emails';
        data.emails = inputValue;
        data.templateHTML = templateHTML; // Base64 Encode

        $.ajax({
            url: config.send_script,
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function success(data) {
                if (data['type'] == 'success') {
                    // show error message
                    swal("Nice!", "Email has been sent to: " + inputValue, "success");
                } else {
                    swal("Oops!", "An error is occurred", "error");
                }
            },
            error: function error(xhr, err) {
                // Log errors if AJAX call is failed
                console.log(xhr);
                console.log(err);
            }
        });
        return false;
    });
};

function dialogExportHTML() {
    swal({
        title: "Export to HTML",
        text: "Export template to single HTML file",
        type: "info",
        showCancelButton: true,
        showLoaderOnConfirm: true
    }, function () {
        setTimeout(function () {
            swal("Template has been exported successfully");
            $('#export-form [name="type"]').val('html');
            $('#export-form').submit();
        }, 1000);
    });
};

function dialogExportZip() {
    swal({
        title: "Export to ZIP",
        text: "Export template to zip-archive",
        type: "info",
        showCancelButton: true,
        showLoaderOnConfirm: true
    }, function () {
        setTimeout(function () {
            swal("Template has been exported successfully");
            $('#export-form [name="type"]').val('zip');
            $('#export-form').submit();
        }, 1000);
    });
};

emitter.on('init', function () {
    $('[data-action="send-test-email"]').on('click', function (event) {
        dialogSendTestEmail();
    });
    $('[data-action="export-html"]').on('click', function (event) {
        dialogExportHTML();
    });
    $('[data-action="export-zip"]').on('click', function (event) {
        dialogExportZip();
    });

});

/***/ }),

/***/ 40:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(12);


/***/ })

/******/ });