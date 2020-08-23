<?php
//CHECKING LOGIN STATUS (IF NOT REDIRECTED TO HOME)
include('login_checker.php');
include("base/getcontent.php");

if(isset($_POST['AddOrUpdate'])){
	 	 
		$id					=  is_numeric(sanitize($_POST['id'])) == true ? sanitize($_POST['id']) : 0 ;
		$title				=  sanitize($_POST['title']); 	
		$description		=  sanitize($_POST['description']);
		$cat_id				=  sanitize($_POST['cat_id']); 
		$user_id			=  sanitize($_SESSION["id"]);  
		$valid_till			=  $_POST['valid_till'];	
		$bid_start_price	=  sanitize($_POST['bid_start_price']);	 
		$pimage				=  $_FILES['images']; 
	
	
		if($id > 0){ 
			
			$qry_insert = "UPDATE ".$tblprefix."product SET title=".$db->qStr($title).",  
															description=".$db->qStr($description).",
															cat_id=".$db->qStr($cat_id).",
															user_id=".$db->qStr($user_id).",
															bid_start_price=".$db->qStr($bid_start_price).",
															valid_till=".$db->qStr($valid_till)." 
											where id = ".$db->qStr($id);  
			$rs = $db->Execute($qry_insert) or die($db->errorMSg());
			$_SESSION['msg']  = 'update'; 
			
		}else{
			
			$qry_insert = "INSERT INTO ".$tblprefix."product SET title=".$db->qStr($title).",  
															description=".$db->qStr($description).",
															cat_id=".$db->qStr($cat_id).",
															user_id=".$db->qStr($user_id).",
															bid_start_price=".$db->qStr($bid_start_price).",
															valid_till=".$db->qStr($valid_till); 
			$rs = $db->Execute($qry_insert) or die($db->errorMSg());
			$id = $db->Insert_ID();
			$_SESSION['msg']  = 'add'; 
		
		}
     	
		if($rs){   


			// Configure upload directory and allowed file types 
		    $upload_dir = 'uploads/product/'; 
		    $allowed_types = array('jpg', 'png', 'jpeg', 'gif'); 
		      
		    // Define maxsize for files i.e 2MB 
		    $maxsize = 2 * 1024 * 1024;  
		  
		    // Checks if user sent an empty form  
		    if(!empty(array_filter($_FILES['files']['name']))) { 
		  
		        // Loop through each file in files[] array 
		        foreach ($_FILES['files']['tmp_name'] as $key => $value) { 
		              
		            $file_tmpname 	= $_FILES['files']['tmp_name'][$key]; 
		            $file_name 		= $_FILES['files']['name'][$key]; 
		            $file_size 		= $_FILES['files']['size'][$key]; 
		            $file_ext 		= pathinfo($file_name, PATHINFO_EXTENSION); 
		  
		            // Set upload file path 
		            $filepath = $upload_dir.$file_name;
		  
		            // Check file type is allowed or not 
		            if(in_array(strtolower($file_ext), $allowed_types)) { 
		  				
		                // Verify file size - 2MB max  
		                if ($file_size > $maxsize){          
		                    echo "Error: File size is larger than the allowed limit.";  exit;
		  				}

		                // If file with name already exist then append time in 
		                // front of name of the file to avoid overwriting of file 
		                $filepath = $upload_dir.time().$file_name; 
		             
		                 if(move_uploaded_file($file_tmpname, $filepath)) {  
	                        $qry_img = "INSERT INTO ".$tblprefix."product_img SET product_id=".$db->qStr($id).",  
														image=".$db->qStr($filepath);  
							$rsimg = $db->Execute($qry_img) or die($db->errorMSg()); 
	                    }  
		                 
		            }  
		        } 
		    }  
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
	$and 	.= " and p.id = ".$db->qStr($id);
} 
 
if($action === "status"){ 
	$id 	= is_numeric(base64_decode($_GET["pram2"])) == true ? base64_decode($_GET["pram2"]) : 0 ; 
	$status = base64_decode($_GET["pram3"]);
	$qry_insert = "UPDATE ".$tblprefix."product SET status=".$db->qStr($status)."  where id = ".$db->qStr($id);  
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
	$qry_insert = "DELETE FROM ".$tblprefix."product  where id = ".$db->qStr($id);  
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

if(isset($_POST['search'])){
	$keyword		=  sanitize($_POST['keyword']);
	if($keyword != ''){
		$and 	.= " and (p.title like '%".$keyword."%' or p.description like '%".$keyword."%' )";	
	}

}

$role_id	=  is_numeric($_SESSION["role_id"]) == true ? $_SESSION["role_id"] : 0 ;
$user_id	=  is_numeric($_SESSION["id"]) == true ? $_SESSION["id"] : 0 ;

 
if($role_id == 2){
	$and 	.= " and p.user_id = ".$db->qStr($user_id);
}    
 
$sql = "select
			p.id,
			p.title,
			p.description,
			p.cat_id,
			c.name cat_name,
			p.user_id,
			u.name posted_by,
			p.bid_start_price,
			p.bid_winner_price,
			p.winner_id,
			w.name winner,
			p.valid_till,
			p.win_date,
			p.status
		from
			".$tblprefix."product p
		join ".$tblprefix."category c on
			p.cat_id = c.id
		join ".$tblprefix."users u on
			p.user_id = u.id
		left join ".$tblprefix."users w on
			w.id = p.winner_id WHERE 1=1 ".$and;  
 
$rs = $db->Execute($sql) or die($db->errorMSg());
$isrs = $rs->RecordCount();


?>
