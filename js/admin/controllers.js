'use strict';
/* Controllers */
var AppControllers = angular.module('AppControllers', []);

AppControllers.controller('AdminCtrl',
        function AdminCtrl($scope, $location, $rootScope, AdminResources,AdminService) {

            AdminResources.get({querytype: 'messdetails'}, function (response) {
                $scope.messDetails = response.data;
                AdminService.setDetails(response.data);
            });

            $scope.menu = [{name: 'Mess Card Entry', link: 'messentry'},
                {name: 'Extras Entry', link: 'extrasentry'}, {name: 'Mess Cuts', link: 'messcuts'},
                {name: 'Billings', link: 'billings'}, {name: 'Analysis', link: 'analysis'},
                {name: 'Forum', link: 'forum'}, {name: 'Mess Info', link: 'messinfo'}, {name: 'Log Out', link: 'logout'}];
            $scope.current = "";

            $scope.navigate = function (link) {
                $scope.current = link;
                if (link == 'logout') {
                    location.href = "./logout.php";
                }
                $location.path(link);
            }
        }
);

AppControllers.controller('MainCtrl',
        function MainCtrl($scope, AdminResources) {



        }
);


AppControllers.controller('MessEntryCtrl',
        function MessEntryCtrl($scope, $location, $rootScope, $log, AdminResources) {

            $scope.isDisabled = true;
            $scope.isProcessing = false;

            $scope.querySearch = querySearch;
            $scope.selectedItemChange = selectedItemChange;
            $scope.searchTextChange = searchTextChange;

            AdminResources.get({querytype: 'added_students'}, function (response) {
                $scope.addedMembers = response.data;
            });

            var updateAvailable = function () {
                AdminResources.get({querytype: 'available_students'}, function (response) {
                    $scope.members = response.data;
                });
            }
            updateAvailable();


            $scope.add = function (item) {

                $scope.isProcessing = true;
                var post = new AdminResources();
                post.rollno = item.rollno;
                post.$post({querytype: 'messcardentry'}, function (response) {
                    $scope.addedMembers.unshift(item);
                    $scope.isProcessing = false;
                    updateAvailable();
                });
                $scope.searchText = '';
                $scope.selectedItem = undefined;

            }

            function querySearch(query) {
                var results = $scope.members.filter(createFilterFor(query));
                return results;

            }
            function searchTextChange(text) {
                $scope.isDisabled = true;
            }
            function selectedItemChange(item) {
                $scope.isDisabled = false;
                if ($scope.selectedItem == null) {
                    $scope.isDisabled = true;
                }
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
            $scope.isDisabled = true;
            $scope.isProcessing = false;

            $scope.searchTextChange = function (text) {
                $scope.isDisabled = true;
            }
            $scope.selectedItemChange = function (item) {
                $scope.isDisabled = false;

                if ($scope.selectedMember == null || $scope.selectedExtra == null) {
                    $scope.isDisabled = true;
                }
            }
            
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
                var tim = new Date().getTime();
                var item = {rollno: $scope.selectedMember.rollno, name: $scope.selectedExtra.name, price: $scope.selectedExtra.price,
                            time:tim };

                $scope.isProcessing = true;
                var post = new AdminResources();
                post.rollno = $scope.selectedMember.rollno;
                post.extraid = $scope.selectedExtra.id;
                post.$post({querytype: 'addextra'}, function (response) {

                    $scope.history.unshift(item);
                    $scope.isProcessing = false;
                    $scope.isDisabled = false;
                });


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
            $scope.isDisabled = true;
            $scope.isProcessing = false;

            AdminResources.get({querytype: 'added_students'}, function (response) {
                $scope.addedMembers = response.data;
            });

            AdminResources.get({querytype: 'leave_history'}, function (response) {
                $scope.history = response.data;
            });

            $scope.searchTextChange = function (text) {
                $scope.isDisabled = true;
            }
            $scope.selectedItemChange = function (item) {
                $scope.isDisabled = false;
                if ($scope.selectedMember == null || $scope.selectedMember == null || $scope.startDate == null || $scope.endDate == null) {
                    $scope.isDisabled = true;
                }
            }
            $scope.datechange = function () {
                $scope.isDisabled = false;
                if ($scope.startDate == null || $scope.endDate == null) {
                    $scope.isDisabled = true;
                }

            }

            $scope.add = function () {
                var item = {rollno: $scope.selectedMember.rollno, startdate: $scope.startDate, enddate: $scope.endDate};

                $scope.isProcessing = true;
                var post = new AdminResources();
                post.rollno = $scope.selectedMember.rollno;
                post.startdate = $scope.startDate;
                post.enddate = $scope.endDate;
                console.log($scope.endDate);
                post.$post({querytype: 'addleave'}, function (response) {
                    console.log(response);
                    $scope.history.unshift(item);
                    $scope.isProcessing = false;
                    $scope.isDisabled = false;
                });
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
        function BillingsCtrl($scope, $location, $rootScope, AdminResources, AdminService) {

            $scope.billings = [];
            AdminResources.get({querytype: 'getmonths'}, function (response) {
                console.log(response.data);
                $scope.months = response.data;

            });
            $scope.show = false;

            $scope.onChange = function () {
                if ($scope.selectedMonth) {
                    $scope.show = true;
                    var datestr = $scope.selectedMonth.format + "-01";
                    var date = AdminService.parseDate(datestr);
                    $scope.totaldays = AdminService.daysInMonth(date.month, date.year);

                    AdminResources.get({querytype: 'billings', month: $scope.selectedMonth.format}, function (response) {
                        $scope.billings = response.data;

                    });
                } else {
                    $scope.show = false;
                }

            }



            $scope.navigate = function (rollno,name) {
                $location.path('billings/'+name+"/" + rollno + "/" + $scope.selectedMonth.format);
            }

        }
);

AppControllers.controller('BillMemberCtrl',
        function BillMemberCtrl($scope, $routeParams, AdminResources, AdminService) {
            
            var name = $routeParams.name;
            var rollno = $routeParams.id;
            var month = $routeParams.month;
            var datestr = month + "-01";
            $scope.month = datestr;
            var date = AdminService.parseDate(datestr);
            $scope.totaldays = AdminService.daysInMonth(date.month, date.year);
            $scope.name = name;
            $scope.rollno = rollno;
            //$scope.member = {rollno: 'b130705cs', name: 'Anas M', days: 15, cuts: 3, rate: 75, extras: 400};
            //$scope.history = [{name: 'Kur Kure', price: 20.00}];
            AdminResources.get({querytype: 'monthbillstudent', rollno: rollno, month: month}, function (response) {
                $scope.data = response.data;
            });


        }
);

AppControllers.controller('AnalysisCtrl',
        function AnalysisCtrl($scope, $location, $rootScope, AdminResources) {

            $scope.list = [];
            $scope.labels = [];
            $scope.amount = [];
            $scope.count = [];


            AdminResources.get({querytype: 'analysis'}, function (response) {
                $scope.list = response.data;
                if ($scope.list.length != 0) {
                    for (var i = 0; i < $scope.list.length; i++) {
                        console.log($scope.list[i].amount + ":" + $scope.list[i].count);
                        $scope.labels[i] = $scope.list[i].name;
                        $scope.amount[i] = $scope.list[i].amount;
                        $scope.count[i] = $scope.list[i].count;
                    }
                    $scope.data = $scope.amount;
                    $scope.current = 'amount';
                    $scope.changeto = 'count';
                }

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
        function BillMemberCtrl($scope, AdminResources) {

            AdminResources.get({querytype: 'messinfo'}, function (response) {

                $scope.data = response.data;
            });

        }
);
