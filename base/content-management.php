<?php
//CHECKING LOGIN STATUS (IF NOT REDIRECTED TO HOME)
include('login_checker.php');
include("base/getcontent.php");
if(isset($_POST['AddOrUpdate'])){
	 	 
		$id						=  sanitize($_POST['id']); 
		$page_title				=  sanitize($_POST['page_title']);   		
		$page_heading			=  sanitize($_POST['page_heading']);
		$page_subheading		=  sanitize($_POST['page_subheading']);
		$meta_keyword			=  sanitize($_POST['meta_keyword']);
		$meta_phrase			=  sanitize($_POST['meta_phrase']);
		$meta_description		=  $_POST['meta_description'];

     	$qry_insert = "UPDATE ".$tblprefix."pagecontent SET page_title=".$db->qStr($page_title).",   
																page_heading=".$db->qStr($page_heading).",
																page_subheading=".$db->qStr($page_subheading).",
																meta_keyword=".$db->qStr($meta_keyword).",
																meta_phrase=".$db->qStr($meta_phrase).",
																meta_description=".$db->qStr($meta_description)." 
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
	$and 	= " and ".$tblprefix."pagecontent.id = ".$db->qStr($id);
}

$sql = "SELECT ".$tblprefix."pagecontent.id, 
				".$tblprefix."pagecontent.pagename,
				".$tblprefix."pagecontent.page_title,
				".$tblprefix."pagecontent.page_heading,
				".$tblprefix."pagecontent.page_subheading,
				".$tblprefix."pagecontent.meta_keyword,   
				".$tblprefix."pagecontent.meta_phrase,  
				".$tblprefix."pagecontent.meta_description FROM 
				".$tblprefix."pagecontent 
	 WHERE 1=1  ".$and; 
$rs = $db->Execute($sql) or die($db->errorMSg());
$isrs = $rs->RecordCount();


?>
