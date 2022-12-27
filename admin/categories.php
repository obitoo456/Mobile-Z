<?php 
session_start();
include "init.php";


if(isset($_SESSION['id'])){
$action = isset($_GET['action']) ? $_GET['action'] : "manage";


if($action=="manage"){
    $data = getData("categories");
    


?>
<div class="category">
    <h2>Categories</h2>
<div class="container">
<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Total Products</th>
    <th>Date Added</th>
    <th>Controle</th>
</tr>
<?php

foreach($data as $category){

    $total = getCount("product","where c_id =".$category['c_id']);
echo "<tr>";
echo   "<td>".$category['c_id']."</td>";
echo   "<td>".$category['c_name']."</td>";
echo   "<td>".$total ."</td>";
echo   "<td>".$category['c_dateAdded']."</td>";

echo      "<td><a href='?action=delete&id=".$category['c_id'] ."'><img src='layout/imgs/delete.png'/> <span>Delete</span></a>
<a href='?action=update&id=".$category['c_id'] ."'><img src='layout/imgs/update.png'/> <span>Update</span></a>

</td>";

echo "</tr>";
}
?>
</table>
<a href="?action=add"><img src="layout/imgs/add-c.png" alt=""> Add Category</a>

</div>


</div>
<?php
}elseif($action=="delete"){

    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;

if(exists("categories","c_id",$id)>0){

    $stmt = $con->prepare("DELETE FROM categories WHERE c_id=$id");
    $stmt->execute();

    echo cmd("suc","The Category Has Been Deleted ","Check The New List Of Categories :",'categories.php',"Categoies");


};


}elseif($action=="add"){


    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $c_name = $_POST['name'];
        $c_date = $_POST['date'];



       
       if (!exists("product" , "name" , $c_name)){

        $stmt= $con->prepare("INSERT INTO `categories`(`c_name`, `c_dateAdded`) VALUES (?,?)");
        $stmt->execute(array($c_name,$c_date));
        if($stmt){
            echo cmd("suc","The Category Has Been Added ","Check The New List Of Categories :",'categories.php',"Categories");
        }
       }else{
        echo cmd("err","The Category Already Exists ","Check The New List Of Categories :",'categories.php',"Categories");
    }


    }

?>
    <div class="add-page">
        <h2>Add Category</h2>
        <div class="container">
        <div class="img">
        <div class="head-sec">
        <img src="layout/imgs/add-c.svg" alt="">
        <p>Feel Free To Add New Categories</p>
        </div>
    </div>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <label for="">Category Name</label>
                <input type="text" name="name">
                <label for="">Added Date</label>
                <input type="date" name="date">
               
                <input type="submit" value="Add Category">
            </form>
        </div>
    </div>




<?php
}elseif($action == "update"){

    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;
    $data = getSpeData("categories","c_id",$id);

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $c_name = $_POST['name'];
        $c_date = $_POST['date'];
        $c_id  = $_POST['id'];


       
       if (exists("categories" , "c_name" , $c_name) == 1){

        $stmt= $con->prepare("UPDATE `categories` SET `c_name`=?,`c_dateAdded`=? WHERE `c_id`=?");
        $stmt->execute(array($c_name,$c_date,$c_id));
        if($stmt){
            echo cmd("suc","The Category Has Been Updated ","Check The New List Of Categories :",'categories.php',"Categories");

        }
       }else{
        echo cmd("err","The Category Not Exists ","Check The List Of Categories :",'categories.php',"Categories");
       }


    }

?>
<div class="add-page">
    <h2>Update A Category</h2>        
<div class="container">
        <div class="img">
        <div class="head-sec">
        <img src="layout/imgs/manage.svg" alt="">
        <p>Manage Categories</p>
        </div>
    </div>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <label for="">Category Name</label>
                <input type="hidden" name="id" value="<?php echo $data['c_id'] ?>">
                <input type="text" name="name" value="<?php echo $data['c_name'] ?>">
                <label for="">Added Date</label>
                <input type="date" name="date" value="<?php echo $data['c_dateAdded'] ?>">
               
                <input type="submit" value="Add Category">
            </form>
        </div>
    </div>




<?php
}




}else{

    header("location:login.php");
}



?>