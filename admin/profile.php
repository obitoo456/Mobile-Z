<?php 
session_start();
include "init.php";
if(isset($_SESSION['id'])){

    $id = $_SESSION['id'];
$data = getSpeData("user","user_id",$id);


    if($_SERVER['REQUEST_METHOD']=="POST"){
        $id = $_POST['id'];
        $f_name = $_POST['f_name'];
        $l_name = $_POST['l_name'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $admin = $_POST['admin'];
        $img = $_POST['img'];
        
        if(exists("user","user_id",$id)>0){

            $stmt = $con->prepare('UPDATE `user` SET `f_name`=?,`l_name`=?,`email`=?,`password`=?,`img`=?,`admin`=? WHERE `user_id` = ?');
            $stmt->execute(array($f_name,$l_name,$email,$pass,$img,$admin,$id));
            if($stmt){
                echo cmd("suc","You Profile Has Been Update","Check Your Last Modifcation From Here:",'profile.php',"profile");
            }


        }
            
        
    }




?>
<div class="profile">
        <h2>Profile</h2>
    <div class="container">
        <div class="img">
        <div class="head-sec">
        <p>Hey Soukaina This Your Profile You Wanna Change Something?</p>
        <img src="layout/imgs/concept-of-research-and-development-in-business-startup.svg" alt="">
    </div>
        </div>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
            <label for="">Chose Your Avatar</label>
            <div class="avatars">
            <img  src="layout/imgs<?php echo $data['img'] ?>" alt="">            
            <input type="hidden" name="img" value="<?php echo $data['img'] ?>">  
        </div>
            <label for="">First Name</label>
            <input name="id" type="hidden" value="<?php echo $data['user_id'] ?>">
            <input name="f_name" type="text" value="<?php echo $data['f_name'] ?>">
            <label for="">Last Name</label>
            <input name="l_name" type="text" value="<?php echo $data['l_name'] ?>">
            <label  for="">Email</label>
            <input name="email" type="text" value="<?php echo $data['email'] ?>">
             <label  for="">Password</label>
            <input name="pass" type="password" value="<?php echo $data['password'] ?>">
            <label  for="">Join Date</label>
            <input  type="text" value="<?php echo $data['join_date'] ?> " readonly>
            <label for="">Admin</label>
                <select name="admin">
                    <option value="1" <?php echo $data['admin']==1 ? "selected": null  ?> >YES</option>
                    <option value="0" <?php echo $data['admin']==0 ? "selected": null  ?>>NO</option>
                </select>
            <input type="submit"  value="Send"/>

        </form>

        <div class="box-avatars">   
            <button class="close">x</button>
                <h2>Chose An Avatar:</h2>
            <img src="layout/imgs/avatars/avatar1.svg" alt="">
            <img src="layout/imgs/avatars/avatar2.svg" alt="">
            <img src="layout/imgs/avatars/avatar3.svg" alt="">
            <img src="layout/imgs/avatars/avatar4.svg" alt="">
            <img src="layout/imgs/avatars/avatar5.svg" alt="">
        </div>
    </div>
</div>


<?php 
}else{
    header('location:login.php');
}



?>