<?php 
require_once './api/connection.php';

if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['usertype'])){
    $username = escape($_POST['username']);
    $password = escape($_POST['password']);
    $usertype = escape($_POST['usertype']);
    if($usertype=='student'){
        $sql = "select * from members where RollNo = '$username' and Password = '$password';";
       
        $res = $conn->query($sql);
        if($res&&$row=$res->fetch_assoc()){
            $_SESSION['loggedin'] = true;
            $_SESSION['usertype'] = 'student';
            $_SESSION['name'] = $row['MemberName'];
            $_SESSION['rollno'] = $row['RollNo'];
            header('Location: student.php');
            
        }else{
            //error
            $errmsg = "Sorry. Rollno/Password doesn't match.";
        }
    }else if($usertype=='messadmin'){
        $sql = "select * from mess where MessCoordinator = '$username' and MessPassword = '$password';";
        $res = $conn->query($sql);
        if($res&&$row=$res->fetch_assoc()){
            
            $_SESSION['loggedin'] = true;
            $_SESSION['usertype'] = 'mess';
            $_SESSION['messname'] = $row['MessName'];
            $_SESSION['mess_id'] = $row['MessID'];
            header('Location: admin.php');
            
        }else{
            $errmsg = "Sorry. Username/Password doesn't match.";
        }
            
    }
}


?>
<!DOCTYPE html>
<html lang="en" ng-app="messapp">
    <head>
        <title>Mess Management System 1.0</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen"/>
        <link rel="stylesheet" href="css/login.css" media="screen">

        <script src="js/libs/jquery-1.11.3.min.js"></script>
        <script src="js/libs/angular.min.js"></script>
        <script src="js/libs/angular-route.min.js"></script>
        <script src="js/libs/angular-resource.min.js"></script>
        <script src="js/libs/angular-animate.min.js"></script>
        <script src="js/libs/angular-aria.min.js"></script>


    </head>
    <body>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-md-offset-3" style="margin-top: 100px">
                    <div style="position: relative">
                        <img src="./images/mess.png" class="himg" />
                        <h1>Mess Management System 1.0</h1>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 50px">
                <div class="col-md-6 col-md-offset-3">
                    <form method="POST" action="login.php">
                        <p style="color:#ff6666"><?=isset($errmsg)? $errmsg : ""?></php>
                        <div class="form-group">
                            <label>Username/Rollno</label>
                            <input type="text" name="username" class="form-control"  placeholder="Username/rollno">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="usertype" value="student" checked>
                                Student
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="usertype" value="messadmin">
                                Mess Admin
                            </label>
                        </div>

                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </div>
            </div>
        </div>


    </body>
</html>