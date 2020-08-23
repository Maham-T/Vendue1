<?php
//CHECKING LOGIN STATUS (IF NOT REDIRECTED TO HOME)
include('login_checker.php');
include("base/getcontent.php");
if(isset($_POST['AddOrUpdate'])){
	 	 
		$id						=  is_numeric(sanitize($_POST['id'])) == true ? sanitize($_POST['id']) : 0 ; 
		$company_id				=  sanitize($_POST['company_id']);
		$cust_no				=  newCustNo($tblprefix);//COMPANY_SN.date("Y").siteRandomNum(4);   		
		$name					=  sanitize($_POST['name']); 
		$email					=  strtolower(sanitize($_POST['email']));   		
		$phone_no				=  sanitize($_POST['phone_no']);
		$address				=  sanitize($_POST['address']);   
		$postcode				=  sanitize($_POST['postcode']);
		$reg_no					=  sanitize($_POST['reg_no']);
 	 	$companyArray 			= getCompanyDetails($tblprefix,$company_id);
		if($id > 0){
			$qry_insert = "UPDATE ".$tblprefix."customer SET company_id=".$db->qStr($company_id).",
															 name=".$db->qStr($name).", 
															 phone_no=".$db->qStr($phone_no).",
															 address=".$db->qStr($address).",
															 reg_no=".$db->qStr($reg_no).",
															 postcode=".$db->qStr($postcode)."
											where id = ".$db->qStr($id);  
			$rs = $db->Execute($qry_insert);
			$_SESSION['msg']  = 'update'; 
			
		}else{ 
			  $qry_insert = "INSERT INTO ".$tblprefix."customer SET company_id=".$db->qStr($company_id).",
																	 cust_no=".$db->qStr($cust_no).",
																	 name=".$db->qStr($name).", 
																	 phone_no=".$db->qStr($phone_no).",
																	 address=".$db->qStr($address).",
																	 reg_no=".$db->qStr($reg_no).",
																	 postcode=".$db->qStr($postcode).",
																	 email=".$db->qStr($email);  
				$rs = $db->Execute($qry_insert);
				if($rs){
						//Email
						$from_name  = $companyArray["name"];
						$from_email = strtolower($companyArray["email"]);
						$companyDetails	 = "";
						//Welcome Email
						/***************SENDING EMAIL****************/
						$mContact = new Mail;
						$mContact->From("$from_name <$from_email>");
						$mContact->To("$name <$email>"); 

						$Priority = 3;
						$send = '';

						//if Email Template Exist
						$email_template = get_email_template($tblprefix, "new_customer");
						if($email_template['subject']=='no' || $email_template['body']=='no' || $email_template['subject']=='' || $email_template['body']==''){
							echo "email process failed please try later!";
							exit();
						}
						$subject = $email_template['subject'];
						/***************ASSIGNING VALUE****************/
						$word_to_search = array("%displayname%","%companyDetails%"); 	 
						$word_to_replace = array($name,$companyDetails);
						$body = str_replace($word_to_search , $word_to_replace, $email_template['body']);

						/***************SENDING EMAIL****************/	 
						$mContact->Subject($subject);
						$mContact->Body(strip_slashes($body));
						$mContact->Priority($Priority);
						$send = $mContact->Send();
						//End Welcome Email 
						//End Email
 						$_SESSION['msg']  = 'add';
				}
			
		
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
	$and 	= " and id = ".$db->qStr($id);
}else{
	if($_SESSION["company_id"] > 0){
		$and 	= " and company_id = ".$db->qStr($_SESSION["company_id"]);
	}	
}



if($action === "status"){ 
	$id 	= is_numeric(base64_decode($_GET["pram2"])) == true ? base64_decode($_GET["pram2"]) : 0 ; 
	$status = base64_decode($_GET["pram3"]);
	$qry_insert = "UPDATE ".$tblprefix."customer SET status=".$db->qStr($status)."  where id = ".$db->qStr($id);  
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
	$qry_insert = "DELETE FROM ".$tblprefix."customer  where id = ".$db->qStr($id);  
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
				company_id,
				cust_no,
				name,
				phone_no,
				reg_no,
				email,
				address, 
				postcode,  
				status
	 FROM  ".$tblprefix."customer 
	 WHERE 1=1  ".$and; 
$rs = $db->Execute($sql) or die($db->errorMSg());
$isrs = $rs->RecordCount();


?>
