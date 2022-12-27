<?php 
session_start();
include 'init.php';

$data = getData("messages");

if(isset($_GET['action'])){
if($_GET['action']=="delete"){
    $msgId = $_GET['id'];

    if(exists("messages","msg_id",$msgId)){

        $stmt=$con->prepare("DELETE FROM messages WHERE msg_id=$msgId");
        $stmt->execute();
        if($stmt){
            echo cmd("suc","The Message Has Deleted","Check Other Messages:",'messages.php',"Messages");
        }
    }else{
        echo cmd("err","The Message Not Exsists","Check Messages:",'messages.php',"Messages");
    }


}
}

?>

<div class="messages">
    <h2>Messages</h2>
    <div class="container">
        <div class="info">
            <span>From:</span>
            <span>Subject:</span>
            <span>Message:</span>
            <span>Delete:</span>
        </div>
        <?php 
            foreach($data as $msg){
                ?>
    <div class="box">
        <div class="user">
            <img src="layout/imgs/avatars/avatar1.svg" alt="">
            <div class="name"><?php echo $msg['email'] ?></div>
            </div>
            <div class="msg"><?php echo $msg['subject'] ?></div>
            <div class="msg"><?php echo $msg['msg'] ?></div>
            <div class="del"> <a href="?action=delete&id=<?php echo $msg['msg_id'] ?>"><img src="layout/imgs/delete.png"></a></div>
            
        </div>
<?php
            }
            
        ?>
    
    </div>
</div>