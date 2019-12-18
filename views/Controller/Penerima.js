(function (angular) {
    'use strict'
    angular.module("Penerima", [])
        //controller Penerima
        .controller("PenerimaController", function ($scope, $http) {
            $scope.DatasPenerima = [];
            $scope.input = {};
            $scope.status = "Simpan";
            $http({
                method: "get",
                url: "http://localhost/SeaExpress/CodeIgniter/penerima",
                header: {
                    "Content-Type": "application/json"
                }
            }).then(function (response) {
                $scope.DatasPenerima = response.data.data;
            }, function (error) {
                alert(error.message);
            })

            $scope.Simpan = function () {
                if ($scope.status == "Simpan") {
                    $http({
                        method: "POST",
                        url: "http://localhost/SeaExpress/CodeIgniter/penerima",
                        data: $scope.input,
                        header: {
                            "Content-Type": "application/json"
                        }
                    }).then(function (response) {
                        $scope.DatasPenerima.push(angular.copy($scope.input));
                        alert("Data Berhasil disimpan");
                    }, function (error) {
                        alert("Data gagal disimpan");
                    })
                } else {
                    $http({
                        method: "PUT",
                        url: "http://localhost/SeaExpress/CodeIgniter/penerima",
                        data: $scope.input,
                        header: {
                            "Content-Type": "application/json"
                        }
                    }).then(function (response) {
                        alert("Data berhasil diubah");
                    }, function (error) {
                        alert("Data gagal diubah");
                    })
                }
            }
            $scope.Hapus = function (item) {
                $http({
                    method: "DELETE",
                    url: "http://localhost/SeaExpress/CodeIgniter/penerima?idPenerima=" + item.idPenerima,
                }).then(function (response) {
                    var index = $scope.DatasPenerima.indexOf(item);
                    $scope.DatasPenerima.splice(index, 1);
                    alert("Data Berhasil Dihapus");
                    $scope.DatasPenerima.push($scope.input);
                }, function (error) {
                    alert("Data Gagal Dihapus");
                })
            }

            $scope.GetData = function (item) {
                $scope.input = item;
                $scope.status = "updatePenerima";
            }
            $scope.GetSimpan = function (item) {
                $scope.status = "deletePenerima";
            }
        })

})(window.angular);