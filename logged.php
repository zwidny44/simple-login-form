<?php
    
   session_start();
    
   if(!isset($_POST['login']) && !isset($_POST['password'])){
      header('Location: index.php');
      exit();
   }

   require_once 'connect.php';
    
   $conn = new mysqli($host, $db_user, $db_password, $db_name);
    
   if($conn->connect_errno!=0){
      echo "Error:".$conn->connect_errno;
   }else{
        
      $login = $_POST['login'];
      $password = $_POST['password'];
        
      $login = htmlentities($login, ENT_QUOTES, "UTF-8");
      $password = htmlentities($password, ENT_QUOTES, "UTF-8");
        
//      $sql = "SELECT * FROM users WHERE user='$login' AND pass='$password'";
        
      if($result = $conn->query(sprintf("SELECT * FROM users WHERE user='%s' AND pass='%s'", 
      mysqli_real_escape_string($conn, $login), 
      mysqli_real_escape_string($conn, $password)))){

         $num = $result->num_rows;
         if($num>0){

            $_SESSION['logged'] = TRUE;
            unset($_SESSION['error']);

            $result->free_result();
            echo "Logged in";

         }else{

            $_SESSION['error'] = '<span sytle="color:red">Wrong login of password!</span>';
            header('Location: index.php');

         }
      }
      $conn->close(); 
   }
?>