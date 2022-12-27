<?php
session_start();
include "init.php";

if($_SERVER['REQUEST_METHOD']=="POST"){
    $fname = $_POST["f_name"];
    $email = $_POST["email"];
    $sub = $_POST["subject"];
    $msg = $_POST["msg"];

    $stmt = $con->prepare('INSERT INTO `messages`( `full_name`, `email`, `subject`, `msg`) VALUES (?,?,?,?)');
    $stmt->execute(array($fname,$email,$sub,$msg));
    
 if($stmt){
    echo cmd("suc","Your Message Has been Send","You Loved Our Offers? Check Here There's More:",'index.php',"Offers");
    } 
}


?>



<div class="contact-us">
    <div class="container">
        <h2>Contact Us</h2>
       <div class="content">
        <div class="img">
            <img src="layout/imgs/Contact us.svg" alt="">
        </div>
        <form action="<?php $_SERVER['PHP_SELF']  ?>" method="POST">
            <input type="text" placeholder="Full Name" name="f_name" required  >
            <input type="email" placeholder="Email" name="email" required>
            <input type="text" placeholder="Subject" name="subject" required>
            <textarea placeholder="Your Message"  id="" cols="30" rows="10" name="msg" required></textarea>
            <input type="submit" value="Send"/>
        </form>
    </div></div>
</div>
<?php include "include/template/foot.php" ?>