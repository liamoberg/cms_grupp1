<?php 
    include 'includes/loginform.php'; 
    if(!empty($_GET['error'])){
        echo $_GET['error'];
        echo "<br>";
    } 
    if(!empty($_GET['message'])) {
          echo $_GET['message'];
          echo "<br>";
    }
   
?>
<a href="includes/signupform.php">Register</a>