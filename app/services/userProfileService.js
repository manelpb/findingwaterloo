'use strict';
app.factory('authService', ['$http', '$q', 'localStorageService', 'ngAuthSettings', function ($http, $q, localStorageService, ngAuthSettings) {

    var serviceBase = ngAuthSettings.apiServiceBaseUri;
    var authServiceFactory = {};


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

    var _setRegistrationData = function (registrationData) {

        _registrationData.userName        = registrationData.userName;
        _registrationData.password        = registrationData.password;
        _registrationData.confirmPassword = registrationData.confirmPassword;
        _registrationData.Email           = registrationData.Email;
        _registrationData.confirmEmail    = registrationData.confirmEmail;
    };

    var _saveRegistration = function () {

        _logOut();

        return $http.post(serviceBase + 'api/account/register', _registrationData).then(function (response) {
            return response;
        });

    };

    var user_login = function (loginData) {

        var data = "grant_type=password&username=" + loginData.userName + "&password=" + loginData.password;

        var deferred = $q.defer();

        $http.post(serviceBase + 'token', data, { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }).success(function (response) {

            var tokenExpireTime = new Date().getTime() / 1000 + response.expires_in;
            localStorageService.set('authorizationData', { token: response.access_token, userName: loginData.userName, expireTime: tokenExpireTime });

            _authentication.isAuth = true;
            _authentication.userName = loginData.userName;

            deferred.resolve(response);

        }).error(function (err, status) {
            _logOut();
            deferred.reject(err);

        });

        return deferred.promise;

    };

    var _login = function (loginData) {

        var data = "grant_type=password&username=" + loginData.userName + "&password=" + loginData.password;

        if (loginData.useRefreshTokens) {
            data = data + "&client_id=" + ngAuthSettings.clientId;
        }

        var deferred = $q.defer();

        $http.post(serviceBase + 'token', data, { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }).success(function (response) {

            if (loginData.useRefreshTokens) {
                localStorageService.set('authorizationData', { token: response.access_token, userName: loginData.userName, refreshToken: response.refresh_token, useRefreshTokens: true });
            }
            else {
                localStorageService.set('authorizationData', { token: response.access_token, userName: loginData.userName, refreshToken: "", useRefreshTokens: false });
            }
            _authentication.isAuth = true;
            _authentication.userName = loginData.userName;
            _authentication.useRefreshTokens = loginData.useRefreshTokens;

            deferred.resolve(response);

        }).error(function (err, status) {
            _logOut();
            deferred.reject(err);
        });

        return deferred.promise;

    };

    var _logOut = function () {

        localStorageService.remove('authorizationData');

        _authentication.isAuth = false;
        _authentication.userName = "";
        _authentication.useRefreshTokens = false;

    };

    var _fillAuthData = function () {

        var authData = localStorageService.get('authorizationData');
        if (authData) {
            _authentication.isAuth = true;
            _authentication.userName = authData.userName;
            _authentication.useRefreshTokens = authData.useRefreshTokens;
        }

    };

    var _refreshToken = function () {
        var deferred = $q.defer();

        var authData = localStorageService.get('authorizationData');

        if (authData) {

            if (authData.useRefreshTokens) {

                var data = "grant_type=refresh_token&refresh_token=" + authData.refreshToken + "&client_id=" + ngAuthSettings.clientId;

                localStorageService.remove('authorizationData');

                $http.post(serviceBase + 'token', data, { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }).success(function (response) {

                    localStorageService.set('authorizationData', { token: response.access_token, userName: response.userName, refreshToken: response.refresh_token, useRefreshTokens: true });

                    deferred.resolve(response);

                }).error(function (err, status) {
                    _logOut();
                    deferred.reject(err);
                });
            }
        }

        return deferred.promise;
    };

    var _obtainAccessToken = function (externalData) {

        var deferred = $q.defer();

        $http.get(serviceBase + 'api/account/ObtainLocalAccessToken', { params: { provider: externalData.provider, externalAccessToken: externalData.externalAccessToken } }).success(function (response) {

            localStorageService.set('authorizationData', { token: response.access_token, userName: response.userName, refreshToken: "", useRefreshTokens: false });

            _authentication.isAuth = true;
            _authentication.userName = response.userName;
            _authentication.useRefreshTokens = false;

            deferred.resolve(response);

        }).error(function (err, status) {
            _logOut();
            deferred.reject(err);
        });

        return deferred.promise;

    };

    var _registerExternal = function (registerExternalData) {

        var deferred = $q.defer();

        $http.post(serviceBase + 'api/account/registerexternal', registerExternalData).success(function (response) {

            localStorageService.set('authorizationData', { token: response.access_token, userName: response.userName, refreshToken: "", useRefreshTokens: false });

            _authentication.isAuth = true;
            _authentication.userName = response.userName;
            _authentication.useRefreshTokens = false;

            deferred.resolve(response);

        }).error(function (err, status) {
            _logOut();
            deferred.reject(err);
        });

        return deferred.promise;

    };

    var _checkUserNameAvailability = function (userName) {

        return $http.get(serviceBase + 'api/account/IsUserAvailable', { params: { userName: userName } }).then(function (response) {
            return response;
        });
    };

    var _activateAccount = function (userId, code) {
        var data = {
            userId : "",
            code : ""
        };

        data.userId = userId;
        data.code = code;

        return $http.post(serviceBase + 'api/account/ConfirmAccount', data).then(function (response) {
            return response;
        });
    };

    var _requestResetPassword = function (userName) {

        var data = {userName : ''};
        data.userName = userName;

        return $http.post(serviceBase + 'api/account/RequestResetPassword', data).then(function (response) {
            return response;
        });
    };

    var _resetPassword = function (newPasswordData) {

        return $http.post(serviceBase + 'api/account/ResetNewPassword', newPasswordData).then(function (response) {
            return response;
        });
    };

    var _isTokenExpired = function()
    {
        var authData = localStorageService.get('authorizationData');

        if (new Date().getTime() / 1000 >= authData.expireTime)
            return true;
        else
            return false;
    }

    authServiceFactory.saveRegistration = _saveRegistration;
    authServiceFactory.login = _login;
    authServiceFactory.logOut = _logOut;
    authServiceFactory.fillAuthData = _fillAuthData;
    authServiceFactory.authentication = _authentication;
    authServiceFactory.refreshToken = _refreshToken;
    authServiceFactory.checkUserNameAvailability = _checkUserNameAvailability;
    authServiceFactory.userLogin = user_login;
    authServiceFactory.obtainAccessToken = _obtainAccessToken;
    authServiceFactory.externalAuthData = _externalAuthData;
    authServiceFactory.registerExternal = _registerExternal;
    authServiceFactory.activateAccount = _activateAccount;
    authServiceFactory.setRegistrationData = _setRegistrationData;
    authServiceFactory.requestResetPassword = _requestResetPassword;
    authServiceFactory.resetPassword = _resetPassword;
    authServiceFactory.isTokenExpired = _isTokenExpired;


    return authServiceFactory;
}]);

