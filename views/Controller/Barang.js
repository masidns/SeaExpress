(function (angular) {
    'use strict'
    angular.module("Barang", [])

        //controller Barang
        .controller("BarangController", function ($scope, $http) {
            $scope.DatasBarang = [];
            $scope.input = {};
            $scope.status = "Simpan";
            $http({
                method: "get",
                url: "http://localhost/cargo/CodeIgniter/barang",
                header: {
                    "Content-Type": "application/json"
                }
            }).then(function (response) {
                $scope.DatasBarang = response.data.data;
            }, function (error) {
                alert(error.message);
            })

            $scope.Simpan = function () {
                if ($scope.status == "Simpan") {
                    $http({
                        method: "POST",
                        url: "http://localhost/cargo/CodeIgniter/barang",
                        data: $scope.input,
                        header: {
                            "Content-Type": "application/json"
                        }
                    }).then(function (response) {
                        $scope.DatasBarang.push(angular.copy($scope.input));
                        alert("Data Berhasil disimpan");
                    }, function (error) {
                        alert("Data gagal disimpan");
                    })
                } else {
                    $http({
                        method: "PUT",
                        url: "http://localhost/cargo/CodeIgniter/barang",
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
                    url: "http://localhost/cargo/CodeIgniter/barang?NoDo=" + item.NoDo,
                }).then(function (response) {
                    var index = $scope.DatasBarang.indexOf(item);
                    $scope.DatasBarang.splice(index, 1);
                    alert("Data Berhasil Dihapus");
                    $scope.DatasBarang.push($scope.input);
                }, function (error) {
                    alert("Data Gagal Dihapus");
                })
            }

            $scope.GetData = function (item) {
                $scope.input = item;
                $scope.status = "updateBarang";
            }
            $scope.GetSimpan = function (item) {
                $scope.status = "deleteBarang";
            }
        })

})(window.angular);