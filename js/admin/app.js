'use strict';

/* App Module */

var messapp = angular.module('messapp', [
    'ngRoute',   
    'AppControllers',
    'AppServices',
    'AppDirectives'
]);

messapp.config(['$routeProvider', '$locationProvider',
    function($routeProvider, $locationProvider) {
        $routeProvider.
                when('/', {
                    templateUrl: 'partials/admin.html',
                    controller: 'AdminCtrl'
                }).when('/messentry',{
                    templateUrl: 'partials/messcardentry.html',
                    controller: 'MessEntryCtrl'
                }).when('/extrasentry',{
                    templateUrl: 'partials/extrasentry.html',
                    controller: 'ExtraxEntryCtrl'
                });
        $locationProvider.html5Mode(false).hashPrefix('!');
    }]);



