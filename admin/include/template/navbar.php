
<?php  
if(isset($_SESSION['id'])){
    $getData = getSpeData("user","user_id",$_SESSION['id']);
}
?>

<div class="navbar">
    <div class="container">
        <div class="links">
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="categories.php">Categories</a></li>
                <li><a href="members.php">Member</a></li>
                <li><a href="orders.php">Orders</a></li>
                <li><a href="messages.php">Messages</a></li>

            </ul>
        </div>
        <div class="profile">
            
        <img src="layout/imgs<?php echo $getData['img'] ?>" alt="">
        <span><?php if(isset($_SESSION['name'])){echo $_SESSION['name'];}else{echo "Guest";} ?></span>
        <img src="layout/imgs/arrow-down.svg" alt="">
        <div class="menu">
            <a href="profile.php">Profile</a>
            <a href="../">See The Store</a>
            <a href="logout.php">Logout</a>
        </div>
        </div>
    </div>
</div>