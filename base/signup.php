<?php
include("base/getcontent.php");   

if(isset($_POST['login'])){
 		sanitize($_POST); 	

		$name		=  sanitize($_POST['username']);
		$email		=  strtolower(sanitize($_POST['email']));
		$password	=  password(sanitize($_POST['password']));  
		$Cpassword	=  password(sanitize($_POST['Cpassword']));  
		$role_id	=  $_POST['userType'];  

		if($password != $Cpassword){
			$_SESSION['type'] = "danger";	
			$_SESSION['msg'] = 'passwordnotmatched'; 
			header("Location:".MYSURL."signup");exit;
		}


		$qry_insert = "INSERT INTO ".$tblprefix."users SET name=".$db->qStr($name).",  
															email =".$db->qStr($email).",
															password=".$db->qStr($password).",
															role_id=".$db->qStr($role_id).", 
															entryon=".$db->qStr($datetime); 
		$rs = $db->Execute($qry_insert) or die($db->errorMSg());
		$id = $db->Insert_ID();
		$_SESSION['msg']  = 'add';  
		header("Location:".MYSURL."signup");exit;		 
		
  } 
?>