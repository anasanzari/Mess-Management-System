'use strict';

var AppServices = angular.module('AppServices', ['ngResource']);

var baseUrl = "http://localhost/Db/DBMS-Project/api/";

AppServices.factory('AdminResources',
        function ($resource) {
            return $resource(baseUrl + "get.php", {querytype: '@querytype'},
            {
                get: {method: 'GET', cache: false, isArray: false},
                
            });
        });

AppServices.service('AdminService',
        function AdminService() {


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
            
            return {
                daysInMonth: daysInMonth,
                parseDate: parseDate
            }

            /* var addedStudents = [];
             var isupdated_addedStudents = false;
             var availableStudents = [];
             var isupdated_availableSudents = false;
             
             var getAddedStudents = function(){
             if(isupdated_addedStudents) return;
             AdminFactory.get({querytype:'added_students'},
             function success(response){
             console.log(response);
             if(response.status=='success'){
             isupdated_addedStudents = true;
             addedStudents = response;
             }else{
             
             }
             
             },
             function error(res){
             
             }
             );
             };
             getAddedStudents();
             
             
             return {
             addedStudents:addedStudents,
             availableStudents:availableStudents
             
             }*/

        }

);
