<?php
//CHECKING LOGIN STATUS (IF NOT REDIRECTED TO HOME)
include('login_checker.php');
include("base/getcontent.php");
if(isset($_POST['AddOrUpdate'])){
	 	 
		$id						=  sanitize($_POST['id']); 
		$subject				=  sanitize($_POST['subject']);   		
		$email_body				=  $_POST['email_body'];
 
					
     	$qry_insert = "UPDATE ".$tblprefix."email_conf SET subject=".$db->qStr($subject).",   
																email_body=".$db->qStr($email_body)." 
																where id = ".$db->qStr($id);  
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

$action = $_GET["pram1"];
if($action === "update"){ 
	$id 	= is_numeric(base64_decode($_GET["pram2"])) == true ? base64_decode($_GET["pram2"]) : 0 ; 
	$and 	= " and id = ".$db->qStr($id);
}

$sql = "SELECT id, 
				subject,
				email_body,
				email_type  FROM 
				".$tblprefix."email_conf 
	 WHERE 1=1  ".$and; 
$rs = $db->Execute($sql) or die($db->errorMSg());
$isrs = $rs->RecordCount();


?>
