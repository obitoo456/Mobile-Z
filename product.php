<?php 
session_start();
include "init.php";

if(isset($_GET['pid'])){
$p_id = $_GET['pid'];

if(exists("product","prd_id",$p_id)){
    $data=getSpeData("product","prd_id",$p_id);
?>
<div class="prd-det">
    <h2>Detail</h2>
    <div class="container">
<div class="prd_img">
<img src="layout/imgs<?php echo $data['img'] ?>" alt="">
</div>
<div class="details">
<div class="title"><?php echo $data['name'] ?></div>
<div class="price">Price: <?php echo $data['prix'] ?>$</div>
<div class="oldp"><?php echo calcTot($data['prix'],$data['discount']) ?>$</div>
<div class="discount"><?php echo $data['discount'] ?>%</div>
<div class="types">
<span>Type: </span>

<div class="type">
    <span>S</span>
    <span class="active">XS</span>
    <span>X</span>
    <span>XMax</span>
</div>
</div>
<div class="colors">
<span>Colors:</span>
<div class="color">
    <span>Green</span>
    <span>Blue</span>
    <span class="active">Red</span>
</div>
</div>

<button class="order" ><a style="
    background-color: var(--main-color);
    color: white;
" href="cart.php?action=add&id=<?php echo $data['prd_id'] ?>">Order Now</a></button>

</div>

</div>


</div>



<?php
}else{
    echo "Prd not Exsists";
}

} 


?>
<?php include "include/template/foot.php" ?>