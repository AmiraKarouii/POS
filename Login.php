<?php include('./includes/db.php')?>
<?php session_start(); ?>
<?php
    if(isset($_SESSION['login']) || isset($_COOKIE['_uid_'])) {
      header("Location: ./menu.php");
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title> POS System </title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
body {
  background-image: url("bg.gif");
 
}
h1{
    color: white;
}
label{
    color: white; 
}
span{
    color: white;
}
</style>

</head>


<body>
<form  class="mx-auto" style="width: 900px;" action="" method="POST">
<br>
    <h1>Login Now!</h1>
  <div class="form-row">
    <div class="col">
       <label for="username"><b>Email</b></label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Username" name="email" required>
    </div>
    <div class="col">
      <label for="psw"><b>Password</b></label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter Password" name="password" required>
    </div>
  </div>
  <br> 
  <button type="submit" name="submit" class="btn btn-primary mb-2" value="submit">Login</button>
<span>Dont have an account? <a href="signup.php">sign up now!</a></span>
</form>

</body>








<?php
                                    if(isset($_POST['submit'])) {
                                        $email = trim($_POST['email']);
                                        $password = trim($_POST['password']);

                                        $sql = "SELECT * FROM user WHERE user_email = :email";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute([
                                            ':email' => $email
                                        ]);
                                        $count = $stmt->rowCount();
                                        if($count == 0) {
                                            $error = "Wrong credentials!";
                                        } else if($count > 1) {
                                            $error = "Wrong credentials!";
                                        } else if($count == 1) {
                                            $user = $stmt->fetch(PDO::FETCH_ASSOC);
                                            $user_password_hash = $user['user_pass'];
                                            $user_role = $user['user_role'];
                                            $user_name = $user['use_name'];
                                            // var_dump($user_name);
                                            if(md5($password) == $user_password_hash) {
                                                $success = "Sign in successful!";
                                                $_SESSION['user_role'] = $user_role;
                                                $_SESSION['login'] = $user;
                                                $_SESSION['user_name'] = $user_name;
                                                if($_SESSION['user_role'] == "Admin"){
                                                    header("Refresh:2;url=./admin/dashboard.php");
                                                }else{
                                                    header("Refresh:2;url=./menu.php");
                                                }
                                                
                                            } else {
                                                $error_password = "Wrong password!";
                                            }
                                        }
                                    }
                                ?>

<?php
//funtion to send a message
function function_alert($message) {
   
    echo "<script>alert('$message');</script>";
}
  
  
                        if(isset($success)) {
                           function_alert("Welcome!{$success}");;
                        }
                        if(isset($error))  {
                            function_alert("Error!{$error}");;
                        } else if(isset($error_password)) {
                            function_alert("Wrong pqssword!{$error_password}");;
                        }
                    ?>



<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>