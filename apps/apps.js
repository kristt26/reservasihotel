var app = angular.module("apps", ["ngRoute", "Ctrl"])
    .config(function($routeProvider) {  
        $routeProvider
            .when("/Beranda", {
                templateUrl: "apps/Views/Beranda.html",
                controller: "BerandaController"
            })
            .when("/Kamar", {
                templateUrl: "apps/view/Kriteria.html",
                controller: "KriteriaController"
            })
            .when("/Reservasi", {
                templateUrl: "apps/views/Reservasi.html",
                controller: "ReservasiController"
            })
            .otherwise({ redirectTo: '' });
    });