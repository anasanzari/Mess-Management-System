'use strict';
/* Controllers */
var AppControllers = angular.module('AppControllers', []);

AppControllers.controller('AdminCtrl',
        function AdminCtrl($scope, $location, StudentResources,StudentService) {

            StudentResources.get({querytype: 'studentdetails'}, function (response) {
                console.log(response.data);
                $scope.student = response.data;
                StudentService.setDetails(response.data);

            });
            
            $scope.menu = [{name: 'Current Month', link: 'currentmonth'},
                {name: 'Previous Months', link: 'prevmonths'}, {name: 'Forum', link: 'forum'},
                {name: 'Rate Mess', link: 'ratemess'}, {name: 'Log Out', link: 'logout'}];
            
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
        function MainCtrl($scope) {

        }
);

AppControllers.controller('CurrentMonthCtrl',
        function CurrentMonthCtrl($scope,  StudentResources,StudentService) {
            if(StudentService.getDetails()==null){
                //fetch details .
            }
            $scope.joined = true;
            if(StudentService.getDetails()!=null){
                var details = StudentService.getDetails();
                
                if(details.mess==null){
                    $scope.joined = false;
                   // alert($scope.joined);
                }
            }
            StudentResources.get({querytype: 'monthextralist'}, function (response) {
                console.log(response.data);
                $scope.list = response.data;

            });

            
        }
);

AppControllers.controller('PrevMonthsCtrl',
        function PrevMonthsCtrl($scope, StudentResources, StudentService) {
            StudentResources.get({querytype: 'getmonths'}, function (response) {
                console.log(response.data);
                $scope.months = response.data;
                
            });
            $scope.show = false;

            $scope.onChange = function () {
                if ($scope.selectedMonth) {
                    $scope.show = true;
                    console.log($scope.selectedMonth.format+"-01");
                    var date = StudentService.parseDate($scope.selectedMonth.format+"-01");
                    $scope.totaldays = StudentService.daysInMonth(date.month, date.year);
                    
                    var rollno = StudentService.getDetails().rollno;
                    
                    StudentResources.get({querytype: 'monthbillstudent', rollno: rollno, month: $scope.selectedMonth.format}, function (response) {
                        $scope.details = response.data;
                    });
                    
                }else{
                    $scope.show = false;
                }

            }

            $scope.extratotal = 300;
            $scope.cuts = 5;
            $scope.total = 300;
            $scope.list = [{name: 'Kur kure', amount: '30', time: '5 pm'}, {name: 'Coke', amount: '40', time: '5 pm'}];

        }
);
AppControllers.controller('ForumCtrl',
        function ForumCtrl($scope, StudentResources, StudentService) {
            
            
            
            if(StudentService.getDetails()==null){
                //fetch details .
            }
            $scope.joined = true;
            if(StudentService.getDetails()!=null){
                var details = StudentService.getDetails();
                if(details.mess==null){
                    $scope.joined = false;
                }
            }
            
            
            $scope.canPost = false;
            $scope.isProcessing = false;
            
            
            
            
            
            $scope.change = function(){
                if($scope.comment.length>0){
                    $scope.canPost = true;
                }else{
                    $scope.canPost = false;
                }
            }
            
            StudentResources.get({querytype: 'forum'}, function (response) {
                        $scope.posts = response.data;
            });
            
            var updatePosts = function(){
                StudentResources.get({querytype: 'forum'}, function (response) {
                        $scope.posts = response.data;
                });
            }
            
            $scope.post = function(){
                $scope.isProcessing = true;
                var post = new StudentResources();
                post.comment = $scope.comment; 
                post.$post({querytype: 'forumpost'},function(response){
                     console.log(response);
                     $scope.isProcessing = false;
                     updatePosts();
                });
                $scope.comment = '';
            }
            
           
        }
);

AppControllers.controller('RateMessCtrl',
        function RateMessCtrl($scope, StudentResources, StudentService) {
            
            
            StudentResources.get({querytype: 'ratings'}, function (response) {
                        $scope.messes = response.data;
            });
            
            if(StudentService.getDetails()==null){
                //fetch details .
            }
            $scope.joined = true;
            if(StudentService.getDetails()!=null){
                var details = StudentService.getDetails();
                
                if(details.mess==null){
                    $scope.joined = false;
                }
                $scope.rating = StudentService.getDetails().rating;
            }
            
            
            var updateRatings = function(){
               StudentResources.get({querytype: 'ratings'}, function (response) {
                        $scope.messes = response.data;
                });
            }
            
             $scope.rate = function(rating){
                
                $scope.isProcessing = true;
                var post = new StudentResources();
                post.ratingval = rating;
                post.$post({querytype: 'ratemess'},function(response){
                    
                     $scope.isProcessing = false;
                     updateRatings();
                });
                
            }
            
        }
);