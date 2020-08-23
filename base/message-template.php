<?php
//CHECKING LOGIN STATUS (IF NOT REDIRECTED TO HOME)
include('login_checker.php');
include("base/getcontent.php");
if(isset($_POST['AddOrUpdate'])){
	 	 
		$id						=  sanitize($_POST['id']); 
		$title					=  sanitize($_POST['title']);   		
		$message				=  sanitize($_POST['message']);
	 
     	$qry_insert = "UPDATE ".$tblprefix."msg_manage SET title=".$db->qStr($title).",   
																message=".$db->qStr($message)." 
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
				title,
				message,
				type  FROM 
				".$tblprefix."msg_manage 
	 WHERE 1=1  ".$and; 
$rs = $db->Execute($sql) or die($db->errorMSg());
$isrs = $rs->RecordCount();


?>
