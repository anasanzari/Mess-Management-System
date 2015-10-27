'use strict';

/* App Module */

var messapp = angular.module('messapp', [
    'ngRoute',
    'ngMaterial',
    'AppControllers',
    'AppServices',
    'AppDirectives',
    'chart.js'
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
                }).when('/billings/:name/:id/:month',{
                    templateUrl: 'partials/admin_billmember.html',
                    controller: 'BillMemberCtrl'
                }).when('/analysis',{
                    templateUrl: 'partials/admin_analysis.html',
                    controller: 'AnalysisCtrl'
                }).when('/forum',{
                    templateUrl: 'partials/admin_forum.html',
                    controller: 'ForumCtrl'
                }).when('/messinfo',{
                    templateUrl: 'partials/admin_messinfo.html',
                    controller: 'MessInfoCtrl'
                });
        $locationProvider.html5Mode(false).hashPrefix('!');
    }]);



