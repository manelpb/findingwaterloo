'use strict';
app.controller('signupController', ['$scope', '$location', '$timeout', 'authService', 'ModelShareService', '$http', function ($scope, $location, $timeout, authService, ModelShareService, x $http) {

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

        if (!checkInputValidity())
        {
            return false;
        }

        ModelShareService.setUserName($scope.registration.userName);

        WizardHandler.wizard().next();


        //save the registration data.
        authService.setRegistrationData($scope.registration);



    };


    var registerUser = function () {

        authService.saveRegistration($scope.registration).then(function (response) {

            var message = response.data;

            //if signup succeeds, then login directly.
            if (response.status == 200) {
                var _loginData = {
                    userName: $scope.registration.userName,
                    password: $scope.registration.password
                };

                authService.userLogin(_loginData);
            }

            $location.path('/home');

        },
             function (response) {
                 var errors = [];
                 for (var key in response.data.modelState) {
                     for (var i = 0; i < response.data.modelState[key].length; i++) {
                         errors.push(response.data.modelState[key][i]);
                     }
                 }
                 message = "Failed to register user due to:" + errors.join(' ');
             });

        return message;
    };



}]);



app.directive('ngUnique', ['authService', function (authService) {
        return {
            restrict: 'A',
            require: 'ngModel',
            link: function (scope, element, attrs, ngModel) {
                element.bind('blur', function (e) {
                    if (!ngModel || !element.val()) return;
                    var keyProperty = scope.$eval(attrs.wcUnique);
                    var currentValue = element.val();
                    authService.checkUserNameAvailability(currentValue)
                        .then(function (unique) {
                            //Ensure value that being checked hasn't changed
                            //since the Ajax call was made
                            if (currentValue == element.val()) {

                                ngModel.$setValidity('unique', true);

                            }
                        }, function () {
                            //Probably want a more robust way to handle an error
                            //For this demo we'll set unique to true though
                            //ngModel.$setValidity('unique', false);
                            ngModel.$setValidity('unique', false);


                        });
                });
            }
        }
    }]);
