<?php 

function getCount($table,$where=null){

    global $con;
    
    $stmt= $con->prepare("SELECT * FROM $table $where");
    $stmt->execute();
    $count = $stmt->rowCount();
    return $count;

}



function getData($table,$limit=null ,$order=null){
    global $con;
    
    $stmt= $con->prepare("SELECT * FROM $table $order $limit");
    $stmt->execute();
    $data = $stmt->fetchAll();
    return $data;

}

function getSpeData($table,$where,$condition){
    global $con;
    
    $stmt= $con->prepare("SELECT * FROM $table WHERE $where= ?");
    $stmt->execute(array($condition));
    $data = $stmt->fetch();
    return $data;

}

function exists($table , $where , $condition){
    global $con;
    
    $stmt= $con->prepare("SELECT * FROM $table WHERE $where= ?");
    $stmt->execute(array($condition));
    $count = $stmt->rowCount();
    return $count;
}



function cmd($type,$msg1,$msg2,$link,$linkT){

    if($type == "suc") {

    $type= '<img src="layout/imgs/success.gif" alt="">';}else{$type='<img src="layout/imgs/404-error.png" alt="">';}
    $card= '<div class="card">
    <div class="box">'.
    '<p>'.$msg1.'</p>'.
    $type. '<div class="check"><p>'.$msg2.'<a href="'.$link.'">'.$linkT.'</a></div> </div>
    </div>' ;
    return $card;
}






?>