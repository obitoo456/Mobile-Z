<?php 
session_start();

include "init.php";

$mainOffer = getBigDiscount();


$otherOff = getBiggestDiscounts("LIMIT 4");



?>

<div class="homepage">
        <div class="best-offer">
            <h3>Best Offer Today <img src="layout/imgs/discount-tag.png" alt=""></h3>
        <div class="product">
            <img src="layout/imgs<?php echo $mainOffer['img'] ?>" alt="">
            <div class="text">
            <div class="title"><?php echo $mainOffer['name'] ?></div>
            <span >Price: <?php echo $mainOffer['prix'] ?>$</span>
            <div class="det">
            <span class="old"><del><?php echo calcTot($mainOffer['prix'],$mainOffer['discount']) ?>$</del></span>
            <span class="off"> -<?php echo $mainOffer['discount'] ?>%</span>
            </div>
            <button class='order'> <a href='product.php?pid=<?php  echo $mainOffer['prd_id'] ?>'>Detail</a></button>
            </div>
        </div>
        </div>


        <div class="other-offers">
            <h3>Other Offers <img src="layout/imgs/gift.png" alt=""></h3>
        <div class="container">

            <div class="products">
            <?php 
                foreach($otherOff as $offer){
                    echo "<div class='prd'>";
                    echo "<div class='title'>".$offer['name'] ."</div>";
                    echo "<img src='layout/imgs".$offer['img'] . "' alt=''>";
                    echo "<span>".  $offer['prix']."$</span>";
                    if($offer['discount'] >0){
                        echo "<span class='old'><del>".calcTot($offer['prix'],$offer['discount'])."$</del></span>";
                    }
                    echo "<span class='off'>"; if($offer['discount'] >0) {echo  "-". $offer['discount']."%";}else{null;} ;   echo"</span>";
                    echo "<button class='order'> <a href='product.php?pid=". $offer['prd_id'] ."'>Detail</a></button>";
                    echo " </div>";
                }
            
            
            ?>
            <a href="products.php">
            <div class="prd last">
                <div class="title">Apple Iphone12</div>
                <img src="layout/imgs/default.png" alt="">
                <span>600$</span>
                <button class="order">Order Now</button>
            </div></a>
            </div>
            </div>
        </div>
        <div class="testimonials">
            <h2>Testimonials</h2>
            <div class="container">
                <div class="ts">
                    <div class="name">Ilyas Emalki</div>
                    <img src="layout/imgs/avatars/avatar1.svg" alt="">
                    <p>Best Service Love You</p>
                    <div class="stars">
                        <!-- <img src="layout/imgs/starG.svg" alt="">
                        <img src="layout/imgs/starG.svg" alt="">
                        <img src="layout/imgs/starG.svg" alt="">
                        <img src="layout/imgs/starG.svg" alt="">
                        <img src="layout/imgs/starG.svg" alt=""> -->
                        <img src="layout/imgs/5-star-rating.gif" alt="">
                    </div>
                </div>  <div class="ts">
                    <div class="name">Ahmed Sabiri</div>
                    <img src="layout/imgs/avatars/avatar2.svg" alt="">
                    <p>Hot Offers Like Always</p>
                    <div class="stars">
                    <img src="layout/imgs/5-star-rating.gif" alt="">
                    </div>
                </div>  <div class="ts">
                    <div class="name">Ikram Dgh</div>
                    <img src="layout/imgs/avatars/avatar3.svg" alt="">
                    <p>Best Service Love You</p>
                    <div class="stars">
                    <img src="layout/imgs/5-star-rating.gif" alt="">
                    </div>
                </div>
           
        </div>
    </div>
  
</div>
<?php include "include/template/foot.php" ?>




