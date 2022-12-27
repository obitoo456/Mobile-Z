<?php 
session_start();

$noNavbar="";
include "init.php";


if($_SERVER['REQUEST_METHOD']=="POST"){
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $stmt = $con->prepare('SELECT * from user WHERE email = ? AND password = ? AND admin = 1');
    $stmt->execute(array($email,$pass));

    $count = $stmt->rowCount();
    $row = $stmt->fetch();


    if($count>0){
        
        $_SESSION["email"] = $email;
        
        $_SESSION["pass"] = $pass;
        $_SESSION["id"]=$row["user_id"];
        $_SESSION["name"]=$row["f_name"];
        header('location:index.php');
        exit();
    }
    echo cmd("err","The Email Or Pass Incorrect","Try Again:",'login.php',"Login");
}




?>
<style >
    body{
        background-color: #e2e2e5;
    }
</style>
<div class="login">
    <div class="container">
        <h1>Login</h1>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
        <label for="">Email</label>
        <input type="email" name="email">
        <label for="">Password</label>
        <input type="password" name="pass">
        <input type="submit" value="Login">
    </form>
    </div>
</div>