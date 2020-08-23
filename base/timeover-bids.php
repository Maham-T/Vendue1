<?php
//CHECKING LOGIN STATUS (IF NOT REDIRECTED TO HOME) 
include('login_checker.php');
include("base/getcontent.php"); 


$action = $_GET["pram1"];


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
			w.id = p.winner_id WHERE p.status = 'A' and  p.winner_id = 0 and valid_till < now() "; 
 
$rs = $db->Execute($sql) or die($db->errorMSg());
$isrs = $rs->RecordCount();


if($action =="process" && $isrs > 0){

	while(!$rs->EOF){

		 	$id = $rs->fields["id"];

		 	$sqlbid = "SELECT b.*  FROM 
				".$tblprefix."bids b   
				 WHERE  b.product_id = ".$db->qStr($id). " order by b.bid_val desc limit 0,1";

			$rsbid = $db->Execute($sqlbid) or die($db->errorMSg());
			$isrsbid = $rsbid->RecordCount();

			if($isrsbid > 0){
				$bid_id 			= $rsbid->fields["id"];
				$winner_id  		= $rsbid->fields["user_id"];
				$bid_winner_price 	= $rsbid->fields["bid_val"]; 

			}

			$qry_insert = "UPDATE ".$tblprefix."product SET bid_id=".$db->qStr($bid_id).",  
															winner_id=".$db->qStr($winner_id).",
															bid_winner_price=".$db->qStr($bid_winner_price).",
															win_date=".$db->qStr($datetime)."
											where id = ".$db->qStr($id);  
			$rsupdate = $db->Execute($qry_insert) or die($db->errorMSg());
		 	
					
		 $rs->MoveNext();
	}

	$_SESSION['msg']  = 'update';  
	$_SESSION['type'] = "success";	
	header("Location:".MYSURL.$_GET["page"]);
	exit;

}


?>
