'use strict';
/* Controllers */
var AppControllers = angular.module('AppControllers', []);

AppControllers.controller('AdminCtrl',
        function AdminCtrl($scope, $location, $rootScope) {
            $scope.title = "Admin Hello";
            $scope.menu = [{name: 'Mess Card Entry', link: 'messentry'},
                {name: 'Extras Entry', link: 'extrasentry'}, {name: 'Mess Cuts', link: 'messcuts'},
                {name: 'Billings', link: 'billings'}, {name: 'Mess Info', link: 'messinfo'}];
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


AppControllers.controller('MessEntryCtrl',
        function MessEntryCtrl($scope, $location, $rootScope,$log) {
           
             $scope.isDisabled = false;
             $scope.states = loadAll();
             $scope.querySearch = querySearch;
             $scope.selectedItemChange = selectedItemChange;
             $scope.searchTextChange = searchTextChange;
             $scope.addedMembers = [{rollno:'b130***cs',name: 'Ahmed P A'},{rollno:'b130***cs',name: 'Aakansha N S'}];
             $scope.add = function(item){
                 $scope.addedMembers.unshift(item);
                 $scope.searchText = '';
                 $scope.selectedItem= undefined;
             }
            
            function querySearch(query) {
                var results =  $scope.states.filter(createFilterFor(query));
                return results;
                
            }
            function searchTextChange(text) {
                $log.info('Text changed to ' + text);
            }
            function selectedItemChange(item) {
                $log.info('Item changed to ' + JSON.stringify(item));
            }
            
            function loadAll() {
                var all = [{rollno:'b130705cs',name: 'Anas M'},{rollno:'b130236cs',name: 'Akshye Ap'}];
                return all;
            }
            
            function createFilterFor(query) {
                var lowercaseQuery = angular.lowercase(query);
                return function filterFn(state) {
                    return (state.rollno.indexOf(lowercaseQuery) === 0);
                };
            }
        }
);

AppControllers.controller('ExtraxEntryCtrl',
        function MessEntryCtrl($scope, $location, $rootScope) {

        }
);
