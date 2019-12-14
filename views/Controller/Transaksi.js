(function (angular) {
    'use strict'
    angular.module("Transaksi", [])
        //controller transaksi
        .controller("TransaksiController", function ($scope, $http) {
            $scope.DatasTransaksi = [];
            $scope.DatasPengirim = [];
            $scope.DatasPenerima = [];
            $scope.DatasBarang = [];
            $scope.SelectedPengirim = {};
            $scope.SelectedPenerima = {};
            $scope.SelectedBarang = {};
            $scope.input = {};
            $scope.DataTgl = {};
            $scope.status = "Simpan";

            // Get Transaksi
            $http({
                method: "get",
                url: "http://localhost/cargo/CodeIgniter/transaksi",
                header: {
                    "Content-Type": "application/json"
                }
            }).then(function (response) {
                $scope.DatasTransaksi = response.data.data;
            }, function (error) {
                alert(error.message);
            })
            // Get PENGIRIM
            $http({
                method: "get",
                url: "http://localhost/cargo/CodeIgniter/pengirim",
                header: {
                    "Content-Type": "application/json"
                }
            }).then(function (response) {
                $scope.DatasPengirim = response.data.data;
            }, function (error) {
                alert(error.message);
            })
            // Get PENERIMA
            $http({
                method: "get",
                url: "http://localhost/cargo/CodeIgniter/penerima",
                header: {
                    "Content-Type": "application/json"
                }
            }).then(function (response) {
                $scope.DatasPenerima = response.data.data;
            }, function (error) {
                alert(error.message);
            })
            // Get BARANG
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

            $scope.TestTanggal = function () {
                $scope.DataTgl.TglAwal = $filter('date')($scope.DataTgl.TglAwal, "MM-DD-YYYY");
                var a = $scope.DataTgl;
                alert($scope.DataTgl.TglAwal);

            }

            // hitung
            $scope.hitung = function () {
                if ($scope.SelectedPengirim != undefined && $scope.input.Tarif != undefined && $scope.SelectedBarang != undefined) {
                    $scope.input.Biaya = $scope.input.Tarif;
                    $scope.input.Total = 0;
                    var PPN = 0;
                    var BiayaPack = 0;
                    var Biayalain = 0;
                    if ($scope.input.PPN != undefined && $scope.input.PPN > 0) {
                        PPN = (parseInt($scope.input.Biaya) * parseInt($scope.SelectedBarang.Berat)) * (parseInt($scope.input.PPN) / 100)
                    }
                    if ($scope.input.BiayaPack != undefined) {
                        BiayaPack = parseInt($scope.input.BiayaPack);
                    }
                    if ($scope.input.Biayalain != undefined) {
                        Biayalain = parseInt($scope.input.Biayalain);
                    }
                    $scope.input.Total = parseInt($scope.input.Biaya) * parseInt($scope.SelectedBarang.Berat) + PPN + BiayaPack + Biayalain;
                }
            }
            $scope.DataPrint = [];
            $scope.Cetak = function (Print) {
                var innerContents = document.getElementById(Print).innerHTML;
                var popupWinindow = window.open('', '_blank', 'width=600,height=700,scrollbars=no,menubar=no,toolbar=no,location=no,status=no,titlebar=no');
                popupWinindow.document.open();
                popupWinindow.document.write('<html><head><link href="assets/css/styles.css" rel="stylesheet"><link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"></head><body onload="window.print()"><div>' + innerContents + '</html>');
                popupWinindow.document.close();
            }
            $scope.sum;
            $scope.hidePrint = true;
            $scope.set = function () {
                var a = $scope.DataFilter();
                $scope.sum = a.sum;
            }
            $scope.DataFilter = function () {
                var a = {};
                var sum = 0;
                // date filters
                var start_date = ($scope.DataTgl.TglAwal && !isNaN(Date.parse($scope.DataTgl.TglAwal))) ? Date.parse($scope.DataTgl.TglAwal) : 0;
                var end_date = ($scope.DataTgl.TglAkhir && !isNaN(Date.parse($scope.DataTgl.TglAkhir))) ? Date.parse($scope.DataTgl.TglAkhir) : new Date();

                // if the conversations are loaded
                if ($scope.DatasTransaksi.length && $scope.DatasTransaksi.length > 0) {
                    a.result = [];
                    $.each($scope.DatasTransaksi, function (index, conversation) {
                        var conversationDate = (conversation.TglKirim && !isNaN(Date.parse(conversation.TglKirim))) ? Date.parse(conversation.TglKirim) : 0;
                        // var conversationDate = new Date(conversation.CreateDate);

                        if (conversationDate >= start_date && conversationDate <= end_date) {
                            a.result.push(conversation);
                        }
                    });
                }
                a.sum = 0;
                angular.forEach(a.result, function (value, key) {
                    if (value.Total != null) {
                        //this if statement allows you to change values in any 
                        //input box (non-sequentially) and still have angularjs calculate the sum
                        //the + sign behind $scope converts the value from string to int
                        a.sum += +parseInt(value.Total);
                    }
                });
                $scope.DataPrint = a.result;
                return a;
            }

            $scope.Simpan = function () {
                if ($scope.status == "Simpan") {
                    $scope.input.idPengirim = $scope.SelectedPengirim.idPengirim;
                    $scope.input.NoDo = $scope.SelectedBarang.NoDo;
                    $scope.input.idPenerima = $scope.SelectedPenerima.idPenerima;
                    $http({
                        method: "POST",
                        url: "http://localhost/cargo/CodeIgniter/transaksi",
                        data: $scope.input,
                        header: {
                            "Content-Type": "application/json"
                        }
                    }).then(function (response) {
                        $scope.input.NoStt = response.data.data;
                        $scope.DatasTransaksi.push(angular.copy($scope.input));
                        alert("Data Berhasil disimpan");
                    }, function (error) {
                        alert("Data gagal disimpan");
                    })
                } else {
                    $scope.input.idPengirim = $scope.SelectedPengirim.idPengirim;
                    $scope.input.NoDo = $scope.SelectedBarang.NoDo;
                    $scope.input.idPenerima = $scope.SelectedPenerima.idPenerima;
                    var Data = {};
                    Data.NoStt = $scope.input.NoStt;
                    Data.idPengirim = $scope.input.idPengirim;
                    Data.Tarif = $scope.input.Tarif;
                    Data.Biaya = $scope.input.Biaya;
                    Data.BiayaPack = $scope.input.BiayaPack;
                    Data.Biayalain = $scope.input.Biayalain;
                    Data.PPN = $scope.input.PPN;
                    Data.Total = $scope.input.Total;
                    Data.NoDo = $scope.input.NoDo;
                    Data.idPenerima = $scope.input.idPenerima;

                    $http({
                        method: "PUT",
                        url: "http://localhost/cargo/CodeIgniter/transaksi",
                        data: Data,
                        header: {
                            "Content-Type": "application/json"
                        }
                    }).then(function (response) {
                        // $scope.DatasTransaksi.push(angular.copy($scope.input));
                        alert("Data berhasil diubah");
                    }, function (error) {
                        alert("Data gagal diubah");
                    })
                }
            }
            $scope.Hapus = function (item) {
                $http({
                    method: "DELETE",
                    url: "http://localhost/cargo/CodeIgniter/transaksi?NoStt=" + item.NoStt,
                }).then(function (response) {
                    var index = $scope.DatasTransaksi.indexOf(item);
                    $scope.DatasTransaksi.splice(index, 1);
                    alert("Data Berhasil Dihapus");
                    $scope.DatasTransaksi.push($scope.input);
                }, function (error) {
                    alert("Data Gagal Dihapus");
                })
            }

            $scope.GetData = function (item) {
                angular.forEach($scope.DatasBarang, function (valueBarang, KeyBarang) {
                    if (valueBarang.NoDo == $scope.input.NoDo) {
                        $scope.SelectedBarang = valueBarang;
                    }
                })
                angular.forEach($scope.DatasPengirim, function (valuePengirim, KeyPengirim) {
                    if (valuePengirim.idPengirim == $scope.input.idPengirim) {
                        $scope.SelectedPengirim = valuePengirim;
                    }
                })
                angular.forEach($scope.DatasPenerima, function (valuePenerima, keyPenerima) {
                    if (valuePenerima.idPenerima == $scope.input.idPenerima) {
                        $scope.SelectedPenerima = valuePenerima;
                    }
                })
                $scope.input = item;
                $scope.status = "updateTransaksi";
            }
            $scope.GetSimpan = function (item) {
                $scope.status = "deleteTransaksi";
            }
        })




})(window.angular);