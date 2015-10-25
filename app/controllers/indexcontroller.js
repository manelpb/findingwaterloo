'use strict';
app.controller('indexController', ['$scope', '$location', 'authService', 'localStorageService', function ($scope, $location, authService, localStorageService) {

    $scope.logOut = function () {
        authService.logOut();
        $location.path('/home');
    }

    $scope.authentication = authService.authentication;

    var userData = localStorageService.get('currentUserData');
        if (userData) {

            $scope.img_url = userData.imageUrl;
            $scope.username = userData.userName;
        }


}]);


