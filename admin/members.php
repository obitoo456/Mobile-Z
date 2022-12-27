<?php 
session_start();
include "init.php";


if(isset($_SESSION['id'])){
$action = isset($_GET['action']) ? $_GET['action'] : "manage";


if($action=="manage"){
    $data = getData("user");
?>
<div class="members">
    <h2>Members</h2>
<div class="container">
<table>
<tr>
    <th>ID</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Email</th>
    <th>ADMIN</th>
    <th>Controle</th>
</tr>
<?php

foreach($data as $member){
echo "<tr>";
echo   "<td>".$member['user_id']."</td>";
echo   "<td>".$member['f_name']."</td>";
echo   "<td>".$member['l_name']."</td>";
echo   "<td>".$member['email']."</td>";
echo   "<td>"; echo $member['admin'] == 1 ? "Yes":"No" ; echo "</td>";

echo      "<td><a href='?action=delete&id=".$member['user_id'] ."'><img src='layout/imgs/delete.png'/> <span>Delete</span></a>
<a href='?action=update&id=".$member['user_id'] ."'><img src='layout/imgs/update.png'/> <span>Update</span></a>

</td>";

echo "</tr>";
}
?>
</table>
<a href="?action=add"><img src="layout/imgs/add.png"> Add Member</a>

</div>


</div>
<?php
}elseif($action=="delete"){

    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;

if(exists("user","user_id",$id)>0){

    $stmt = $con->prepare("DELETE FROM user WHERE user_id=$id");
    $stmt->execute();

    echo cmd("suc","The Member Has Been Deleted ","Check The New List Of Members :",'members.php',"Members");


};


}elseif($action=="add"){


    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $admin= $_POST['admin'];
        // $c_date = $_POST['date'];



       
       if (!exists("user" , "email " , $email)){

        $stmt= $con->prepare("INSERT INTO `user`(`f_name`, `l_name`, `email`, `password`, `admin`) VALUES (?,?,?,?,?)");
        $stmt->execute(array($fname,$lname,$email,$pass,$admin));
        if($stmt){
            echo cmd("suc","The Member Has Been Added","Check The New List Of Members :",'members.php',"Members");
        }
       }else{
        echo cmd("err","The Member Already Exists ","Check The  List Of Members :",'members.php',"Members");
       }


    }

?>
    <div class="add-page">
        <h2>Add Member</h2>
        <div class="container">
             <div class="img">
        <div class="head-sec">
        <img src="layout/imgs/add-user.svg" alt="">
        <p>Feel Free To Add New Members</p>

    </div>
        </div>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <label for="">First Name</label>
                <input type="text" name="fname">
                <label for="">Last Name</label>
                <input type="text" name="lname">
                <label for="">Email</label>
                <input type="text" name="email">
                <label for="">Password</label>
                <input type="password" name="pass">
                <label for="">Admin</label>
                <div class="choisi">
                <div class="yes">
                <label for="">Yes</label>
                <input type="radio" name="admin" value="1">

                </div>    
                <div class="no">
                <label for="">No</label>
                <input type="radio" name="admin" value="0">

                </div>      
                </div>      
                <input type="submit" value="Add Member">
            </form>
        </div>
    </div>




<?php
}elseif($action == "update"){

    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;
    $data = getSpeData("user","user_id",$id);

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $f_name = $_POST['fname'];
        $l_name = $_POST['lname'];
        $email  = $_POST['email'];
        $pass  = $_POST['pass'];
        $admin = $_POST['admin'];
        $id = $_POST['id'];


       
       if (exists("user" , "email" , $email) == 1){

        $stmt= $con->prepare("UPDATE `user` SET `f_name`=?,`l_name`=?,`email`=?,`password`=?,`admin`=? WHERE user_id=?");
        $stmt->execute(array($f_name,$l_name,$email,$pass,$admin,$id));
        if($stmt){
            echo cmd("suc","The Member Has Been Updated ","Check The New List Of Members :",'members.php',"Members");
        }
       }else{
        echo cmd("suc","The Member Not Exists ","Check The List Of Members :",'members.php',"Members");
       }


    }

?>
<div class="add-page">
        <h2>Manage</h2>
        <div class="container">
        <div class="img">
        <div class="head-sec">
        <img src="layout/imgs/manage.svg" alt="">
        <p>Manage The Other's Informations</p>

    </div>
        </div>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <label for="">First Name</label>
                <input type="text" name="fname" value="<?php echo $data['f_name'] ?>">
                <input type="hidden" name="id" value="<?php echo $data['user_id'] ?>">
                <label for="">Last Name</label>
                <input type="text" name="lname" value="<?php echo $data['l_name'] ?>">
                <label for="">Email</label>
                <input type="text" name="email" value="<?php echo $data['email'] ?>">
                <label for="">Password</label>
                <input type="password" name="pass" value="<?php echo $data['password'] ?>">
                <label for="">Admin</label>
                <div class="choisi">
                <div class="yes">
                <label for="">Yes</label>
                <input type="radio" name="admin" value="1" <?php echo $data['admin'] == 1 ? "checked" : "" ?>>

                </div>    
                <div class="no">
                <label for="">No</label>
                <input type="radio" name="admin" value="0" <?php echo $data['admin'] == 0 ? "checked" : "" ?>>

                </div>      
                </div>      
                <input type="submit" value="Add Member">
            </form>
        </div>
    </div>




<?php
}




}else{

    header("location:login.php");
}



?>