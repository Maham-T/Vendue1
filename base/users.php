<?php
//CHECKING LOGIN STATUS (IF NOT REDIRECTED TO HOME)
include('login_checker.php');
include("base/getcontent.php");
if(isset($_POST['AddOrUpdate'])){
 
	 	 
		$id						=  is_numeric(sanitize($_POST['id'])) == true ? sanitize($_POST['id']) : 0 ;  
		$name					=  sanitize($_POST['name']); 
		$email					=  strtolower(sanitize($_POST['email']));    
		$role_id				=  sanitize($_POST['role_id']);  
		$password 				= password("VS12345"); 
		if($id > 0){
			$qry_insert = "UPDATE ".$tblprefix."users SET email=".$db->qStr($email).",
															 name=".$db->qStr($name).", 
															 role_id=".$db->qStr($role_id)." 
											where id = ".$db->qStr($id);  
			$rs = $db->Execute($qry_insert);
			$_SESSION['msg']  = 'update'; 
			
		}else{ 
			   $qry_insert = "INSERT INTO ".$tblprefix."users SET   name=".$db->qStr($name).", 
																	 role_id=".$db->qStr($role_id).", 
																	 password=".$db->qStr($password).", 
																	 email=".$db->qStr($email);  
				$rs = $db->Execute($qry_insert);
				$_SESSION['msg']  = 'add'; 
		
		}
     	
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
	$and 	= " and u.id = ".$db->qStr($id);
} 


 


if($action === "status"){ 
	$id 	= is_numeric(base64_decode($_GET["pram2"])) == true ? base64_decode($_GET["pram2"]) : 0 ; 
	$status = base64_decode($_GET["pram3"]);
	$qry_insert = "UPDATE ".$tblprefix."users SET status=".$db->qStr($status)."  where id = ".$db->qStr($id);  
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


if($action === "resetpassword"){ 
	$id 	= is_numeric(base64_decode($_GET["pram2"])) == true ? base64_decode($_GET["pram2"]) : 0 ; 
	$password = password("VS12345"); 
	$qry_insert = "UPDATE ".$tblprefix."users SET password=".$db->qStr($password)."  where id = ".$db->qStr($id);  
	$rs = $db->Execute($qry_insert);
	if($rs){  
		$_SESSION['type'] = "success";	
		$_SESSION['msg']  = 'password_reset'; 			
	}else{
		$_SESSION['type'] = "danger";	
		$_SESSION['msg']  = 'password_reset_error';  

	}
	header("Location:".MYSURL.$_GET["page"]);
	exit;
}
if($action === "delete"){ 
	$id 	= is_numeric(base64_decode($_GET["pram2"])) == true ? base64_decode($_GET["pram2"]) : 0 ; 
	$qry_insert = "DELETE FROM ".$tblprefix."users  where id = ".$db->qStr($id);  
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

  $sql = "SELECT  u.id,  
				u.name,
				u.email,
				u.password,
				u.status,
				u.role_id, 
				r.role_lable,
				u.flag 
	 FROM  ".$tblprefix."users u 
	 JOIN ".$tblprefix."roles r on u.role_id = r.role_id  
	 WHERE u.flag = 0    ".$and;  
$rs = $db->Execute($sql) or die($db->errorMSg());
$isrs = $rs->RecordCount();


?>
