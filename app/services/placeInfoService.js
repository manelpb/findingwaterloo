'use strict';
app.factory('placeInfoService', ['$http', '$q', 'ngAuthSettings', function ($http, $q, localStorageService, ngAuthSettings) {

    var serviceBase = ngAuthSettings.apiServiceBaseUri;
    var placeInfoServiceFactory = {};


    var _authentication = {
        isAuth: false,
        userName: "",
        useRefreshTokens: false
    };

    var _externalAuthData = {
        provider: "",
        userName: "",
        externalAccessToken: ""
    };

    var _registrationData = {
        userName: "",
        password: "",
        confirmPassword: "",
        Email: "",
        confirmEmail:""
    }

    //define loginResultEnum
    //var LogResultEnum = Object.freeze({ "Succeed": 0, "WrongCredential": 1, "Locked": 2, "InActivate" :3 });



    var getPlaceInfos = function (userName) {

        return $http.get('http://172.31.11.163/findingwaterloo/index.php/api/things').then(function (response) {
            return response;
        });
    };




    return placeInfoServiceFactory;
}]);

