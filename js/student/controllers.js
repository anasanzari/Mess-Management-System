'use strict';
/* Controllers */
var AppControllers = angular.module('AppControllers', []);

AppControllers.controller('AdminCtrl',
        function AdminCtrl($scope, $location, $rootScope) {
           
            $scope.menu = [{name: 'Current Month', link: 'currentmonth'},
                {name: 'Previous Months', link: 'prevmonths'}, {name: 'Forum', link: 'forum'},
                {name: 'Rate Mess', link: 'ratemess'}];
            $scope.current = "";

            $scope.navigate = function (link) {
                $scope.current = link;
                $location.path(link);
            }
        }
);

AppControllers.controller('MainCtrl',
        function MainCtrl($scope, $location, $rootScope) {

        }
);

AppControllers.controller('CurrentMonthCtrl',
        function CurrentMonthCtrl($scope, $location, $rootScope) {
            $scope.list = [{name:'Kur kure',amount:'30',time:'5 pm'},{name:'Coke',amount:'40',time:'5 pm'}];
        }
);

AppControllers.controller('PrevMonthsCtrl',
        function PrevMonthsCtrl($scope, $location, $rootScope) {
            $scope.months = ['Jan 2015','Aug 2015'];
            $scope.extratotal = 300;
            $scope.cuts = 5;
            $scope.total = 300;
            $scope.list = [{name:'Kur kure',amount:'30',time:'5 pm'},{name:'Coke',amount:'40',time:'5 pm'}];
        
        }
);
AppControllers.controller('ForumCtrl',
        function ForumCtrl($scope, $location, $rootScope) {
            $scope.posts = [{name:'Anas M',rollno:'b130705cs',time:'5 pm',details:'Great food tonight'}];
        }
);

AppControllers.controller('RateMessCtrl',
        function RateMessCtrl($scope, $location, $rootScope) {
            $scope.messes = [{name:'C Mess',rating:5},{name:'A Mess',rating:2}];
        }
);