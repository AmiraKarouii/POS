<?php
 session_start();
 session_destroy();
unset($_SESSION['user_name']);
unset($_SESSION['login']);
unset($_SESSION['user_role']);

  
 header("Location: Login.php");

?> 