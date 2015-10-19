'use strict';

/* App Module */

var messapp = angular.module('messapp', [
    'ngRoute',
    'ngMaterial',
    'AppControllers',
    'AppServices',
    'AppDirectives'
]);

messapp.config(['$routeProvider', '$locationProvider',
    function($routeProvider, $locationProvider) {
        $routeProvider.
                when('/', {
                    templateUrl: 'partials/admin_main.html',
                    controller: 'MainCtrl'
                }).when('/messentry',{
                    templateUrl: 'partials/admin_messcardentry.html',
                    controller: 'MessEntryCtrl'
                }).when('/extrasentry',{
                    templateUrl: 'partials/admin_extrasentry.html',
                    controller: 'ExtrasEntryCtrl'
                }).when('/messcuts',{
                    templateUrl: 'partials/admin_messcut.html',
                    controller: 'MessCutCtrl'
                }).when('/billings',{
                    templateUrl: 'partials/admin_billings.html',
                    controller: 'BillingsCtrl'
                });
        $locationProvider.html5Mode(false).hashPrefix('!');
    }]);



