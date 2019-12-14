(function (angular) {
    'use strict'
    angular.module("Pengirim", [])
        //controller pengirim
        .controller("PengirimController", function ($scope, $http) {
            $scope.DatasPengirim = [];
            $scope.input = {};
            $scope.status = "Simpan";
            $http({
                method: "get",
                url: "http://localhost/seaexpress/CodeIgniter/pengirim",
                header: {
                    "Content-Type": "application/json"
                }
            }).then(function (response) {
                $scope.DatasPengirim = response.data.data;
            }, function (error) {
                alert(error.message);
            })

            $scope.Simpan = function () {
                if ($scope.status == "Simpan") {
                    $http({
                        method: "POST",
                        url: "http://localhost/seaexpress/CodeIgniter/pengirim",
                        data: $scope.input,
                        header: {
                            "Content-Type": "application/json"
                        }
                    }).then(function (response) {
                        $scope.DatasPengirim.push(angular.copy($scope.input));
                        alert("Data Berhasil disimpan");
                    }, function (error) {
                        alert("Data gagal disimpan");
                    })
                } else {
                    $http({
                        method: "PUT",
                        url: "http://localhost/seaexpress/CodeIgniter/pengirim",
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
                    url: "http://localhost/seaexpress/CodeIgniter/pengirim?idPengirim=" + item.idPengirim,
                }).then(function (response) {
                    var index = $scope.DatasPengirim.indexOf(item);
                    $scope.DatasPengirim.splice(index, 1);
                    alert("Data Berhasil Dihapus");
                    $scope.DatasPengirim.push($scope.input);
                }, function (error) {
                    alert("Data Gagal Dihapus");
                })
            }

            $scope.GetData = function (item) {
                $scope.input = item;
                $scope.status = "updatePengirim";
            }
            $scope.GetSimpan = function (item) {
                $scope.status = "deletePengirim";
            }
        })


})(window.angular);