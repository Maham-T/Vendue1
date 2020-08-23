<?php
//CHECKING LOGIN STATUS (IF NOT REDIRECTED TO HOME)
include('login_checker.php');
include("base/getcontent.php");
if(isset($_POST['AddOrUpdate'])){
	 	 
		$id						=  is_numeric(sanitize($_POST['id'])) == true ? sanitize($_POST['id']) : 0 ; 
		$name					=  sanitize($_POST['name']);   		
		$description			=  sanitize($_POST['description']);
		if($id > 0){
			$qry_insert = "UPDATE ".$tblprefix."category SET name=".$db->qStr($name).",   
																description=".$db->qStr($description)."  
											where id = ".$db->qStr($id);  
			$_SESSION['msg']  = 'update'; 
			
		}else{
			$qry_insert = "INSERT INTO ".$tblprefix."category SET name=".$db->qStr($name).",   
																description=".$db->qStr($description);  
			$_SESSION['msg']  = 'add';
		
		}
     	$rs = $db->Execute($qry_insert);
		if($rs){  
			$_SESSION['type'] = "success";						
		}else{
			$_SESSION['type'] = "danger";	
			$_SESSION['msg']  = 'add_update_error';  
			
		}
		header("Location:".MYSURL.$_GET["page"]);
		exit;
  }

$action = $_GET["pram1"];
if($action === "add"){ 
	$id 	= is_numeric(base64_decode($_GET["pram2"])) == true ? base64_decode($_GET["pram2"]) : 0 ; 
	$and 	= " and id = ".$db->qStr($id);
}

if($action === "status"){ 
	$id 	= is_numeric(base64_decode($_GET["pram2"])) == true ? base64_decode($_GET["pram2"]) : 0 ; 
	$status = base64_decode($_GET["pram3"]);
	$qry_insert = "UPDATE ".$tblprefix."category SET status=".$db->qStr($status)." 
											where id = ".$db->qStr($id);  
	$rs = $db->Execute($qry_insert);
	if($rs){  
		$_SESSION['type'] = "success";	
		$_SESSION['msg']  = 'status_update'; 			
	}else{
		$_SESSION['type'] = "danger";	
		$_SESSION['msg']  = 'status_update_error';  

	}
	header("Location:".MYSURL.$_GET["page"]);
	exit;
}
if($action === "delete"){ 
	$id 	= is_numeric(base64_decode($_GET["pram2"])) == true ? base64_decode($_GET["pram2"]) : 0 ; 
	$qry_insert = "DELETE FROM ".$tblprefix."category  where id = ".$db->qStr($id);  
	$rs = $db->Execute($qry_insert);
	if($rs){  
		$_SESSION['type'] = "success";	
		$_SESSION['msg']  = 'delete'; 			
	}else{
		$_SESSION['type'] = "danger";	
		$_SESSION['msg']  = 'delete_error';  

	}
	header("Location:".MYSURL.$_GET["page"]);
	exit;
}

$sql = "SELECT id, 
				name,
				description, 
				status FROM 
				".$tblprefix."category 
	 WHERE 1=1  ".$and; 
$rs = $db->Execute($sql) or die($db->errorMSg());
$isrs = $rs->RecordCount();


?>
