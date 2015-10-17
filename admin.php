<!DOCTYPE html>
<html lang="en" ng-app="messapp">
    <head>
        <title>Mess Management System 1.0</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen"/>
        <link rel="stylesheet" href="css/material.min.css" media="screen"/>
        <link rel="stylesheet" href="css/styles.css" media="screen" />

        <script src="js/libs/jquery-1.11.3.min.js"></script>
        <script src="js/libs/jquery.validate.min.js"></script>
        <script src="./js/libs/dynamics.min.js"></script>
        <script src="js/libs/angular.min.js"></script>
        <script src="js/libs/angular-route.min.js"></script>
        <script src="js/libs/angular-resource.min.js"></script>
        <script src="js/libs/material.min.js"></script>

        <script src="js/admin/app.js"></script>
        <script src="js/admin/controllers.js"></script>
        <script src="js/admin/services.js"></script>
        <script src="js/directives.js"></script>

        <style>

            

        </style>

    </head>
    <body >


        <!-- No header, and the drawer stays open on larger screens (fixed drawer). -->
        <div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer">
            <div class="mdl-layout__drawer sidenav">
                <div class="title"><p class="text">Anas M</p></div>
                <nav class="mdl-navigation">
                    <a class="mdl-navigation__link" href="">Mess Card Entry</a>
                    <a class="mdl-navigation__link" href="">Extras Entry</a>
                    <a class="mdl-navigation__link" href="">Mess Cuts</a>
                    <a class="mdl-navigation__link" href="">Billings</a>
                    <a class="mdl-navigation__link" href="">Mess Info</a>
                    
                </nav>
            </div>
            <main class="mdl-layout__content">
                <div class="page-content">
                    <div class="header">
                        <h3>Mess Management System 1.0</h3>
                    </div>
                </div>
            </main>
        </div>


        <!--div  class="container-fluid" ng-controller="AdminCtrl">
            <div class="sidenav">
                <div class="sidenavheader">
                    <p>Anas M</p>
                </div>
                <ul>
                    <li></li>
                    <li></li>
                </ul>
                
            </div>
            
            <div class="row">
                <div class="col-md-10 col-md-offset-2">
                    <div class="header">
                        <h2>Mess Management System 1.0</h2>
                    </div>
                    <div ng-view class="main-container" >
                </div>
                
            </div>  

        </div-->

    </body>
</html>