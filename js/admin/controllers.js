'use strict';
/* Controllers */
var AppControllers = angular.module('AppControllers', []);

AppControllers.controller('AdminCtrl',
        function AdminCtrl($scope, $location, $rootScope) {
            $scope.title = "Admin Hello";
            $scope.menu = [{name: 'Mess Card Entry', link: 'messentry'},
                {name: 'Extras Entry', link: 'extrasentry'}, {name: 'Mess Cuts', link: 'messcuts'},
                {name: 'Billings', link: 'billings'}, {name: 'Analysis', link: 'analysis'}, {name: 'Mess Info', link: 'messinfo'}];
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
        function MessEntryCtrl($scope, $location, $rootScope, $log) {

            $scope.isDisabled = false;
            $scope.members = loadAll();
            $scope.querySearch = querySearch;
            $scope.selectedItemChange = selectedItemChange;
            $scope.searchTextChange = searchTextChange;
            $scope.addedMembers = [{rollno: 'b130***cs', name: 'Ahmed P A'}, {rollno: 'b130***cs', name: 'Aakansha N S'}];
            $scope.add = function (item) {
                $scope.addedMembers.unshift(item);
                $scope.searchText = '';
                $scope.selectedItem = undefined;
            }

            function querySearch(query) {
                var results = $scope.members.filter(createFilterFor(query));
                return results;

            }
            function searchTextChange(text) {
                $log.info('Text changed to ' + text);
            }
            function selectedItemChange(item) {
                $log.info('Item changed to ' + JSON.stringify(item));
            }

            function loadAll() {
                var all = [{rollno: 'b130705cs', name: 'Anas M'}, {rollno: 'b130236cs', name: 'Akshye Ap'}];
                return all;
            }

            function createFilterFor(query) {
                var lowercaseQuery = angular.lowercase(query);
                return function filterFn(member) {
                    return (member.rollno.indexOf(lowercaseQuery) === 0);
                };
            }
        }
);

AppControllers.controller('ExtrasEntryCtrl',
        function ExtrasEntryCtrl($scope, $location, $rootScope) {

            $scope.memberSearch = memberSearch;
            $scope.extraSearch = extraSearch;

            $scope.addedMembers = [{rollno: 'b130112cs', name: 'Ahmed P A'}, {rollno: 'b130203cs', name: 'Aakansha N S'}];
            $scope.extras = [{id: '1', name: 'Kur Kure', price: 20.00}, {id: '2', name: 'Oreo Biscuit', price: 30.00}, {id: '3', name: 'Lime Juice', price: 15.00}];
            $scope.history = [];

            $scope.add = function () {
                var item = {rollno: $scope.selectedMember.rollno, name: $scope.selectedExtra.name, price: $scope.selectedExtra.price};
                $scope.history.unshift(item);
                $scope.memberText = '';
                $scope.selectedMember = undefined;
                $scope.extraText = '';
                $scope.selectedExtra = undefined;
            }

            function memberSearch(query) {
                var results = $scope.addedMembers.filter(function (member) {
                    return (member.rollno.indexOf(angular.lowercase(query)) === 0);
                });
                return results;
            }
            function extraSearch(query) {
                var results = $scope.extras.filter(function (extra) {
                    return (extra.name.indexOf(angular.lowercase(query)) === 0);
                });
                return results;
            }

        }
);

AppControllers.controller('MessCutCtrl',
        function MessCutCtrl($scope, $location, $rootScope) {
            $scope.memberSearch = memberSearch;

            $scope.addedMembers = [{rollno: 'b130112cs', name: 'Ahmed P A'}, {rollno: 'b130203cs', name: 'Aakansha N S'}];
            $scope.history = [];

            $scope.add = function () {
                var item = {rollno: $scope.selectedMember.rollno, startDate: $scope.startDate, endDate: $scope.endDate};
                $scope.history.unshift(item);
                $scope.memberText = '';
                $scope.selectedMember = undefined;
                $scope.startDate = undefined;
                $scope.endDate = undefined;

            }

            function memberSearch(query) {
                var results = $scope.addedMembers.filter(function (member) {
                    return (member.rollno.indexOf(angular.lowercase(query)) === 0);
                });
                return results;
            }
        }
);

AppControllers.controller('BillingsCtrl',
        function BillingsCtrl($scope, $location, $rootScope) {
            $scope.billings = [
                {rollno: 'b130705cs', name: 'Anas M', total: 1000},
                {rollno: 'b130236cs', name: 'Akshaye', total: 2000},
                {rollno: 'b130007cs', name: 'Akanksha', total: 3000},
                {rollno: 'b130145cs', name: 'Ahmed P A', total: 4000},
                {rollno: 'b130705cs', name: 'Anas M', total: 1000},
                {rollno: 'b130236cs', name: 'Akshaye', total: 2000},
                {rollno: 'b130007cs', name: 'Akanksha', total: 3000},
                {rollno: 'b130145cs', name: 'Ahmed P A', total: 4000},
                {rollno: 'b130705cs', name: 'Anas M', total: 1000},
                {rollno: 'b130236cs', name: 'Akshaye', total: 2000},
                {rollno: 'b130007cs', name: 'Akanksha', total: 3000},
                {rollno: 'b130145cs', name: 'Ahmed P A', total: 4000}];

            $scope.navigate = function (rollno) {
                $location.path('billings/' + rollno);
            }

        }
);

AppControllers.controller('BillMemberCtrl',
        function BillMemberCtrl($scope, $location, $rootScope, $routeParams) {
            var id = $routeParams.id;
            $scope.member = {rollno: 'b130705cs', name: 'Anas M', days: 15, cuts: 3, rate: 75, extras: 400};
            $scope.history = [{name: 'Kur Kure', price: 20.00}];
        }
);

AppControllers.controller('AnalysisCtrl',
        function AnalysisCtrl($scope, $location, $rootScope) {
            
            $scope.list = [{name:"Kur kure",amount:10,count:5},
            {name:"Lays",amount:20,count:8},
            {name:"Lime Juice",amount:30,count:50},
            {name:"Oreo",amount:40,count:30},
            {name:"Maaza",amount:50,count:10},
            {name:"Coke",amount:25,count:25},
            {name:"Bingo",amount:35,count:60},
            {name:"Kitkat",amount:15,count:10},
            {name:"Apple",amount:22,count:25},
            {name:"Orange",amount:9,count:37}];
            $scope.labels = [];
            $scope.amount = [];
            $scope.count = []
            for(var i=0;i<$scope.list.length;i++){
               $scope.labels[i] = $scope.list[i].name;
               $scope.amount[i] = $scope.list[i].amount;
               $scope.count[i] = $scope.list[i].count;
            }
            $scope.data = $scope.amount;
            
            $scope.current = 'amount';
            $scope.changeto = 'count';
            
            $scope.colors = ['#97BBCD','#DCDCDC','#F7464A','#46BFBD','#FDB45C','#949FB1', '#4D5360','#1CBB9B',
                            '#2DCC70','#3598DB','#AE7AC4','#354A5F','#F2C311','#E67F22','#E84C3D','#ED2458','#2D54B8',
                            '#15B35C','#F88505','#FBBF4F','#C1A985','#FF6F69','#BF235E','#FF3155','#49F770','#FF3155',
                            '#BA097D','#F49600','#1AA3A3','#EA0F23','#6C5871','#C2CF99'];
            $scope.len = $scope.colors.length;
            
            $scope.change = function(){
                var temp = $scope.current;
                $scope.current = $scope.changeto;
                $scope.changeto = temp;
                if($scope.current=='count'){
                    $scope.data = $scope.count;
                }else{
                    $scope.data = $scope.amount;
                }
            }
            
            
            
        }
);


AppControllers.controller('MessInfoCtrl',
        function BillMemberCtrl($scope, $location, $rootScope, $routeParams) {
           $scope.messname = 'C';
           $scope.coordinator = 'Rahul';
           $scope.phone = '9568721258';
        }
);
