<?php
//CHECKING LOGIN STATUS (IF NOT REDIRECTED TO HOME) 
include('login_checker.php');
include("base/getcontent.php"); 


$id = is_numeric($_GET["pram1"]) == true ? $_GET["pram1"] : 0 ;

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
			w.id = p.winner_id WHERE p.status = 'A' and (select 1 from ".$tblprefix."bids b where b.product_id = p.id and b.user_id = ".$db->qStr($_SESSION["id"]).")".$and; 
 
$rs = $db->Execute($sql) or die($db->errorMSg());
$isrs = $rs->RecordCount();


if($id > 0 && $isrs > 0){
	$sqlbid = "SELECT b.*, u.name posted_by FROM 
				".$tblprefix."bids b,  ".$tblprefix."users u  
	 WHERE b.user_id = u.id and  b.product_id = ".$db->qStr($id). " order by b.bid_val desc";
	$rsbid = $db->Execute($sqlbid) or die($db->errorMSg());
	$isrsbid = $rsbid->RecordCount();
}


?>
