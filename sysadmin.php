<?php

require_once './api/connection.php';

if(isset($_POST['username'])&&isset($_POST['password'])){
    $user = escape($_POST['username']);
    $pass = escape($_POST['password']);
    if($user=="admin"&&$pass="1234"){
        $_SESSION['logged'] = true;
    }else{
        //unset($_SESSION['logged']);
        $errmsg = "Invalid login attempt.";
    }
}

if(isset($_SESSION['logged'])){
    $logged = true;
}else{
    $logged = false;
}

if($logged&&isset($_POST['type'])){
    
    $type = $_POST['type'];
    if($type=="addmess"){
        
        $id = $_POST['messid'];
        $pass = $_POST['password'];
        $coordinator = $_POST['coordinator'];
        $name = $_POST['messname'];
        $perdayrate = $_POST['perdayrate'];
        $sql = "insert into mess values('$id','$pass','$coordinator','$name','$perdayrate');";
        if($conn->query($sql)){
            
        }else{
            $erraddmess = "Invalid Operation. Check the mess id.";
        }
        
    }else if($type=="addextra"){
        $id = $_POST['extraid'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        
        $sql = "insert into extras values('$id','$name','$price');";
        if($conn->query($sql)){
            
        }else{
            $erraddextra = "Invalid Operation. Check the extra id.";
        }
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
        
        <style>
            h2{
              font-size: 2.5rem;  
            }
            h3{
               font-size: 1.5 rem;
               color:#D9534F; 
            }
        </style>
       
    </head>
    <body>
        <?php if(!$logged){ ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-md-offset-3" style="margin-top: 100px">
                    <div style="position: relative">
                        <img src="./images/mess.png" class="himg" />
                        <h1>Administrator Login</h1>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 50px">
                <div class="col-md-6 col-md-offset-3">
                    <div class="flip-container">
                        <div class="flipper">  
                            <div class="front">
                                <form method="POST" action="sysadmin.php">
                                    
                                    <p style="color:#ff6666"><?= isset($errmsg) ? $errmsg : "" ?></php>
                                    <div class="form-group">
                                        <label>Admin name</label>
                                        <input type="text" name="username" class="form-control"  placeholder="Username/rollno">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Password">
                                    </div>
                                   
                                    <button type="submit" class="btn btn-default">Submit</button>
                                    
                                </form>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php }else{ ?>
        <!--- end of Login section -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 col-md-offset-1" style="margin-top: 100px">
                    <h2>Administrator</h2>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <h3>Add Mess</h3>
                                <form method="POST" action="sysadmin.php">
                                    <input type="hidden" name="type" value="addmess" />
                                    <p style="color:#ff6666"><?= isset($erraddmess) ? $erraddmess : "" ?></php>
                                    <div class="form-group">
                                        <label>MessId</label>
                                        <input type="text" name="messid" class="form-control"  placeholder="messid" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="text" name="password" class="form-control" placeholder="Password"  required>
                                    </div>
                                    <div class="form-group">
                                        <label>Coordinator</label>
                                        <input type="text" name="coordinator" class="form-control" placeholder="coordinator"  required>
                                    </div>
                                    <div class="form-group">
                                        <label>MessName</label>
                                        <input type="text" name="messname" class="form-control" placeholder="messname"  required>
                                    </div>
                                    <div class="form-group">
                                        <label>Per day rate</label>
                                        <input type="number" name="perdayrate" class="form-control" placeholder="rate"  required>
                                    </div>
                                    <button type="submit" class="btn btn-default">Submit</button>
                                    
                                </form>
                            </div>
                            <div class="col-md-6">
                                <h3>List of Messes</h3>
                                <div style="max-height: 500px;overflow: auto">
                                <table class="table">
                                    <tr><th>Mess ID</th>
                                        <th>Coordinator</th>
                                        <th>MessName</th>
                                        <th>Per Day Rate</th>
                                    </tr>
                                <?php
                                 $sql = "select * from mess;";
                                 $res = $conn->query($sql);
                                 while($r=$res->fetch_assoc()){
                                 ?>
                                    <tr><td><?=$r['MessID']?></td>
                                         <td><?=$r['MessCoordinator']?></td>
                                         <td><?=$r['MessName']?></td>
                                         <td><?=$r['PerDayRate']?></td></tr>
                                 <?php
                                 }
                                 ?>
                                </table>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    <!--- end of add Mess --->
                    
                    
                    
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <h3>Add Extras</h3>
                                <form method="POST" action="sysadmin.php">
                                    <input type="hidden" name="type" value="addextra" />
                                    <p style="color:#ff6666"><?= isset($erraddextra) ? $erraddextra: "" ?></php>
                                    <div class="form-group">
                                        <label>ExtrasId</label>
                                        <input type="text" name="extraid" class="form-control"  placeholder="extrasid" required>
                                    </div>
                                    <div class="form-group">
                                        <label>ExtrasName</label>
                                        <input type="text" name="name" class="form-control" placeholder="name"  required>
                                    </div>
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="number" name="price" class="form-control" placeholder="price"  required>
                                    </div>
                                   
                                    <button type="submit" class="btn btn-default">Submit</button>
                                    
                                </form>
                            </div>
                            <div class="col-md-6">
                                <h3>List of Extras</h3>
                                <div style="max-height: 500px;overflow: auto">
                                <table class="table">
                                    <tr><th>ExtrasID</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        
                                    </tr>
                                <?php
                                 $sql = "select * from extras;";
                                 $res = $conn->query($sql);
                                 while($r=$res->fetch_assoc()){
                                 ?>
                                    <tr><td><?=$r['ExtrasID']?></td>
                                         <td><?=$r['ExtrasName']?></td>
                                         <td><?=$r['Price']?></td></tr>
                                 <?php
                                 }
                                 ?>
                                </table>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>


        <?php } ?>
        
        
        <div style="min-height: 100px"></div>
        
    </body>
</html>


