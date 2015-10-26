'use strict';
app.controller('profileController', ['$scope', '$location', 'authService', 'ModelShareService', '$http', 'localStorageService', 'ngAuthSettings', function ($scope, $location, authService, ModelShareService, $http, localStorageService, ngAuthSettings){

    var serviceBase = ngAuthSettings.apiServiceBaseUri;

    $scope.init = function(){

        /*if(!authService.authentication.isAuth)
        {
            authService.logOut();
            $location.path('/login');
            return false;
        }*/

        var userData = localStorageService.get('currentUserData');
        if (userData) {

            $scope.img_url = userData.imageUrl;
            $scope.username = userData.userName;
        }

        userRank();

        $scope.title = "adventurer" ;

    }




    var userRank = function(){

        return $http.get(serviceBase + 'api/user_rank').success(function (response) {


        }).error(function (err) {

               console.log(err);
        });
    }
}]);
