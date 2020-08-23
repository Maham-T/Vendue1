<?php
//CHECKING LOGIN STATUS (IF NOT REDIRECTED TO HOME) 
include('login_checker.php');
include("base/getcontent.php"); 


$id = is_numeric($_GET["pram1"]) == true ? $_GET["pram1"] : 0 ;
$winner_id			=  sanitize($_SESSION["id"]);  


if(isset($_POST['AddOrUpdate'])){
	 	 
		$product_id			=  $id; 
		$Name			=  sanitize($_POST['Name']); 	
		$Address		=  sanitize($_POST['Address']);
		$amount				=  sanitize($_POST['amount']);  
		$status				=  sanitize($_POST['status']);	   
	 
			
		$qry_insert = "INSERT INTO ".$tblprefix."payment SET product_id=".$db->qStr($product_id).",  
														winner_id=".$db->qStr($winner_id).",
														Name=".$db->qStr($Name).",
														Address=".$db->qStr($Address).",
														amount=".$db->qStr($amount).",
														status=".$db->qStr($status).",
														date=".$db->qStr($datetime); 
		$rs = $db->Execute($qry_insert) or die($db->errorMSg()); 
		$_SESSION['msg']  = 'add';  
     	
		if($rs){    
			$_SESSION['type'] = "success";						
		}else{
			$_SESSION['type'] = "danger";	
			$_SESSION['msg']  = 'add_update_error';  
			
		}
		header("Location:".MYSURL.$_GET["page"]);
		exit;
  }





if($id > 0){
	$and = " and p.id = ".$db->qStr($id);
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
			p.status,
			p.created_on
		from
			".$tblprefix."product p
		join ".$tblprefix."category c on
			p.cat_id = c.id
		join ".$tblprefix."users u on
			p.user_id = u.id
		left join ".$tblprefix."users w on
			w.id = p.winner_id WHERE p.status = 'A' and p.winner_id = ".$db->qStr($_SESSION["id"])." and (select max(id) from ".$tblprefix."bids b where b.product_id = p.id and b.user_id = ".$db->qStr($_SESSION["id"]).")".$and; 
 
$rs = $db->Execute($sql) or die($db->errorMSg());
$isrs = $rs->RecordCount();


if($id > 0 && $isrs > 0){
	$sqlbid = "SELECT b.*, u.name posted_by FROM 
				".$tblprefix."bids b,  ".$tblprefix."users u  
	 WHERE b.user_id = u.id and  b.product_id = ".$db->qStr($id). " order by b.bid_val desc";
	$rsbid = $db->Execute($sqlbid) or die($db->errorMSg());
	$isrsbid = $rsbid->RecordCount();



	$sqlp = "SELECT *  FROM 
				".$tblprefix."payment 
	 WHERE  product_id = ".$db->qStr($id). " and  winner_id = ".$db->qStr($winner_id) ;
	$rsp = $db->Execute($sqlp) or die($db->errorMSg());
	$isrsp = $rsp->RecordCount();
}


?>
