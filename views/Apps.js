(function (angular){
    'use strict'
    angular.module("MyApp", ["MyController", "ngAnimate", "ui.router"])
    .config(function($stateProvider, $urlRouterProvider){
        $urlRouterProvider.otherwise("Home");
        $stateProvider
            .state("home", {
                url:"/home",
                templateUrl:"views/pages/home.html",
                controller:"HomeController"
            })
            .state("pengirim", {
                url:"/pengirim",
                templateUrl:"views/pages/pengirim.html",
                controller:"PengirimController"
            })
            .state("penerima", {
                url:"/penerima",
                templateUrl:"views/pages/penerima.html",
                controller:"PenerimaController"
            })
            .state("barang", {
                url:"/barang",
                templateUrl:"views/pages/barang.html",
                controller:"BarangController"
            })
            .state("transaksi", {
                url:"/transaksi",
                templateUrl:"views/pages/transaksi.html",
                controller:"TransaksiController"
            })
            .state("pembayaran", {
                url:"/pembayaran",
                templateUrl:"views/pages/pembayaran.html",
                controller:"PembayaranController"
            })
            .state("penjualan", {
                url:"/Penjualan",
                templateUrl:"views/pages/penjualan.html",
                controller:"PenjualanController"
            })
            .state("users", {
                url:"/users",
                templateUrl:"views/pages/users.html",
                controller:"UsersController"
            })

    })
    .controller("views", function ($scope, $window){
        if ($window.sessionStorage.getItem("username")==undefined || $window.sessionStorage.getItem("username")=="" || $window.sessionStorage.getItem("username")==null ){
            window.location.href="login.html";
        }
        $scope.Logout= function(){
            sessionStorage.clear();
            window.location.href="index.html";
        }
    })

    .filter('daterange', function () {
        return function (conversations, start_date, end_date) {
            var result = [];

            // date filters
            var start_date = (start_date && !isNaN(Date.parse(start_date))) ? Date.parse(start_date) : 0;
            var end_date = (end_date && !isNaN(Date.parse(end_date))) ? Date.parse(end_date) : new Date();

            // if the conversations are loaded
            if (conversations && conversations.length > 0) {
                $.each(conversations, function (index, conversation) {
                    var conversationDate = (conversation.TglKirim && !isNaN(Date.parse(conversation.TglKirim))) ? Date.parse(conversation.TglKirim) : 0;
                    // var conversationDate = new Date(conversation.CreateDate);

                    if (conversationDate >= start_date && conversationDate <= end_date) {
                        result.push(conversation);
                    }
                });

                return result;
            }
        };
    })
})(window.angular);