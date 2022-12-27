<?php 

session_start();
include "init.php";

if(isset($_SESSION['id'])){
$action =isset($_GET['action']) ? $_GET['action']: "manage";
if($action=="delete"){
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;
    if(exists("orders","order_id",$id)>0){
    
        $stmt = $con->prepare("DELETE FROM orders WHERE order_id =$id");
        $stmt->execute();
    if($stmt){
        echo cmd("suc","Your Order Has Been Removed ","Check Your Orders Status Now: ","orders.php","My Orders");
    }
    
    }else{
        echo cmd("err","This Order Not Exists ","Your Orders Is here: ","orders.php","My Orders");
    };
}

if($action=="add"){

   
$order_l = $_SESSION['cart'];

foreach($order_l as $order){
    $p_id=$order['prd_id'];
    $qte =$order['qte'];
        $user_id = $_SESSION['id'];
        $total = getTotalForOrder($qte,$p_id);
    

    $stmt =$con-> prepare('INSERT INTO `orders`( `prd_id`, `user_id`, `qte`, `total`) VALUES (?,?,?,?)');
    $stmt->execute(array($p_id,$user_id,$qte,$total));

    if($stmt){
        echo cmd("suc","Your Products Has Been Ordered","Check Your Orders From Here: ","orders.php","My Orders");
    }
    
}
$_SESSION['cart']=array();



}else{
    $userid=$_SESSION['id'];

    $orders=getAllSpeData("orders","user_id",$userid);
?>

<div class="orders">
    <div class="container">
        <h2>Orders</h2>
        <div class="orders-h">
            <?php 
foreach($orders as $order){
    $getPrd=getSpeData("product","prd_id",$order['prd_id']);
?>
<div class="order">
    <div class="order-s">
    <div class="image">
<img src="layout/imgs<?php echo $getPrd['img'] ?>" alt="">
</div>
<div class="detail">
<div class="id">Order Id : <?php echo $order['order_id'] ?> </div>
<div class="id">Product : <?php echo $getPrd['name'] ?> </div>
<div class="cost">Total Cost : <?php echo $order['total'] ?>$ </div>
</div>
</div>
<div class="status">
    <?php if($order['status']=="pending"){?>
    <div class="del"><a href="?action=delete&id=<?php echo $order['order_id'] ;?>"> <img src="layout/imgs/perspective_matte-5-128x128.png" alt="">Annuler</a></div>
    <?php }?>
    <div class="statu"> <img src="layout/imgs/perspective_matte-483-128x128.png"> <?php echo $order['status'] ?></div>
</div>
</div>

<?php
}
            
            ?>
        </div>
    </div>
</div>





<?php
}}else{
    ?>
    <div class="orders">
        <div class="container">
            <div class="obl">
                <h2>You Have To Login/SignUp To Check You Orders</h2>
                <img src="layout/imgs/login.svg" alt="">
                <div class="btn">Do it Easly Form Here: <a href="login.php">Login/SignUp</a></div>
            </div>
        </div>
    </div>

<?php
}
?>
<?php include "include/template/foot.php" ?>