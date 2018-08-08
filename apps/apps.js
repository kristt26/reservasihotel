var app = angular.module("apps", ["ngRoute", "Ctrl", "datatables", "datatables.buttons"])
    .config(function($routeProvider) {  
        $routeProvider
            .when("/Beranda", {
                templateUrl: "apps/Views/Beranda.html",
                controller: "BerandaController"
            })
            .when("/Kamar", {
                templateUrl: "apps/View/Kriteria.html",
                controller: "KriteriaController"
            })
            .when("/Reservasi", {
                templateUrl: "apps/Views/Reservasi.html",
                controller: "ReservasiController"
            })
            .when("/Home", {
                templateUrl: "apps/Views/Home.html",
                controller: "HomeController"
            })
            .when("/Kamar", {
                templateUrl: "apps/Views/Kamar.html",
                controller: "KamarController"
            })
            .when("/Transaksi", {
                templateUrl: "apps/Views/Transaksi.html",
                controller: "TransaksiController"
            })
            .when("/Laporan", {
                templateUrl: "apps/Views/Laporan.html",
                controller: "LaporanController"
            })
            .otherwise({ redirectTo: '' });
    })
    .directive('currencyInput', function($filter, $browser) {
        return {
            require: 'ngModel',
            link: function($scope, $element, $attrs, ngModelCtrl) {
                var listener = function() {
                    var value = $element.val().replace(/,/g, '')
                    $element.val($filter('number')(value, false))
                }

                // This runs when we update the text field
                ngModelCtrl.$parsers.push(function(viewValue) {
                    return viewValue.replace(/,/g, '');
                })

                // This runs when the model gets updated on the scope directly and keeps our view in sync
                ngModelCtrl.$render = function() {
                    $element.val($filter('number')(ngModelCtrl.$viewValue, false))
                }

                $element.bind('change', listener)
                $element.bind('keydown', function(event) {
                    var key = event.keyCode
                        // If the keys include the CTRL, SHIFT, ALT, or META keys, or the arrow keys, do nothing.
                        // This lets us support copy and paste too
                    if (key == 91 || (15 < key && key < 19) || (37 <= key && key <= 40))
                        return
                    $browser.defer(listener) // Have to do this or changes don't get picked up properly
                })

                $element.bind('paste cut', function() {
                    $browser.defer(listener)
                })
            }

        }
    });