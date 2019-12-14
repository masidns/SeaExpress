(function (angular) {
    'use strict'
    angular.module("Pembayaran", [])
        //controller pembayaran
        .controller("PembayaranController", function ($scope, $http) {
            $scope.DatasPembayaran = [];
            $scope.DatasTransaksi = [];
            $scope.SelectedTransaksi = {};
            $scope.input = {};
            $scope.status = "Simpan";
            $http({
                method: "get",
                url: "http://localhost/seaexpress/CodeIgniter/pembayaran",
                header: {
                    "Content-Type": "application/json"
                }
            }).then(function (response) {
                $scope.DatasPembayaran = response.data.status;
            }, function (error) {
                alert(error.message);
            })
            // get Transaksi
            $http({
                method: "get",
                url: "http://localhost/seaexpress/CodeIgniter/transaksi",
                header: {
                    "Content-Type": "application/json"
                }
            }).then(function (response) {
                $scope.DatasTransaksi = response.data.data;
            }, function (error) {
                alert(error.message);
            })

            $scope.Simpan = function () {


                if ($scope.status == "Simpan") {

                    $scope.input.NoStt = $scope.SelectedTransaksi.NoStt;
                    $http({
                        method: "POST",
                        url: "http://localhost/seaexpress/CodeIgniter/pembayaran",
                        data: $scope.input,
                        header: {
                            "Content-Type": "application/json"
                        }
                    }).then(function (response) {
                        $scope.DatasPembayaran.push(response.data.status[0]);
                        alert("Data Berhasil disimpan");
                    }, function (error) {
                        alert("Data gagal disimpan");
                    })
                } else {
                    $scope.input.NoStt = $scope.SelectedTransaksi.NoStt;
                    var Data = {};
                    Data.NoStt = $scope.input.NoStt;
                    Data.idPembayaran = $scope.input.idPembayaran;
                    Data.Carabayar = $scope.input.Carabayar;
                    Data.via = $scope.input.via;
                    $http({
                        method: "PUT",
                        url: "http://localhost/seaexpress/CodeIgniter/pembayaran",
                        data: Data,
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
                    url: "http://localhost/seaexpress/CodeIgniter/pembayaran?idPembayaran=" + item.idPembayaran,
                }).then(function (response) {
                    var index = $scope.DatasPembayaran.indexOf(item);
                    $scope.DatasPembayaran.splice(index, 1);
                    alert("Data Berhasil Dihapus");
                    $scope.DatasPembayaran.push($scope.input);
                }, function (error) {
                    alert("Data Gagal Dihapus");
                })
            }

            $scope.GetData = function (item) {
                $scope.input = item;
                angular.forEach($scope.DatasTransaksi, function (value, key) {
                    if (value.NoStt == item.NoStt) {
                        $scope.SelectedTransaksi = value;
                    }
                })
                $scope.status = "updatePembayaran";
            }
            $scope.GetSimpan = function (item) {
                $scope.status = "Simpan";
                $scope.input = {};
            }
        })

})(window.angular);