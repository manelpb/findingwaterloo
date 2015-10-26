'use strict';
app.controller('signupController', ['$scope', '$location', '$timeout', 'authService', 'ModelShareService', '$http', function ($scope, $location, $timeout, authService, ModelShareService, $http) {

    $scope.savedSuccessfully = false;
    $scope.message = "";
    $scope.erroMessage = "";
    $scope.passwordNotMatch = false;

    $scope.IsNextDisabled = true;


    $scope.registration = {
        userName: "",
        password: "",
        confirmPassword: "",
        Email: "",
        confirmEmail:""
    };

    var getPlaceInfos = function (userName) {

        return $http.get('http://172.31.11.163/findingwaterloo/index.php/api/things').then(function (response) {
            return response;
        });
    };

    var checkInputValidity = function () {

        if($scope.registration.password != $scope.registration.confirmPassword)
        {
            $scope.passwordNotMatch = true;

            return false;
        }
        else
        {
            $scope.passwordNotMatch = false;
        }

        if ($scope.registration.Email != $scope.registration.confirmEmail)
        {
            $scope.emailNotMatch = true;

            return false;
        }
        else
        {
            $scope.emailNotMatch = false;
        }

        return true;
    };

    $scope.CheckPasswordMatch = function () {

        if ($scope.registration.password != $scope.registration.confirmPassword) {

            $scope.passwordNotMatch = true;

            return false;
        }
        else
        {
            $scope.passwordNotMatch = false;
        }
    };

    $scope.CheckEmail = function () {
        if ($scope.registration.Email == '' || $scope.registration.Email == undefined)
        {
            $scope.blankEmail = true;
        }
        else
        {
            $scope.blankEmail = false;
        }
    };

    $scope.CheckConfirmEmail = function () {
        if($scope.registration.confirmEmail == '' || $scope.registration.confirmEmail == undefined)
        {
            $scope.blankConfirmEmail = true;
            return false;
        }
        else if( $scope.registration.confirmEmail == $scope.registration.Email)
        {
            $scope.blankConfirmEmail = false;
            $scope.emailNotMatch = false;
        }
        else
        {
            $scope.emailNotMatch = true;
        }
    };


     $scope.signUp = function () {

        authService.saveRegistration($scope.registration).then(function (response) {

            $scope.savedSuccessfully = true;
            $scope.message = response.data;

            //if signup succeeds, then login directly.
            if (response.status == 200)
            {
               var _loginData = {
                   userName: $scope.registration.userName,
                   password: $scope.registration.password
               };

               authService.userLogin(_loginData);

               $location.path('/mapView');
            }
            else
            {
                $scope.ErrorMessage = response.statusText;
                $scope.description = response.data.message;
            }

        });
    };


    var registerUser = function () {


       authService.saveRegistration($scope.registration).then(function (response) {

            $scope.savedSuccessfully = true;
            $scope.message = response.data;

            //if signup succeeds, then login directly.
            if (response.status == 200)
            {
               var _loginData = {
                   userName: $scope.registration.userName,
                   password: $scope.registration.password
               };

               authService.userLogin(_loginData);
            }

            $location.path('/home');

        },
         function (response) {

             $scope.ErrorMessage = response.statusText;
        });

    };
}]);


