<?php 
session_start();
include "init.php";


if(isset($_SESSION['id'])){
$action = isset($_GET['action']) ? $_GET['action'] : "manage";


if($action=="manage"){
    $stmt = $con->prepare("SELECT product.*, categories.c_name as cate FROM categories,product WHERE product.c_id = categories.c_id;");
    $stmt->execute();
    $data=$stmt->fetchAll();
?>
<div class="products">
    <h2>Products</h2>
<div class="container">
<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Description</th>
    <th>Prix</th>
    <th>Discount</th>
    <th>Categories ID</th>
    <th>Quantité</th>
    <th>Controle</th>
</tr>
<?php

foreach($data as $product){
echo "<tr>";
echo   "<td>".$product['prd_id']."</td>";
echo   "<td>".$product['name']."</td>";
echo   "<td>".$product['description']."</td>";
echo   "<td>".$product['prix']."$</td>";
echo   "<td>".$product['discount']."%</td>";
echo   "<td>".$product['cate']."</td>";
echo   "<td>".$product['qte']."</td>";

echo      "<td><a href='?action=delete&id=".$product['prd_id'] ."'><img src='layout/imgs/delete.png'/> <span>Delete</span></a>
<a href='?action=update&id=".$product['prd_id'] ."'><img src='layout/imgs/update.png'/> <span>Update</span></a>

</td>";

echo "</tr>";
}
?>
</table>
<a href="?action=add"><img src="layout/imgs/add-p.svg"> Add Product</a>

</div>


</div>
<?php
}elseif($action=="delete"){

$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;

if(exists("product","prd_id",$id)>0){

    $stmt = $con->prepare("DELETE FROM product WHERE prd_id=$id");

    try{
        $stmt->execute();
        $stmt->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        echo cmd("suc","The Product Has Been Deleted ","Check The New List Of Products :",'products.php',"Products");
    }catch(PDOException $ex){
        echo cmd("err","You Cannot Delete This Products Its Ordered By Clients","Check The New List Of Orders :",'orders.php',"Orders");

    }
  


};


}elseif($action=="add"){


    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $p_name = $_POST['name'];
        $p_prix = $_POST['prix'];
        $p_dis = $_POST['dis'];
        $p_qte = $_POST['qte'];
        $p_desc = $_POST['desc'];
        $cat = $_POST['cat'];
        $p_date = $_POST['date'];
        $p_img= "/".$_POST['img'];


       
       if (!exists("product" , "name" , $p_name)){

        $stmt= $con->prepare("INSERT INTO product(`name`,`img`, `prix`,`discount`, `qte`, `description`,`c_id`,`date_added`)  VALUES(?,?,?,?,?,?,?,?)");
        $stmt->execute(array($p_name,$p_img,$p_prix,$p_dis,$p_qte,$p_desc,$cat,$p_date));
        if($stmt){
            echo cmd("suc","The Product Has Added","Check List Of Products:",'products.php',"Products");
        }
       }else{
        echo cmd("err","The Product Is Aleady Exists","Check List Of Products Here :",'products.php',"Products");
       }


    }

?>
    <div class="add-page">
    <h2>Add Product</h2>

        <div class="container">
        <div class="img">
        <div class="head-sec">
        <img src="layout/imgs/add-user.svg" alt="">
        <p>Feel Free To Add New Product</p>

    </div>
        </div>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <label for="">Product Name</label>
                <input type="text" name="name">
                <label for="">Product Photo</label>
                <input type="File" name="img">

                <label for="">Product prix</label>
                <input type="text" name="prix" >
                <label for="">Discount</label>
                <input type="number" name="dis" min=0>
                <label for="">Product Qte</label>
                <input type="text" name="qte">
                <label for="">Product Description</label>
                <input type="text" name="desc">
                <!-- --------------------Select Cate-------------  -->
                <label for="">Select A Category</label>
                <select name="cat" id="">
            <?php
                $stmt=$con->prepare("SELECT c_name,c_id FROM categories");
                $stmt->execute();
                $categoies=$stmt->fetchAll();

                foreach($categoies as $cate){
                    echo "<option value=". $cate['c_id'] .">".$cate['c_name']."</option>";
                }
            ?>

                </select>
                <!-- -----------------------End Cate --------------  -->
                <label for="">Date</label>
                <input type="date" name="date">
                <input type="submit" value="Add Product">
            </form>
        </div>
    </div>




<?php
}elseif($action == "update"){

    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;
    if (exists("product" , "prd_id" , $id) == 1){
    $data = getSpeData("product","prd_id",$id);
  
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $p_id = $_POST['id'];
        $p_name = $_POST['name'];
        $p_prix = $_POST['prix'];
        $p_qte = $_POST['qte'];
        $p_desc = $_POST['desc'];
        $p_date = $_POST['date'];
       

        if(strlen($_POST['img'])==0){
            $p_img =$data['img'];
        }else{
            $p_img = "/".$_POST['img'];
        }

        
       
     

        $stmt= $con->prepare("UPDATE `product` SET `name`=? ,`img`=? ,`prix`= ?,`qte`=?,`description`= ?,`date_added`= ? WHERE `prd_id`= ?");
        $stmt->execute(array($p_name,$p_img,$p_prix,$p_qte,$p_desc,$p_date,$p_id));
        if($stmt){
            echo cmd("suc","The Product Has Updated","Check Last Modifcation From Here:",'products.php',"Products");
        }
    }
       }else{
        echo cmd("err","This Product Not Exists","Check All Prodcuts:",'products.php',"Products");
       }



?>
    <div class="add-page">
        <h2>Update Product</h2>
        <div class="container">
        <div class="img">
        <div class="head-sec">
        <img src="layout/imgs/manage.svg" alt="">
        <p>Manage Product</p>

    </div>
        </div>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
            <input type="hidden" name="id" value="<?php echo $data['prd_id'] ?>">
            <label for="">Product Name</label>
                <input type="text" name="name" value="<?php echo $data['name'] ?>">
                <label for="">Product Photo</label>
                <input type="File" name="img" value="<?php echo $data['img']; ?>">
                <label for="">Product prix</label>
                <input type="text" name="prix" value="<?php echo $data['prix'] ?>">
                <label for="">Product Qte</label>
                <input type="text" name="qte" value="<?php echo $data['qte'] ?>">

                <label for="">Discount</label>
                <input type="text" name="dis" value="<?php echo $data['discount'] ?>" >
                <label for="">Product Description</label>
                <input type="text" name="desc" value="<?php echo $data['description'] ?>">
            <!-- --------------------Select Cate-------------  -->
                <label for="">Select A Category</label>
                <select name="cat" id="">
            <?php
                $stmt=$con->prepare("SELECT c_name,c_id FROM categories");
                $stmt->execute();
                $categoies=$stmt->fetchAll();

                foreach($categoies as $cate){
                    echo "<option value=".$cate['c_id']." "  ; echo $cate['c_id'] == $data['c_id']? "selected": null ; echo ">". $cate['c_name'] . "</option>";
                }
            ?>

                </select>
                <!-- -----------------------End Cate --------------  -->
                <label for="">Date</label>
                <input type="date" name="date" value="<?php echo $data['date_added'] ?>">
                <input type="submit" value="Update">
            </form>
        </div>
    </div>




<?php
}




}else{

    header("location:login.php");
}



?>