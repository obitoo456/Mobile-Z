<?php 
session_start();

include "init.php";


if($_SERVER['REQUEST_METHOD']=="POST"){
    if(isset($_POST['login'])){
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $stmt = $con->prepare('SELECT * from user WHERE email = ? AND password = ?');
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
if(isset($_POST['signup'])){
    $fname = $_POST['f_name'];
    $lname = $_POST['l_name'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];

     
    if (!exists("user" , "email " , $email)){

        $stmt= $con->prepare("INSERT INTO `user`(`f_name`, `l_name`, `email`, `password`) VALUES (?,?,?,?)");
        $stmt->execute(array($fname,$lname,$email,$pass));
        if($stmt){
            echo cmd("suc","Your Account Has Created Succefly","You Can Use It Now From Here:",'login.php',"Login");
        }
       }else{
       echo cmd("err","This Email Is Already Exsists","Try Again:",'login.php',"Login");
       }

}

}




?>
<style >
    body{
        background-color: #e2e2e5;
    }
</style>

<div class="login">
    <div class="container"> 
        <div class="btn-ctl">
            <button class="active" data-f="login">Login</button>
            <button data-f="signup">SignUp</button>
        </div>
        <div class="login forms active" data-f="login">
            <h2>Login</h2>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
        <label for="">Email</label>
        <input type="email" name="email">
        <label for="">Password</label>
        <input type="password" name="pass">
        <input type="submit" value="Login" name="login">
    </form>
        </div>
        <div class="signup forms" data-f="signup">
        <h2>SignUp</h2>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
        <label for="">Full Name</label>
        <input type="text" name="f_name">
        <label for="">Last Name</label>
        <input type="text" name="l_name">
        <label for="">Email</label>
        <input type="email" name="email">
        <label for="">Password</label>
        <input type="password" name="pass">
        <input type="submit" value="Sign Up" name="signup">
        </div>
    </div>
</div>