<?php 
session_start();
include 'init.php';

if(isset($_SESSION['id'])){
   $data = getData("user","LIMIT 4",'ORDER BY `user`.`join_date` DESC');
   $data2 = getData("orders","LIMIT 4","ORDER BY `order_id`");
?>

<div class="container">
<h2 class="dash">Dashboard</h2>

    <div class="statistics">
        <div class="box">
           <h1>Total Phones</h1>
           <p><a href="products.php"> <?php echo getCount("product")  ?> </a></p>
            
        </div><div class="box">
           <h1>Orders(Confirmed)</h1>
           <p><a href="orders.php"> <?php echo getCount("orders")."(".getCount("orders","WHERE status='done'") .")"  ?></a></p>
            
        </div><div class="box">
           <h1>Total User</h1>
           <p><a href="members.php"> <?php echo getCount("user")  ?></a></p>
            
        </div><div class="box">
           <h1>Total Catergoies</h1>
           <p><a href="categories.php"><?php echo getCount("categories")  ?></a></p>
            
        </div>
    </div>
   <div class="info">
    <div class="last-users">
      <table>
         <tr>
         <th colspan="2">last users</th>
         </tr>
         <tr>
         <th>Email</th>
         <th>Join Date</th>
         </tr>
<?php 
foreach($data as $member){


       echo "<tr>";
            echo "<td>".$member['email'] ."</td>";
            echo "<td>". $member['join_date']. "</td>";
         echo "</tr>";
      }
?>
      </table>
    </div>

    <div class="last-orders">
      <table>
         <tr>
         <th colspan="2">last order</th>
         </tr>
         <tr>
         <th >Email</th>
         <th>Total Cost</th>
         </tr>
<?php 
foreach($data2 as $order){

      $email = getSpeData("user","user_id",$order["user_id"]);

       echo "<tr>";
            echo "<td>".$email['email']."</td>";
            echo "<td "; echo $order['status']=="pending" ? "style=color:#ef5350" :  "style=color:#4caf50" ; echo ">" . $order['total'] . "$</td>";
         echo "</tr>";
      }
?>
      </table>
    </div>
    

    </div>
</div>



<?php
}else{
    header("location:login.php");

}


?>