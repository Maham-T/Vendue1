<?php
//CHECKING LOGIN STATUS (IF NOT REDIRECTED TO HOME)
include("base/getcontent.php"); 

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
			w.id = p.winner_id WHERE p.status = 'A' and valid_till >= now() "; 
 
$rs = $db->Execute($sql) or die($db->errorMSg());
$isrs = $rs->RecordCount();


?>
