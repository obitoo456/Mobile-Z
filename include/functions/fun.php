<?php

use function PHPSTORM_META\type;

function getCount($table,$where=null){

    global $con;
    
    $stmt= $con->prepare("SELECT * FROM $table $where");
    $stmt->execute();
    $count = $stmt->rowCount();
    return $count;

}



function getData($table,$limit=null){
    global $con;
    
    $stmt= $con->prepare("SELECT * FROM $table $limit ");
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
function getAllSpeData($table,$where,$condition){
    global $con;
    
    $stmt= $con->prepare("SELECT * FROM $table WHERE $where= ?");
    $stmt->execute(array($condition));
    $data = $stmt->fetchAll();
    return $data;

}

function exists($table , $where , $condition){
    global $con;
    
    $stmt= $con->prepare("SELECT * FROM $table WHERE $where= ?");
    $stmt->execute(array($condition));
    $count = $stmt->rowCount();
    return $count;
}



function getFullPrice($price,$qte){

return $price * $qte;

}


function getTotalForOrder($qte,$prdid){

    global $con; 

    $stmt=$con->prepare('SELECT prix * ? as total FROM product where prd_id=?');
    $stmt->execute(array($qte,$prdid));
    $t=$stmt->fetch();
    return $t['total'];

}

function getBigDiscount(){
    global $con;
    $stmt=$con->prepare("SELECT * from product ORDER BY `product`.`discount` DESC limit 1");
    $stmt->execute();
    return $stmt->fetch();
}

function getBiggestDiscounts($limit=null){
    global $con;
    $stmt=$con->prepare("SELECT * from product ORDER BY `product`.`discount` DESC $limit OFFSET 1");
    $stmt->execute();
    return $stmt->fetchAll();
}

function calcTot($nPrice,$per){
    $oldP=($nPrice * $per)/100;
    return $oldP+$nPrice ;

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