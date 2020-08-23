<?php
//CHECKING LOGIN STATUS (IF NOT REDIRECTED TO HOME)
include('login_checker.php');
include("base/getcontent.php");


if(isset($_POST['profile_update'])){
	 	 
		$id						=  sanitize($_POST['id']); 
		$name					=  sanitize($_POST['name']);   		
 	 
     	$qry_insert = "UPDATE ".$tblprefix."users SET name=".$db->qStr($name).",   
																updatedby=".$db->qStr($id).",
																updatedon = ".$db->qStr($datetime)." where id = ".$db->qStr($id);  
		$rs = $db->Execute($qry_insert);
		if($rs){  
			$_SESSION["name"] = $name;
			$_SESSION['type'] = "success";	
			$_SESSION['msg']  = 'update'; 			
		}else{
			$_SESSION['type'] = "danger";	
			$_SESSION['msg']  = 'add_update_error';  
			
		}
		header("Location:".MYSURL.$_GET["page"]);
		exit;
  }




if(isset($_POST["changepassword"])){		 
	$cpassword	  	  =  password(sanitize($_POST['cpassword'])); 
	$password	  	  =  password(sanitize($_POST['password'])); 	 
	$id	  	  		  =  sanitize($_POST['id']); 	
	
	if($_SESSION["password"] !=$cpassword ) {
		$_SESSION["password"] = $password;
		$_SESSION['type'] = "danger";	
		$_SESSION['msg'] = 'invalid_current_password'; 
		header("Location:".MYSURL.$_GET["page"]);
		exit();	 
	}
	 		
	$qry_update = "UPDATE ".$tblprefix."users SET password=".$db->qStr($password).",updatedby=".$db->qStr($id).",
																updatedon = ".$db->qStr($datetime)."  WHERE id = ".$db->qStr($id)  ; 
	$rs = $db->Execute($qry_update);
	if($rs){ 
		$_SESSION["password"] = $password;
		$_SESSION['type'] = "success";	
		$_SESSION['msg'] = 'changepassword'; 
	}else{ 
		$_SESSION['type'] = "danger";	
		$_SESSION['msg'] = 'changepassword_error';  
	}
	header("Location:".MYSURL.$_GET["page"]);
	exit();
	 
}
?>
