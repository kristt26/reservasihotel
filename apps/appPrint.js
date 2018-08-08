var app = angular.module("apps", [])

.controller("printController", function($scope, $http) {
    $scope.DataPrint = {};
    $scope.Date = new Date();
    $scope.BiayaKamar = 0;
    $http({
            method: "get",
            url: "../../api/datas/read/ReadDataPrint.php"
        })
        .then(function(response) {
            $scope.DataPrint = response.data;
            angular.forEach($scope.DataPrint.Kamar, function(value) {
                $scope.BiayaKamar += parseInt(value.Harga);
            });
            $scope.tax = $scope.BiayaKamar * 10 / 100;
            $scope.TotalBayar = $scope.BiayaKamar + $scope.tax;
        }, function(error) {
            alert(error.message);
        });

});