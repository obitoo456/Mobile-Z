<?php 
session_start();
include "init.php";


if(isset($_SESSION['id'])){
$action = isset($_GET['action']) ? $_GET['action'] : "manage";


if($action=="manage"){
    $sec = isset($_GET['sec']) ? "WHERE orders.status = '".$_GET['sec'] ."'": null;
    $stmt = $con->prepare("SELECT orders.*, product.name as product, user.email as email from orders INNER JOIN product ON product.prd_id =orders.prd_id INNER JOIN user ON user.user_id = orders.user_id $sec");
    $stmt->execute();
    $data=$stmt->fetchAll();
?>
<div class="products">
    <h2>Orders</h2>
<div class="container">
    <div class="filter">
    <div class="all <?php if(!isset($_GET['sec']) ){echo 'active';} ?>"> <img src="layout/imgs/list.png" alt=""><a href="?">ALL</a></div>
        <div class="ref <?php if(isset($_GET['sec']) and $_GET['sec']=="refused" ){echo 'active';} ?>"  > <img src="layout/imgs/rejected.png" alt=""><a href="?sec=refused">Refused</a></div>
        <div class="pen <?php if(isset($_GET['sec']) and $_GET['sec']=="pending" ){echo 'active';} ?>"> <img src="layout/imgs/hourglass.png" alt=""><a href="?sec=pending">Pending</a></div>
        <div class="done <?php if(isset($_GET['sec']) and $_GET['sec']=="done" ){echo 'active';} ?>"> <img src="layout/imgs/approved.png" alt=""><a href="?sec=done">Done</a></div>
        
    </div>
<table>
<tr>
    <th>ID</th>
    <th>Produit</th>
    <th>Member</th>
    <th>Qte</th>
    <th>Total</th>
    <th>Status</th>
    <th>Controle</th>

</tr>
<?php

foreach($data as $order){
echo "<tr>";
echo   "<td>".$order['order_id']."</td>";
echo   "<td>".$order['product']."</td>";
echo   "<td>".$order['email']."</td>";
echo   "<td>".$order['qte']."</td>";
echo   "<td>".$order['total']."$</td>";
echo   "<td>".$order['status']."</td>";

if($order['status'] == "pending"){
echo     "<td ><a class='app'  href='?action=approve&id=".$order['order_id'] ."'><img src='layout/imgs/approved.png'/> <span>Aprrove</span></a>
<a href='?action=refuse&id=".$order['order_id'] ."'><img src='layout/imgs/rejected.png'/> <span>Reject</span></a>
<a  href='?action=delete&id=".$order['order_id'] ."'><img src='layout/imgs/delete.png'/><span>Delete</span></a>

</td>";
}elseif($order['status']=="done"){
    echo "<td>
<a href='?action=refuse&id=".$order['order_id'] ."'><img src='layout/imgs/rejected.png'/> <span>Reject</span></a>
<a  href='?action=delete&id=".$order['order_id'] ."'><img src='layout/imgs/delete.png'/> <span>Delete</span></a>

</td>";
}elseif($order['status']=="refused"){
    
    echo     "<td ><a class='app' href='?action=approve&id=".$order['order_id'] ."'><img src='layout/imgs/approved.png'> <span>Aprrove</span></a>
<a  href='?action=delete&id=".$order['order_id'] ."'><img src='layout/imgs/delete.png'/> <span>Delete</span></a>

</td>";


}
echo "</tr>";
}
?>
</table>


</div>


</div>
<?php
}elseif($action=="approve"){
$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;
if(exists("orders","order_id",$id)>0){

    $stmt = $con->prepare("UPDATE orders SET status='done' WHERE order_id =$id");
    $stmt->execute();

    echo cmd("suc","The Order Has Approved ","Check The New List Of Orders :",'orders.php',"Orders");


};


}elseif($action=="refuse"){

    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;
    if(exists("orders","order_id",$id)>0){
    
        $stmt = $con->prepare("UPDATE orders SET status='refused' WHERE order_id =$id");
        $stmt->execute();
    
        echo cmd("suc","The Order Has Rejected ","Check The New List Of Orders :",'orders.php',"Orders");
    
    
    };
    
    
}elseif($action == "delete"){

    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;
    if(exists("orders","order_id",$id)>0){
    
        $stmt = $con->prepare("DELETE FROM orders WHERE order_id =$id");
        $stmt->execute();
    if($stmt){
        echo cmd("suc","The Order Has Deleted ","Check The New List Of Orders :",'orders.php',"Orders");
    }
    
    };
}




}else{

    header("location:login.php");
}



?>