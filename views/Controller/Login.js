(function (angular) {
    'use strict'
    angular.module("Login", [])
        // Users
        .controller("UsersController", function ($scope, $http, $window) {
            $scope.input = {};
            $scope.Login = function () {
                var Url = "http://localhost/seaexpress/CodeIgniter/users?username=" + $scope.input.username + "&psw=" + $scope.input.psw;

                $http({
                    method: "get",
                    url: Url
                }).then(function (response) {
                    alert("Sukses login");

                    $window.sessionStorage.setItem("username", $scope.input.username);
                    $window.location.href = "index.html"
                }, function (error) {
                    alert("Gagal Login");

                    $window.sessionStorage.setItem("username", response.data.data.data.username);

                })
            }
        })
})(window.angular);