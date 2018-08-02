angular.module("Ctrl", [])
    .controller("BerandaController", function($scope, $http) {
        $scope.DatasKamar = [];
        $http({
                method: "GET",
                url: "api/datas/read/ReadKamar.php"
            })
            .then(function(response) {
                $scope.DatasKamar = response.data.record;
            }, function(error) {
                alert(error.message);
            })
    })
    .controller("ReservasiController", function($scope, $http) {
        $scope.TanggalCheckin;
        $scope.TanggalCheckout;
        $scope.DatasKamar = [];
        $scope.ShowKamar = false;
        $scope.ShowTanggal = false;
        $scope.ShowBiodata = true;

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
                // angular.forEach($scope.DatasKamar, function(value, key) {
                //     if (value.Color == "blue") {
                //         value.Color = "aqua";
                //     }
                // })
                item.Color = "blue";
            } else {
                item.Color = "aqua";
            }
        }
        $scope.BackTanggak = function() {
            $scope.ShowTanggal = true;
            $scope.ShowKamar = false;
        }
        $scope.BackBiodata = function() {
            $scope.ShowBiodata = true;
            $scope.ShowTanggal = false;
        }
    });