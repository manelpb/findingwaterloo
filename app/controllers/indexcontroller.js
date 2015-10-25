'use strict';
app.controller('indexController', ['$scope', '$location', 'authService', 'localStorageService', '$window', function ($scope, $location, authService, localStorageService, $window) {

    $scope.logOut = function () {

        var isLogOut = $window.confirm('Do you want to leave?');

        if (isLogOut) {

            authService.logOut();
            $location.path('/home');
            return false;
        }


    }

    $scope.authentication = authService.authentication;

    var userData = localStorageService.get('currentUserData');
        if (userData) {

            $scope.img_url = userData.imageUrl;
            $scope.username = userData.userName;
        }

}]);


