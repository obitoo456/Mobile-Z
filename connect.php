<?php 

$dsn = "mysql:host=localhost;dbname=mobilez";
	$user= "root";
	$pass="";
		
    try{
            $con=new PDO($dsn,$user,$pass); 
            
    }
        catch(PDOException $e){
             echo "Failted" . $e -> getMessage();
        }

        ?>