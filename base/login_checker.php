<?php
if($_SESSION['login'] != true){
	$_SESSION['type'] = "danger";	
	$_SESSION['type'] = "unauthorizedaccess";
	header("Location:".MYSURL."login");
	exit();
}
 

if(!in_array($_GET["page"],$_SESSION["MANU"]) && $_GET["page"] != "dashboard"){
	$_SESSION['type'] = "danger";	
	$_SESSION['type'] = "unauthorizedaccess";
	header("Location:".MYSURL."login");
	exit();
}
?>