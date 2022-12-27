<?php
session_start();
include "init.php"; 





$action = isset($_GET['action'])?$_GET['action'] : "manage";
$id =  isset($_GET['id'])?$_GET['id'] : "";

// $data = getSpeData("product","prd_id",$id);

if($action=='add'){
    if(exists("product","prd_id",$id)){
    if(isset($_SESSION['cart'][$id])){
       $_SESSION['cart'][$id]['qte']++;
    }else{
$_SESSION['cart'][$id]= array("prd_id"=>$id,"qte"=>1);
}
}else{
    echo cmd("err","This Product Not Exists","Check All Our Products From Here:",'products.php',"Prodcuts");
}
}


if($action=="remove"){
 $_SESSION['cart'][$id]['qte']--;
}
if($action=="empty"){
$_SESSION['cart']=array();
}

if($action="manage"){
    
    if(!empty($_SESSION['cart']) ){
        
?>
<div class="cart">
    <div class="container">
        <h2>Cart</h2>
        <div class="cart-d">
<div class="header">
    <div class="prd">Product</div>
    <div class="prd">Name</div>
    <div class="prd">Qte</div>
    <div class="prd">Cost</div>

</div>

<?php 
$total = 0;


foreach ($_SESSION['cart'] as $arr){

$pid= $arr['prd_id'];
    $data = getSpeData("product","prd_id",$pid);

$qte = $arr['qte'];
$total += getFullPrice($data['prix'],$qte);
?>


            <div class="card-s">
                <img src="layout/imgs<?php echo $data['img'] ?>">
                <div class="title"><?php echo $data['name'] ?></div>
                <div class="controle">
                        <a href="?action=add&id=<?php echo $data['prd_id'] ?>">+</a><?php echo $qte ?> <a href="?action=remove&id=<?php echo $data['prd_id'] ?>">-</a>
                </div>
                <div class="price"><?php echo getFullPrice($data['prix'],$qte) ?>$</div>
            </div>
  


<?php
}


?>
<div class="btn-tot">
<div class="total">
    Total:
    <span><?php  echo $total ?> $</span>
      </div>
      <div class="btns">
      <a href="?action=empty" class="empty">Empty Cart</a>
        <?php if(isset($_SESSION['id'])){
            echo "<a href='orders.php?action=add' class='empty'>Confirm Order</a>";

        }else{
            echo "<a href='login.php'>Login</a>";

        } ?>
      </div>
    
    </div>
</div>  </div>

<?php
}else{
?>   
<div class="cart">
    <div class="container">
        <div class="emptyc">
        <h2>You didn't Add Any Product To Your Cart</h2>
            <img src="layout/imgs/empty-cart.svg" />
     <div class='btn'>Check Last Offers From Here : <a href="products.php">Products</a></div>

          
        </div>
    </div>
</div>

<?php
}
}
?>
<?php include "include/template/foot.php" ?>