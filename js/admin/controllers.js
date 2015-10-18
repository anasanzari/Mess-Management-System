'use strict';
/* Controllers */
var AppControllers = angular.module('AppControllers', []);

AppControllers.controller('AdminCtrl',
        function AdminCtrl($scope, $location, $rootScope) {
            $scope.title = "Admin Hello";
            
        }
);


AppControllers.controller('MessEntryCtrl',
        function MessEntryCtrl($scope, $location, $rootScope) {
            
        }
);

AppControllers.controller('ExtraxEntryCtrl',
        function MessEntryCtrl($scope, $location, $rootScope) {
            
        }
);
