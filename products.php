<?php 
session_start();
include "init.php";

$prds = getData("product");

$cate = getData("categories");

if(isset($_GET['catid'])){
    $id =$_GET['catid']; 
    if(exists("categories","c_id",$id)){
    
    $prds =getAllSpeData("product","c_id",$id);
}else{
    echo cmd("err","Category Not Exists","Check All Products :",'products.php',"Products");
}
}


?>
<div class="products">
    <div class="container">
        
    <h2>Products</h2>

        <div class="categories">
        <span <?php echo !isset($_GET['catid'])? "class='active'" : null ?>><a href="?"  >All</a></span>
    <?php 
        foreach($cate as $ct){
            echo " <span "; if(isset($_GET['catid']) && $_GET['catid'] == $ct["c_id"]){ echo "class='active'";} ; echo "><a href=?catid=". $ct["c_id"]."> ".$ct['c_name']. "</a></span>";
        }
        
    ?>

        </div>
        <div class="products-list">
    <?php
        foreach($prds as $prd){

            echo "<div class='prd'>";
            echo "<div class='title'>".$prd['name'] ."</div>";
            echo "<img src='layout/imgs".$prd['img']."' alt=''>";
            echo "<span>". $prd['prix']."$</span>";
            if($prd['discount'] >0){
                echo "<span class='old'><del>".calcTot($prd['prix'],$prd['discount'])."$</del></span>";
            }
            echo "<span class='off'>"; if($prd['discount'] >0) {echo  "-". $prd['discount']."%";}else{null;} ;   echo"</span>";

            echo "<button class='order'> <a href='product.php?pid=". $prd['prd_id'] ."'>Detail</a></button>";
            
            echo " </div>";



        }

    ?>

        </div>
    </div>
</div>



<?php include "include/template/foot.php" ?>




