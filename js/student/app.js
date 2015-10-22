'use strict';

/* App Module */

var messapp = angular.module('messapp', [
    'ngRoute',
    'ngMaterial',
    'AppControllers',
    'AppServices',
    'AppDirectives',
]);

messapp.config(['$routeProvider', '$locationProvider',
    function($routeProvider, $locationProvider) {
        $routeProvider.
                when('/', {
                    templateUrl: 'partials/student_main.html',
                    controller: 'MainCtrl'
                }).when('/currentmonth',{
                    templateUrl: 'partials/student_currentmonth.html',
                    controller: 'CurrentMonthCtrl'
                }).when('/prevmonths',{
                    templateUrl: 'partials/student_prevmonths.html',
                    controller: 'PrevMonthsCtrl'
                }).when('/forum',{
                    templateUrl: 'partials/student_forum.html',
                    controller: 'ForumCtrl'
                }).when('/ratemess',{
                    templateUrl: 'partials/student_ratemess.html',
                    controller: 'RateMessCtrl'
                });
        $locationProvider.html5Mode(false).hashPrefix('!');
    }]);



