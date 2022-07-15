"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pages_Register_js"],{

/***/ "./resources/js/pages/Register.js":
/*!****************************************!*\
  !*** ./resources/js/pages/Register.js ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }



var Register = /*#__PURE__*/function () {
  function Register() {
    _classCallCheck(this, Register);

    this.userRole = document.querySelector('select[name="role"]');

    if (this.userRole.value) {
      this.getUsers(this.userRole.value);
    }

    this.addEventListeners();
  }

  _createClass(Register, [{
    key: "addEventListeners",
    value: function addEventListeners() {
      var _this = this;

      if (this.userRole) {
        this.userRole.addEventListener('change', function () {
          _this.getUsers(_this.userRole.value);
        });
      }
    }
  }, {
    key: "getUsers",
    value: function getUsers(role) {
      axios__WEBPACK_IMPORTED_MODULE_0___default().post('users', {
        'role': role
      }).then(function (response) {
        var assigned_to = document.querySelector('select[name="assigned_to"]');

        if (response.data && response.data.length) {
          assigned_to.innerHTML = '<option value="" >... Select one option</option>';
          response.data.forEach(function (user) {
            var option = document.createElement('option');
            option.value = user.id;
            option.innerHTML = user.name;
            assigned_to.appendChild(option);

            if (assigned_to.getAttribute('value') == option.value) {
              option.setAttribute('selected', 'selected');
            }
          });
          assigned_to.parentElement.classList.remove('hidden');
        } else {
          if (!assigned_to.parentElement.classList.contains('hidden')) {
            assigned_to.parentElement.classList.add('hidden');
          }
        }
      });
    }
  }]);

  return Register;
}();

function init() {
  new Register();
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  init: init
});

/***/ })

}]);