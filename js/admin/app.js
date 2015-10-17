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
                })
        $locationProvider.html5Mode(false).hashPrefix('!');
    }]);



