"use strict";

Object.defineProperty(exports, "__esModule", {
    value: true
});

var _slicedToArray = (function () { function sliceIterator(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"]) _i["return"](); } finally { if (_d) throw _e; } } return _arr; } return function (arr, i) { if (Array.isArray(arr)) { return arr; } else if (Symbol.iterator in Object(arr)) { return sliceIterator(arr, i); } else { throw new TypeError("Invalid attempt to destructure non-iterable instance"); } }; })();

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

var _react = require("react");

var _react2 = _interopRequireDefault(_react);

var _axios = require("axios");

var _axios2 = _interopRequireDefault(_axios);

var UserProfile = function UserProfile() {
    var _useState = (0, _react.useState)(null);

    var _useState2 = _slicedToArray(_useState, 2);

    var user = _useState2[0];
    var setUser = _useState2[1];

    var _useState3 = (0, _react.useState)(true);

    var _useState32 = _slicedToArray(_useState3, 2);

    var loading = _useState32[0];
    var setLoading = _useState32[1];

    var _useState4 = (0, _react.useState)(null);

    var _useState42 = _slicedToArray(_useState4, 2);

    var error = _useState42[0];
    var setError = _useState42[1];

    (0, _react.useEffect)(function () {
        _axios2["default"].get("/api/user").then(function (response) {
            setUser(response.data);
            setLoading(false);
        })["catch"](function () {
            setError("Không thể tải thông tin người dùng.");
            setLoading(false);
        });
    }, []);

    if (loading) return _react2["default"].createElement(
        "div",
        null,
        "Đang tải..."
    );
    if (error) return _react2["default"].createElement(
        "div",
        null,
        error
    );
    if (!user) return null;

    return _react2["default"].createElement(
        "div",
        {
            style: {
                maxWidth: 500,
                margin: "40px auto",
                background: "#fff",
                borderRadius: 8,
                boxShadow: "0 2px 8px #eee",
                padding: 24
            }
        },
        _react2["default"].createElement(
            "h2",
            { style: { fontSize: 24, fontWeight: 700, marginBottom: 16 } },
            "Thông tin cá nhân"
        ),
        _react2["default"].createElement(
            "div",
            null,
            _react2["default"].createElement(
                "strong",
                null,
                "Họ tên:"
            ),
            " ",
            user.name
        ),
        _react2["default"].createElement(
            "div",
            null,
            _react2["default"].createElement(
                "strong",
                null,
                "Email:"
            ),
            " ",
            user.email
        ),
        _react2["default"].createElement(
            "div",
            null,
            _react2["default"].createElement(
                "strong",
                null,
                "Số điện thoại:"
            ),
            " ",
            user.phone || "Chưa cập nhật"
        ),
        _react2["default"].createElement(
            "div",
            null,
            _react2["default"].createElement(
                "strong",
                null,
                "Địa chỉ:"
            ),
            " ",
            user.address || "Chưa cập nhật"
        ),
        _react2["default"].createElement(
            "div",
            null,
            _react2["default"].createElement(
                "strong",
                null,
                "Vai trò:"
            ),
            " ",
            user.role
        ),
        _react2["default"].createElement(
            "div",
            null,
            _react2["default"].createElement(
                "strong",
                null,
                "Ngày tạo:"
            ),
            " ",
            user.created_at
        )
    );
};

exports["default"] = UserProfile;
module.exports = exports["default"];
