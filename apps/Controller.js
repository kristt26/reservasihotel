angular.module("Ctrl", ['datatables', 'datatables.buttons'])
    .controller("BerandaController", function($scope, $http) {
        // $scope.DatasKamar = [];
        // $http({
        //         method: "GET",
        //         url: "api/datas/read/ReadKamar.php"
        //     })
        //     .then(function(response) {
        //         $scope.DatasKamar = response.data.record;
        //     }, function(error) {
        //         alert(error.message);
        //     })
    })
    .controller("ReservasiController", function($scope, $http) {
        $scope.Biodata = {};
        $scope.Biodata.Kamar = [];
        $scope.TanggalCheckin;
        $scope.TanggalCheckout;
        $scope.DatasKamar = [];
        $scope.ShowKamar = false;
        $scope.ShowTanggal = false;
        $scope.ShowBiodata = true;
        $scope.ButtonProses = false;

        $scope.Next = function() {
            $scope.ShowBiodata = false;
            $scope.ShowTanggal = true;

        }
        $scope.Kamar = function() {
            $scope.ShowTanggal = false;
            $scope.ShowKamar = true;
            $scope.Tanggal = {};
            $scope.Tanggal.TanggalCheckin = $scope.TanggalCheckin;
            $scope.Tanggal.TanggalCheckout = $scope.TanggalCheckout;
            $http({
                    method: "POST",
                    url: "api/datas/read/ReadKamar.php",
                    data: $scope.Tanggal
                })
                .then(function(response) {
                    $scope.DatasKamar = response.data.record;
                }, function(error) {
                    alert(error.message);
                })
        }
        $scope.ColorStyle = function(item) {
            if (item.Color == "aqua") {

                item.Color = "blue";
            } else {
                item.Color = "aqua";
            }
            var a = 0;
            angular.forEach($scope.DatasKamar, function(value, key) {
                if (value.Color == "blue") {
                    a++;
                    var b = 0;
                    angular.forEach($scope.Biodata.Kamar, function(val1, key1) {
                        if (value.IdKamar == val1.IdKamar) {
                            b++;
                        }
                    })
                    if (b == 0)
                        $scope.Biodata.Kamar.push(angular.copy(value));
                } else {
                    angular.forEach($scope.Biodata.Kamar, function(val1, key1) {
                        if (value.IdKamar == val1.IdKamar) {
                            var index = $scope.Biodata.Kamar.indexOf(value);
                            $scope.Biodata.Kamar.splice(index, 1);
                        }
                    })
                }

            })
            if (a == 0) {
                $scope.ButtonProses = false;
            } else
                $scope.ButtonProses = true;
        }
        $scope.BackTanggal = function() {
            $scope.ShowTanggal = true;
            $scope.ShowKamar = false;
        }
        $scope.BackBiodata = function() {
            $scope.ShowBiodata = true;
            $scope.ShowTanggal = false;
        }
        $scope.Proses = function() {
            $scope.Biodata.TanggalCheckin = $scope.TanggalCheckin;
            $scope.Biodata.TanggalCheckout = $scope.TanggalCheckout;
            $http({
                    method: "POST",
                    url: "api/datas/create/CreatePesanan.php",
                    data: $scope.Biodata
                })
                .then(function(response) {

                }, function(error) {
                    alert(error);
                })
        }
    })
    .controller("LoginController", function($scope, $http) {
        $scope.datalogin = {};
        $scope.Login = function() {
            $http({
                    method: "POST",
                    url: "../api/datas/read/Login.php",
                    data: $scope.datalogin
                })
                .then(function(response) {
                    if (response.data.Message == "Success") {
                        window.location.href = "../admin.html";
                    }

                }, function(error) {
                    alert(error.message);
                })
        }


    })
    .controller("HomeController", function($scope, $http) {

    })
    .controller("KamarController", function($scope, $http, DTOptionsBuilder, DTColumnBuilder) {
        $scope.dtOptions = DTOptionsBuilder.newOptions()
            .withPaginationType('full_numbers')
            .withOption('order', [0, 'asc'])
            .withButtons([{
                    extend: 'excelHtml5',
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        // jQuery selector to add a border to the third row
                        $('row c[r*="3"]', sheet).attr('s', '25');
                        // jQuery selector to set the forth row's background gray
                        $('row c[r*="4"]', sheet).attr('s', '5');
                    }
                },
                {
                    extend: "csvHtml5",
                    fileName: "Data_Analysis",
                    exportOptions: {
                        columns: ':visible'
                    },
                    exportData: { decodeEntities: true }
                },
                {
                    extend: "pdfHtml5",
                    fileName: "Data_Analysis",
                    title: "Data Analysis Report",
                    exportOptions: {
                        columns: ':visible'
                    },
                    exportData: { decodeEntities: true }
                },
                {
                    extend: 'print',
                    //text: 'Print current page',
                    autoPrint: true,
                    title: "Data Seleksi",
                    exportOptions: {
                        columns: ':visible'
                    }
                }

            ]);
        $scope.dtColumns = [
            DTColumnBuilder.newColumn('id').withTitle('ID'),
            DTColumnBuilder.newColumn('firstName').withTitle('First name'),
            DTColumnBuilder.newColumn('lastName').withTitle('Last name')
        ];
        $scope.DatasKamar = [];
        $scope.InputKamar = {};
        $scope.InputKamar.Harga = 0;
        $http.get('api/datas/read/Kamar.php').then(function(response) {
            if (response.data.Message != "Gagal" || response.data.Message != undefined) {
                $scope.DatasKamar = response.data.record;
            }
        })
        $scope.Init = function() {

        }
        $scope.Simpan = function() {
            var Data = angular.copy($scope.InputKamar);
            $http({
                    method: "POST",
                    url: "api/datas/create/CreateKamar.php",
                    data: Data
                })
                .then(function(response) {
                    if (response.data.Message == "Success") {
                        $scope.InputKamar.IdKamar = response.data.IdKamar;
                        $scope.DatasKamar.push(angular.copy($scope.InputKamar));
                        alert(response.data.Message);
                        window.location.href = "admin.html#!/Kamar";
                    } else
                        alert(response.data.Message);
                }, function(error) {
                    alert(error.message);
                })


        }
    })
    .controller("TransaksiController", function($scope, $http) {
        $scope.DataPesanan = {};
        $scope.DatasPesanan = [];
        $scope.StatusPembayaran = "Bayar";
        $scope.tampilBayar = false;
        $scope.tombolCheckin = false;
        $scope.PilihanBayar = true;
        $scope.SudahBayar = false;
        $http({
                method: "GET",
                url: "api/datas/read/readPesanan.php"
            })
            .then(function(response) {
                $scope.DatasPesanan = response.data.record;

            }, function(error) {
                alert(error.message);
            })
        $scope.complete = function(string) {
            var output = [];
            $scope.hidethis = false;
            angular.forEach($scope.DatasPesanan, function(item) {
                if (item.KodePesanan.toLowerCase().indexOf(string.toLowerCase()) >= 0) {
                    output.push(item);
                }
            });
            $scope.filterPesanan = output;
            $scope.fillTextbox = function(string) {
                $scope.DataPesanan = string;
                $scope.hidethis = true;
                $scope.BiayaKamar = 0;
                // if ($scope.DataPesanan.Pembayaran == "true") {
                //     $scope.tampilBayar = true;
                //     $scope.PilihanBayar = false;
                //     $scope.SudahBayar = true;
                //     $scope.StatusPembayaran = "Bayar";
                // }
                angular.forEach($scope.DataPesanan.Kamar, function(item) {
                    $scope.BiayaKamar += parseInt(item.Harga);

                })
                $scope.tax = $scope.BiayaKamar * 10 / 100;
                $scope.TotalBayar = $scope.BiayaKamar + $scope.tax;
            }
        }
        $scope.ProsesBayar = function() {
            if ($scope.StatusPembayaran != "Bayar") {
                $scope.tampilBayar = true;
                $scope.tombolCheckin = true;
            } else {
                $scope.tombolCheckin = true;
                $scope.tampilBayar = false;
            }

        }
        $scope.ProsesCheckin = function() {
            $scope.DataPesanan.StatusBayar = $scope.StatusPembayaran;
            $http({
                    method: "POST",
                    url: "api/datas/update/UpdatePesanan.php",
                    data: $scope.DataPesanan
                })
                .then(function(response) {
                    $scope.DataPesanan.Status = response.data.Status;
                    // window.location.reload("admin.html#!/Transaksi", true);
                }, function(error) {
                    alert(error.message);
                })
        }
        $scope.ProsesPrint = function() {
            $scope.DataPesanan.StatusBayar = $scope.StatusPembayaran;
            $http({
                    method: "POST",
                    url: "api/datas/create/CreateDataPrint.php",
                    data: $scope.DataPesanan
                })
                .then(function(response) {
                    // window.location.reload("admin.html#!/Transaksi", true);
                }, function(error) {
                    alert(error.message);
                })
        }
    })
    .controller("LaporanController", function($scope, $http, DTOptionsBuilder, DTColumnBuilder) {
        $scope.DatasLaporan = [];
        $scope.DatasKeseluruhan = [];
        $scope.dtOptions = DTOptionsBuilder.newOptions()
            .withPaginationType('full_numbers')
            .withOption('order', [0, 'asc'])
            .withButtons([{
                    extend: 'excelHtml5',
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        // jQuery selector to add a border to the third row
                        $('row c[r*="3"]', sheet).attr('s', '25');
                        // jQuery selector to set the forth row's background gray
                        $('row c[r*="4"]', sheet).attr('s', '5');
                    }
                },
                {
                    extend: "csvHtml5",
                    fileName: "Data_Analysis",
                    exportOptions: {
                        columns: ':visible'
                    },
                    exportData: { decodeEntities: true }
                },
                {
                    extend: "pdfHtml5",
                    fileName: "Data_Analysis",
                    title: "Laporan Reservasi Hotel",
                    exportOptions: {
                        columns: ':visible'
                    },
                    exportData: { decodeEntities: true }
                },
                {
                    extend: 'print',
                    customize: function(win) {
                        $(win.document.body)
                            .css('font-size', '7pt')
                            .prepend(
                                // '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0; align: center;" />'
                            );

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    },
                    //text: 'Print current page',
                    autoPrint: true,
                    title: function() {
                        return "<div style='font-size: 14px; text-align: center;'>Laporan Reservasi Hotel</div>";
                    },
                    exportOptions: {
                        columns: ':visible'
                    }
                }

            ]);
        $scope.dtColumns = [
            DTColumnBuilder.newColumn('id').withTitle('ID'),
            DTColumnBuilder.newColumn('firstName').withTitle('First name'),
            DTColumnBuilder.newColumn('lastName').withTitle('Last name')
        ];
        $scope.getDate = function() {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!
            var yyyy = today.getFullYear();

            if (dd < 10) {
                dd = '0' + dd
            }

            if (mm < 10) {
                mm = '0' + mm
            }

            today = yyyy + '-' + mm + '-' + dd;
            return today;
        }
        $scope.Total = 0;
        $scope.TotalKeseluruhan = 0;
        $http({
                method: "GET",
                url: "api/datas/read/readPesanan.php"
            })
            .then(function(response) {
                var a = $scope.getDate();
                angular.forEach(response.data.record, function(value) {
                    if (value.Status == "Checkin" && value.TanggalCheckin == a) {
                        $scope.BiayaKamar = 0;
                        angular.forEach(value.Kamar, function(value1) {
                            $scope.BiayaKamar += parseInt(value1.Harga);
                        });
                        $scope.tax = $scope.BiayaKamar * 10 / 100;
                        $scope.TotalBayar = $scope.BiayaKamar + $scope.tax;
                        value.TotalBayar = $scope.TotalBayar;
                        $scope.DatasLaporan.push(value);
                        $scope.Total += $scope.TotalBayar;
                    }
                });
                angular.forEach(response.data.record, function(value) {
                    $scope.BiayaKamar = 0;
                    angular.forEach(value.Kamar, function(value1) {
                        $scope.BiayaKamar += parseInt(value1.Harga);
                    });
                    $scope.tax = $scope.BiayaKamar * 10 / 100;
                    $scope.TotalBayar = $scope.BiayaKamar + $scope.tax;
                    value.TotalBayar = $scope.TotalBayar;
                    $scope.DatasKeseluruhan.push(value);
                    $scope.TotalKeseluruhan += $scope.TotalBayar;
                })
            }, function(error) {
                alert(error.message);
            })
    });