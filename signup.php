<?php
$dsn = "mysql:host=localhost;dbname=possystem";

try {
    $pdo = new PDO($dsn, 'root', '');
} catch (PDOException $e) {
    echo $e->getMessage();
} ?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        html,
        body {
            width: 100%;
            height: 100%;
        }

        body {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        label,
        a,
        p,
        h1 {
            color: white;
            justify-content: center;

        }
    </style>

    <title>SignUp Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link href="register.css" rel="stylesheet" type="text/css"/> -->
</head>

<body>

    <?php
    if (isset($_POST['signup'])) {
        $usename = trim($_POST['name']);
        $email = trim($_POST['email']);
        $position = $_POST['position'];
        $sql1 = "SELECT * FROM user WHERE user_email = :email";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->execute([
            ':email' => $email
        ]);
        $countEmail = $stmt1->rowCount();
        if ($countEmail != 0) {
            $error_email_exist = "Email already exists!";
        } else {
            $password = trim($_POST['password']);
            $confirm_password = trim($_POST['pswr']);
            if ($password != $confirm_password) {
                $error = "Password doesn't match";
            } else {
                $sql = "INSERT INTO user (use_name, user_email, user_role, user_pass, user_photo) VALUES (:name, :email, :role, :password, :photo)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':name' => $usename,
                    ':email' => $email,
                    ':role' => $position,
                    ':password' => md5($password),
                    ':photo' => "amira.png",
                ]);
                $success = true;
            }
        }
    }
    ?>



    <form action="signup.php" method="POST" class="mx-auto" style="width: 900px;">


        <h1 class="mx-auto" class="font-weight-light" style="width: 200px;">Sign Up</h1>

        <div class="mx-auto" style="width: 200px;" class="form-group" class="container">
            <label for="name"><b>Username</b></label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Enter Email" name="name" required>

            <label for="email"><b>Email</b></label>
            <input class="form-control" id="exampleFormControlInput1" type="text" placeholder="Enter Email" name="email" required>
        </div>
        <div class="mx-auto" style="width: 200px;" class="form-group" class="container">
            <label for="password"><b>Password</b></label>
            <input class="form-control" id="exampleFormControlInput1" type="password" placeholder="Enter Password" name="password" required>


            <label for="pswr"><b>Confirm Password</b></label>
            <input type="password" class="form-control" id="exampleFormControlInput1" placeholder="Repeat Password" name="pswr" required>


            <label for="position"><strong>Position</strong></label>
            <select class="form-control" id="exampleFormControlInput1" id="position" name="position">
                <option value="Admin">Admin</option>
                <option value="Server">Server</option>
            </select>
        </div>
        <br>

        <div class="mx-auto" style="width: 200px;">
            <a href="Login.php"> <button type="button" class="btn btn-secondary">Cancel</button> </a>
            <button type="submit" name="signup" class="btn btn-primary">Sign Up</button>
            <p>Already have an Account? <a href="login.php"> Login Now!</a></p>
        </div>
        </div>
    </form>




    <?php if (isset($error_email_exist)) {
        function_alert("error {$error_email_exist}");
    } else if (isset($error)) {
        function_alert("error {$error}");
    } else if (isset($success)) {
        function_alert(" Account created successfully.");
        header("Refresh:2;url=./login.php");
    }
    ?>




</body>


<?php


function function_alert($message)
{

    echo "<script>alert('$message');</script>";
}

?>




<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>