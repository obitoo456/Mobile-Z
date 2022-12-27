<?php 
if(isset($_SESSION['id'])){
    $getData = getSpeData("user","user_id",$_SESSION['id']);
}

?>
<div class="navbar">
    <div class="container">
        <div class="links">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="cart.php" class="cart">Cart <span><?php if(isset($_SESSION['cart'])){ echo count($_SESSION['cart']);}else{echo 0;} ?></span></a></li>
                    
                <li><a href="orders.php">Orders</a></li>
                <li><a href="contact.php">Contact Us</a></li>

            </ul>
        </div>
        <div class="profile">
     <?php if(isset($_SESSION['id'])){ ?>       
        <img src="layout/imgs<?php  echo $getData['img'] ?>" alt="">
    <?php }else{
        echo "<img src='layout/imgs/avatars/avatar1.svg'>";
    } ?>
        <span><?php if(isset($_SESSION['name'])){echo $_SESSION['name'];}else{echo "Guest";} ?></span>
        <img src="layout/imgs/arrow-down.svg" alt="">
        <div class="menu">
        <?php if(isset($_SESSION['name'])){
            if($getData['admin']){
                echo "<a href='admin/'>Dashboard</a>";
            }
           echo "<a href='profile.php'>Profile</a>";
           echo "<a href='logout.php'>Logout</a>";
           
        }else{
            echo "<a href='login.php'>LogIn/SignUp</a>";
            
        } ?>
            

        </div>
        </div>
    </div>
</div>