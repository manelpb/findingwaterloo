'use strict';
app.factory('ModelShareService', function () {

        var userName;

        var _user;

        var _getUserName = function () {
            return userName;
        }

        var _setUserName = function (value) {
            userName = value;
        }


        var _setUser = function(user){
            _user = user;
        }

        var _getUser = function(){
            return _user;
        }

        var ModelShareServiceFactory = {};

        ModelShareServiceFactory.setUserName = _setUserName;
        ModelShareServiceFactory.getUserName = _getUserName;
        ModelShareServiceFactory.setUser = _setUser;
        ModelShareServiceFactory.getUser = _getUser;

        return ModelShareServiceFactory;
});
