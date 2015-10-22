'use strict';
/* Controllers */
var AppControllers = angular.module('AppControllers', []);

AppControllers.controller('AdminCtrl',
        function AdminCtrl($scope, $location, $rootScope) {
            $scope.title = "Admin Hello";
            $scope.menu = [{name: 'Mess Card Entry', link: 'messentry'},
                {name: 'Extras Entry', link: 'extrasentry'}, {name: 'Mess Cuts', link: 'messcuts'},
                {name: 'Billings', link: 'billings'}, {name: 'Analysis', link: 'analysis'},
                {name: 'Forum', link: 'forum'}, {name: 'Mess Info', link: 'messinfo'}];
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
        function MessEntryCtrl($scope, $location, $rootScope, $log, AdminResources) {

            $scope.isDisabled = false;

            $scope.querySearch = querySearch;
            $scope.selectedItemChange = selectedItemChange;
            $scope.searchTextChange = searchTextChange;

            AdminResources.get({querytype: 'added_students'}, function (response) {
                $scope.addedMembers = response.data;
            });

            AdminResources.get({querytype: 'available_students'}, function (response) {
                $scope.members = response.data;
            });


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

            }
            function selectedItemChange(item) {

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
        function ExtrasEntryCtrl($scope, $location, $rootScope, AdminResources) {

            $scope.memberSearch = memberSearch;
            $scope.extraSearch = extraSearch;
            $scope.addedMember = [];
            $scope.extras = [];
            $scope.history = [];

            AdminResources.get({querytype: 'added_students'}, function (response) {
                $scope.addedMembers = response.data;
            });
            AdminResources.get({querytype: 'allextras'}, function (response) {
                $scope.extras = response.data;
            });
            AdminResources.get({querytype: 'extras_history'}, function (response) {
                $scope.history = response.data;
            });

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
        function MessCutCtrl($scope, $location, $rootScope, AdminResources) {
            $scope.memberSearch = memberSearch;

            $scope.addedMembers = [];
            $scope.history = [];
            
            AdminResources.get({querytype: 'added_students'}, function (response) {
                $scope.addedMembers = response.data;
            });

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
        function BillingsCtrl($scope, $location, $rootScope,AdminResources,AdminService) {
            
            $scope.billings = [];
            AdminResources.get({querytype: 'billings'}, function (response) {
                $scope.billings = response.data;
                var date = AdminService.parseDate('2015-10-01');
                $scope.totaldays = AdminService.daysInMonth(date.month,date.year);
            });

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
        function AnalysisCtrl($scope, $location, $rootScope,AdminResources) {

            $scope.list = [];
            $scope.labels = [];
            $scope.amount = [];
            $scope.count = [];
            AdminResources.get({querytype: 'analysis'}, function (response) {
                $scope.list = response.data;
                for (var i = 0; i < $scope.list.length; i++) {
                    console.log($scope.list[i].amount+":"+$scope.list[i].count);
                    $scope.labels[i] = $scope.list[i].name;
                    $scope.amount[i] = $scope.list[i].amount;
                    $scope.count[i] = $scope.list[i].count;
                }
                $scope.data = $scope.amount;
                $scope.current = 'amount';
                $scope.changeto = 'count';
            });
            
            $scope.colors = ['#97BBCD', '#DCDCDC', '#F7464A', '#46BFBD', '#FDB45C', '#949FB1', '#4D5360', '#1CBB9B',
                '#2DCC70', '#3598DB', '#AE7AC4', '#354A5F', '#F2C311', '#E67F22', '#E84C3D', '#ED2458', '#2D54B8',
                '#15B35C', '#F88505', '#FBBF4F', '#C1A985', '#FF6F69', '#BF235E', '#FF3155', '#49F770', '#FF3155',
                '#BA097D', '#F49600', '#1AA3A3', '#EA0F23', '#6C5871', '#C2CF99'];
            $scope.len = $scope.colors.length;

            $scope.change = function () {
                var temp = $scope.current;
                $scope.current = $scope.changeto;
                $scope.changeto = temp;
                if ($scope.current == 'count') {
                    $scope.data = $scope.count;
                } else {
                    $scope.data = $scope.amount;
                }
            }



        }
);

AppControllers.controller('ForumCtrl',
        function ForumCtrl($scope, AdminResources) {
             AdminResources.get({querytype: 'forum'}, function (response) {
                $scope.posts = response.data;
            });
        }
);


AppControllers.controller('MessInfoCtrl',
        function BillMemberCtrl($scope,AdminResources ) {
            
            AdminResources.get({querytype: 'messinfo'}, function (response) {
                 
                 $scope.data = response.data;
            });
           
        }
);
