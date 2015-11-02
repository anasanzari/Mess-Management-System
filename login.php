<?php
require_once './api/connection.php';

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['usertype'])) {
    $username = escape($_POST['username']);
    $password = escape($_POST['password']);
    $usertype = escape($_POST['usertype']);
    if ($usertype == 'student') {
        $sql = "select * from members where RollNo = '$username' and Password = '$password';";

        $res = $conn->query($sql);
        if ($res && $row = $res->fetch_assoc()) {
            $_SESSION['loggedin'] = true;
            $_SESSION['usertype'] = 'student';
            $_SESSION['name'] = $row['MemberName'];
            $_SESSION['rollno'] = $row['RollNo'];
            header('Location: student.php');
        } else {
            //error
            $errmsg = "Sorry. Rollno/Password doesn't match.";
        }
    } else if ($usertype == 'messadmin') {
        $sql = "select * from mess where MessCoordinator = '$username' and MessPassword = '$password';";
        $res = $conn->query($sql);
        if ($res && $row = $res->fetch_assoc()) {

            $_SESSION['loggedin'] = true;
            $_SESSION['usertype'] = 'mess';
            $_SESSION['messname'] = $row['MessName'];
            $_SESSION['mess_id'] = $row['MessID'];
            header('Location: admin.php');
        } else {
            $errmsg = "Sorry. Username/Password doesn't match.";
        }
    }
}

if (isset($_POST['rollno']) && isset($_POST['name']) && isset($_POST['password']) && isset($_POST['phone'])) {
    $rollno = escape($_POST['rollno']);
    $name = escape($_POST['name']);
    $password = escape($_POST['password']);
    $phone = escape($_POST['phone']);
    
    $sql = "insert into members values('$rollno','$name','$password','5','$phone')";
    if($conn->query($sql)){
        $_SESSION['loggedin'] = true;
        $_SESSION['usertype'] = 'student';
        $_SESSION['name'] = $name;
        $_SESSION['rollno'] = $rollno;
        header('Location: student.php');
    }else{
        $errmsg = "Sorry. Something went wrong.";
    }
    
}


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Mess Management System 1.0</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen"/>
        <link rel="stylesheet" href="css/login.css" media="screen">

        <script src="js/libs/jquery-1.11.3.min.js"></script>
        <script src="js/libs/dynamics.min.js"></script>
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
                    <div class="flip-container">
                        <div class="flipper">  
                            <div class="front">
                                <form method="POST" action="login.php">
                                    <input type="hidden" name="type" value="login" />
                                    <p style="color:#ff6666"><?= isset($errmsg) ? $errmsg : "" ?></php>
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
                                    <a href="#" class="signup btn btn-danger">Sign Up</a>
                                </form>
                            </div>
                            <div class="back" style="display:none">
                                <form method="POST" action="login.php">
                                    <input type="hidden" name="type" value="signup" />
                                    <p style="color:#ff6666"><?= isset($errmsg) ? $errmsg : "" ?></php>
                                    <div class="form-group">
                                        <label>Rollno</label>
                                        <input type="text" name="rollno" class="form-control"  placeholder="Rollno" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control"  placeholder="Name" requied>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" name="phone" class="form-control"  placeholder="Phone" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                                    </div>
                                    

                                    <button type="submit" class="btn btn-default">Submit</button>
                                    <a href="#" class="login btn btn-danger">Login</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script>
            var front = $(".front");
            var back = $(".back");

            $(".signup").click(function () {
                front.slideToggle(500);
                back.delay(550).slideToggle(500);
            });
            
            $(".login").click(function () {
                back.slideToggle(500);
                front.delay(550).slideToggle(500);
            });
            
        </script>


    </body>
</html>