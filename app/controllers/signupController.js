'use strict';
app.controller('signupController', ['$scope', '$location', '$timeout', 'authService', 'pricingService', '$modal', 'ModelShareService', 'WizardHandler', '$http', function ($scope, $location, $timeout, authService, pricingService, $modal, ModelShareService, WizardHandler, $http) {

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


        //authService.saveRegistration($scope.registration).then(function (response) {

        //    $scope.savedSuccessfully = true;
        //    $scope.message = response.data;

        //    //if signup succeeds, then login directly.
        //    if (response.status == 200)
        //    {
        //       var _loginData = {
        //           userName: $scope.registration.userName,
        //           password: $scope.registration.password
        //       };

        //       authService.userLogin(_loginData);
        //    }

        //    $location.path('/home');

        //},
        // function (response) {
        //     var errors = [];
        //     for (var key in response.data.modelState) {
        //         for (var i = 0; i < response.data.modelState[key].length; i++) {
        //             errors.push(response.data.modelState[key][i]);
        //         }
        //     }
        //     $scope.message = "Failed to register user due to:" + errors.join(' ');
        // });
    };

    /*
    var startTimer = function () {
        var timer = $timeout(function () {
            $timeout.cancel(timer);
            $location.path('/login');
        }, 2000);
    }
    */

    //$scope.UpdateRoleStatus = function () {

    //    if ($scope.userRole === undefined || $scope.userRole === null) {
    //        $scope.InvalidRole = true;
    //        return false;
    //    }
    //    else {
    //        $scope.InvalidRole = false;
    //    }

    //    return true;
    //};

    /**********************************************************************************************
     credit card validation and Payment
    **********************************************************************************************/
    $scope.OnNext = function () {
        WizardHandler.wizard().next();
    }

    $scope.animationsEnabled = true;
    $scope.ShowPaymentWindow = function () {

        var modalInstance = $modal.open({
            animation: $scope.animationsEnabled,
            templateUrl: 'myModalContent.html',
            backdrop: true,
            windowClass: 'modal',
            controller: 'paymentController'
        });
    };

    $scope.finishedWizard = function () {
        alert("wizard finished");
    }

    //$scope.InitUserName = function () {
    //    var userName = ModelShareService.getUserName();
    //    if (userName != null && userName != "") {
    //        $scope.userName = userName;
    //        $scope.IsReadOnly = true;
    //    }
    //    else {
    //        paymentForm.$invalid = true;
    //        $scope.IsReadOnly = false;

    //    }
    //}

    //var ValidateUserName = function () {
    //    if ($scope.userName === undefined || $scope.userName === null || $scope.userName.length === 0) {
    //        return false;
    //    }

    //    authService.checkUserNameAvailability($scope.userName)
    //                     .then(function () {
    //                         return false;
    //                     },
    //                      function () {
    //                          return true;
    //                      });
    //}

    $scope.onSubmit = function () {
        //if (!ValidateUserName()) {
        //    paymentForm.$invalid = false;
        //    return false;
        //}
        $scope.processing = true;
    }

    $scope.GotoPayment = function () {
        WizardHandler.wizard().next();
    }

    $scope.stripeCallback = function (code, result) {
        $scope.processing = false;
        //       $scope.hideAlerts();
        if (result.error) {
            $scope.stripeError = result.error.message;
            $scope.IsNextDisabled = true;
        }
        else {
            $scope.stripeSucceed = "Valid Credit Card";
            $scope.stripeToken = result.id;
            $scope.IsNextDisabled = false;
        }
    };

    //temporary hard coded
    $scope.paymentAmount = "$99.00";

    $scope.Cancel = function () {
        //$modalInstance.dismiss('cancel');
        $location.path('/home');
    }

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

    $scope.Pay = function () {

        //if ($scope.userName == null || $scope.userName == "") {
        //    return false;
        //}

        var paymentInfo = {

            CreditCardToken: $scope.stripeToken,
            //temporaty
            serviceType: 1,
            PayerNamer: $scope.userName,
            CardHolderName: $scope.userName,
            Amount: $scope.paymentAmount,
            AddressLine1: '',
            AddressLine2: '',
            AddressCity: '',
            AddressPostcode: '',
            AddressCountry: ''
        };

        return $http.post(serviceBase + 'api/payment/charge', paymentInfo).then(function (response) {
            alert(response.data);
            $scope.message = response.data;

            registerUser();

            return response;
        },
        function (ErrorResponse) {

            $scope.message = response.data;
        });
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
