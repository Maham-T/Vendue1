<?php
include('root.php');
include($root.'config/conn.php');
 
//Get Sub Category 
if($_GET['act']=='livesearch'){
	
	// prevent direct access
	$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
	if(!$isAjax) {
	$user_error = 'Access denied - not an AJAX request...';
	trigger_error($user_error, E_USER_ERROR);
	}
	
	// get what user typed in autocomplete input
	//$size = sanitize(trim($_GET['term']));
	$size = cleanChar(sanitize(trim($_GET["term"])));	
	
	$a_json = array();
	$a_json_row = array();
	
	$a_json_invalid = array(array("id" => "#", "value" => $term, "label" => "Only letters and digits are permitted..."));
	$json_invalid = json_encode($a_json_invalid);
	
	// replace multiple spaces with one
	$term = preg_replace('/\s+/', ' ', $size);
	
	// SECURITY HOLE ***************************************************************
	// allow space, any unicode letter and digit, underscore and dash
	if(preg_match("/[^\040\pL\pN_-]/u", $size)) {
		print $json_invalid;
		exit;
	}
	// *****************************************************************************
 	//$size = cleanChar(sanitize(trim($_POST["size"])));	
	$and = "";
	
	if($size != ""){
		$and = " AND ms.size_num  = ".$db->qStr($size);
	} 

	$company_id	=  is_numeric($_SESSION["company_id"]) == true ? $_SESSION["company_id"] : 0 ;
	$branch_id	=  is_numeric($_SESSION["branch_id"]) == true ? $_SESSION["branch_id"] : 0 ;

	$sql = "select
				p.id product_id,
				p.description,
				s.stock_value,
				s.sale_price
			from
				".$tblprefix."product p,
				".$tblprefix."stock s,
				".$tblprefix."size ms
			where
				p.id = s.product_id
				and p.size_id = ms.id
				and p.status = 'A'
				and s.stock_value > 0 
				and s.company_id = ".$db->qStr($company_id)."
				and s.branch_id = ".$db->qStr($branch_id)." $and  order by p.description asc ";  
	$rs		=	$db->Execute($sql) or die($db->errorMSg()); 
	$isrs	=	$rs->RecordCount();
	if($isrs > 0){
		while(!$rs->EOF){  
			$description 	 		 		= $rs->fields['description'];
			$a_json_row["id"] 		 		= $rs->fields['product_id'];
			$a_json_row["value"] 	 		= $description;
			$a_json_row["label"] 	 		= $description; 
			$a_json_row["stock_value"] 	 	= $rs->fields['stock_value'];
			$a_json_row["sale_price"] 		= $rs->fields['sale_price'];
			array_push($a_json, $a_json_row); 
			$rs->MoveNext();
		}
	}
	 //return json data
    echo json_encode($a_json);
} 
 


//Get Sub Category 
if($_GET['act']=='livesearchservice'){
	
	// prevent direct access
	$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
	if(!$isAjax) {
	$user_error = 'Access denied - not an AJAX request...';
	trigger_error($user_error, E_USER_ERROR);
	}
	
	$size = sanitize(trim($_GET["term"]));	
	
	$a_json = array();
	$a_json_row = array();
	
	$a_json_invalid = array(array("id" => "#", "value" => $term, "label" => "Only letters and digits are permitted..."));
	$json_invalid = json_encode($a_json_invalid);
	
	// replace multiple spaces with one
	$size = preg_replace('/\s+/', ' ', $size);
	
	// SECURITY HOLE ***************************************************************
	// allow space, any unicode letter and digit, underscore and dash
	if(preg_match("/[^\040\pL\pN_-]/u", $size)) {
		print $json_invalid;
		exit;
	}
	// *****************************************************************************
 	//$size = cleanChar(sanitize(trim($_POST["size"])));	
	$and = "";
	
	if($size != ""){
		$and = " AND s.name  like  '%".$size."%'";
	} 

	$company_id	=  is_numeric($_SESSION["company_id"]) == true ? $_SESSION["company_id"] : 0 ;
	$branch_id	=  is_numeric($_SESSION["branch_id"]) == true ? $_SESSION["branch_id"] : 0 ;

	$sql	=	"select s.id service_id,s.name,s.sale_price from ".$tblprefix."services s 
				where s.company_id = ".$db->qStr($company_id)."
				and s.branch_id = ".$db->qStr($branch_id)." $and  order by s.name asc ";  
	 
	$rs		=	$db->Execute($sql) or die($db->errorMSg()); 
	$isrs	=	$rs->RecordCount();
	if($isrs > 0){
		while(!$rs->EOF){  
			$description 	 		 		= $rs->fields['name'];
			$a_json_row["service_id"] 		= $rs->fields['service_id'];
			$a_json_row["value"] 	 		= $description;
			$a_json_row["label"] 	 		= $description;  
			$a_json_row["sale_price"] 		= $rs->fields['sale_price'];
			array_push($a_json, $a_json_row); 
			$rs->MoveNext();
		}
	}
	 //return json data
    echo json_encode($a_json);
} 



if($_GET['act']=='livesearchparts'){
	
	// prevent direct access
	$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
	if(!$isAjax) {
	$user_error = 'Access denied - not an AJAX request...';
	trigger_error($user_error, E_USER_ERROR);
	}

	$ptype = $_GET["ptype"];
	if($ptype == "tyres"){
		return;
	}
	
	// get what user typed in autocomplete input 
	$description = strtoupper(sanitize(trim($_GET["term"])));	
	
	$a_json = array();
	$a_json_row = array();
	
	$a_json_invalid = array(array("id" => "#", "value" => $term, "label" => "Only letters and digits are permitted..."));
	$json_invalid = json_encode($a_json_invalid);
	
	// replace multiple spaces with one
	$description = strtoupper(preg_replace('/\s+/', ' ', $description));
	
	 
  
	$and = "";
	if($description != ""){
	 	$and = " AND upper(p.description)  like '%".$description."%'";
	} 

	$company_id	=  is_numeric($_SESSION["company_id"]) == true ? $_SESSION["company_id"] : 0 ;
	$branch_id	=  is_numeric($_SESSION["branch_id"]) == true ? $_SESSION["branch_id"] : 0 ;

	$sql = "select
				p.id part_id,
				p.description,
				s.stock_value,
				s.sale_price
			from
				".$tblprefix."parts p,
				".$tblprefix."stock s 
			where
				p.id = s.part_id 
				and p.status = 'A' 
				and s.company_id = ".$db->qStr($company_id)."
				and s.branch_id = ".$db->qStr($branch_id)." $and  order by p.description asc ";
 
	$rs		=	$db->Execute($sql);
	$isrs	=	$rs->RecordCount();
	if($isrs > 0){
		while(!$rs->EOF){ 
			  
			$description 	 		 = $rs->fields['description']; 
			$a_json_row["part_id"] 	 = $rs->fields['part_id'];
			$a_json_row["value"] 	 = $description;
			$a_json_row["label"] 	 = $description;
			$a_json_row["stock_val"] = $rs->fields['stock_val']; 
			$a_json_row["sale_price"] = amount_format($rs->fields['sale_price']);
			array_push($a_json, $a_json_row); 
			$rs->MoveNext();
		}
	}
	 //return json data
    echo json_encode($a_json);
}

?>