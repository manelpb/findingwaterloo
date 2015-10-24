'use strict';

var app = angular.module('FindingWaterlooApp', ['ngRoute', 'LocalStorageModule', 'angular-loading-bar', 'ui.bootstrap', 'angularSpinner']);

app.config(function ($routeProvider) {

    $routeProvider.when("/home", {
        controller: "homeController",
        templateUrl: "/app/views/home.html"
    });

    $routeProvider.when("/login", {
        controller: "loginController",
        templateUrl: "/app/views/login.html"
    });

    $routeProvider.when("/signup", {
        controller: "signupController",
        templateUrl: "/app/views/signup.html"
    });

    $routeProvider.when("/refresh", {
        controller: "refreshController",
        templateUrl: "/app/views/refresh.html"
    });

    $routeProvider.when("/tokens", {
        controller: "tokensManagerController",
        templateUrl: "/app/views/tokens.html"
    });

    $routeProvider.when("/profile", {
        controller: "userProfileController",
        templateUrl: "/app/views/profile.html"

    });

    $routeProvider.when("/associate", {
        controller: "associateController",
        templateUrl: "/app/views/associate.html"
    });


    $routeProvider.when("/activate", {
        controller: "activateController",
        templateUrl: "/app/views/activate.html",
        resolve: {
            // I will cause a 1 second delay
            delay: function ($q, $timeout) {
                var delay = $q.defer();
                $timeout(delay.resolve, 1000);
                return delay.promise;
            }
        }
    });


    $routeProvider.when("/begin_password_reset", {
        controller: "resetPasswordController",
        templateUrl: "/app/views/begin_password_reset.html"
    });

    $routeProvider.when("/setNewPassword", {
        controller: "setNewPasswordController",
        templateUrl: "/app/views/setNewPassword.html"
    });


    $routeProvider.otherwise({ redirectTo: "/home" });

});

var serviceBase = 'http://localhost:58077/';
//var serviceBase = 'http://volleyballauth.azurewebsites.net/';
app.constant('ngAuthSettings', {
    apiServiceBaseUri: serviceBase,
    clientId: 'FindingWaterlooApp'
});

app.config(function ($httpProvider) {
    $httpProvider.interceptors.push('authInterceptorService');
    //$window.Stripe.setPublishableKey('pk_test_SMvZ1iQSQ3Oa46rzH3ASIzzX');
});



app.run(['authService', function (authService) {
    authService.fillAuthData();
}]);


