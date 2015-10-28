'use strict';

var AppServices = angular.module('AppServices', ['ngResource']);

var baseUrl = "./api/";

AppServices.factory('StudentResources',
        function ($resource) {
            return $resource(baseUrl + "get.php", {querytype: '@querytype'},
            {
                get: {method: 'GET', cache: false, isArray: false},
                post: {method:'POST',cache:false,isArray:false,url:baseUrl+'post.php'},
                
            });
        });

AppServices.service('StudentService',
        function StudentService() {


            function daysInMonth(month, year) {
                return new Date(year, month, 0).getDate();
            }

            function parseDate(str) {
                var split = str.split('-');

                return {
                    year: +str.substr(0, 4),
                    month: +str.substr(5, 2),
                    day: +str.substr(8, 2)
                };
            }
            
             var details = null; //MessID, MessName, MessCoordinator
            
            function setDetails(d){
                details = d;
            }
            
            function getDetails(){
                return details;
            }
            
            return {
                daysInMonth: daysInMonth,
                parseDate: parseDate,
                getDetails: getDetails,
                setDetails: setDetails
            }
        }

);
