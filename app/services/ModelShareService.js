'use strict';
app.factory('ModelShareService', function () {

        var userName;

        var _getUserName = function () {
            return userName;
        }

        var _setUserName = function (value) {
            userName = value;
        }


        var ModelShareServiceFactory = {};

        ModelShareServiceFactory.setUserName = _setUserName;
        ModelShareServiceFactory.getUserName = _getUserName;

        return ModelShareServiceFactory;
});
