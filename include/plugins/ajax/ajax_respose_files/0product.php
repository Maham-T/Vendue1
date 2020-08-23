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
			$and = " AND (uf_only_digits(s.size)  like '".$size."%')";
	} 
	  $sql	=	"select p.id,p.description, ifnull(skt.stock_value,0) stock_value,  ifnull(skt.purchase_price,0) purchase_price from ".$tblprefix."product p
	join ".$tblprefix."size s on p.size = s.id 
	join ".$tblprefix."prod_skt skt on p.id = skt.product_id    
	WHERE ifnull(skt.stock_value,0) > 0 and skt.company_id = ".$db->qStr($_SESSION["company_id"])."   $and  order by p.description asc"; 
	
	$rs		=	$db->Execute($sql) or die($db->errorMSg()); 
	$isrs	=	$rs->RecordCount();
	if($isrs > 0){
		while(!$rs->EOF){ 
			$vat_price = $rs->fields['ms_price'] + $rs->fields['ms_price'] * VAT_VAL;
		
			$description 	 		 		= $rs->fields['description'];
			$a_json_row["id"] 		 		= $rs->fields['id'];
			$a_json_row["value"] 	 		= $description;
			$a_json_row["label"] 	 		= $description; 
			$a_json_row["stock_value"] 	 	= $rs->fields['stock_value'];
			$a_json_row["purchase_price"] 	= $rs->fields['purchase_price'];
			array_push($a_json, $a_json_row); 
			$rs->MoveNext();
		}
	}
	 //return json data
    echo json_encode($a_json);
}
 

if($_GET['act']=='livesearchparts'){
	
	//prevent direct access
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
	$description = strtoupper(sanitize(trim($_GET["psize"])));	
	
	$a_json = array();
	$a_json_row = array();
	
	$a_json_invalid = array(array("id" => "#", "value" => $description, "label" => "Only letters and digits are permitted..."));
	$json_invalid = json_encode($a_json_invalid);
	
	// replace multiple spaces with one
	$description = preg_replace('/\s+/', ' ', $description);
	
	// SECURITY HOLE ***************************************************************
	// allow space, any unicode letter and digit, underscore and dash
	if(preg_match("/[^\040\pL\pN_-]/u", $description)) {
	print $json_invalid;
	exit;
	}
	// *****************************************************************************
 	//$size = cleanChar(sanitize(trim($_POST["size"])));	
	$and = "";
	if($description != ""){
			$and = " AND upper(a.description)  like '%".$description."%'";
	}
 
	
   $sql = "SELECT  a.id,
				a.company_id,
				a.branch_id,
				a.description, 
				a.in_stock, 
				a.status
			FROM
				".$tblprefix."parts a
	 WHERE  a.company_id = ".$db->qStr($_SESSION["company_id"])." 
	 		and a.branch_id= ".$db->qStr($_SESSION["branch_id"]).$and; 
	$rs = $db->Execute($sql) or die($db->errorMSg());
	$isrs = $rs->RecordCount();
 
	
	if($isrs > 0){
		while(!$rs->EOF){ 
			$description 	 		 = $rs->fields['description']; 
			$a_json_row["id"] 		 = $rs->fields['id'];
			$a_json_row["value"] 	 = $description;
			$a_json_row["label"] 	 = $description; 
			array_push($a_json, $a_json_row); 
			$rs->MoveNext();
		}
	}
	 //return json data
    echo json_encode($a_json);
}

if($_GET['act']=='livesearchaccessories'){
	
	// prevent direct access
	$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
	if(!$isAjax) {
	$user_error = 'Access denied - not an AJAX request...';
	trigger_error($user_error, E_USER_ERROR);
	}
	
	// get what user typed in autocomplete input 
	$description = strtoupper(sanitize(trim($_GET["term"])));	
	
	$a_json = array();
	$a_json_row = array();
	
	$a_json_invalid = array(array("id" => "#", "value" => $term, "label" => "Only letters and digits are permitted..."));
	$json_invalid = json_encode($a_json_invalid);
	
	// replace multiple spaces with one
	$description = preg_replace('/\s+/', ' ', $description);
	
	// SECURITY HOLE ***************************************************************
	// allow space, any unicode letter and digit, underscore and dash
	// if(preg_match("/[^\040\pL\pN_-]/u", $description)) {
	// print $json_invalid;
	// exit;
	// }
	// *****************************************************************************
 	//$size = cleanChar(sanitize(trim($_POST["size"])));	
	$and = "";
	if($description != ""){
		//	$and = " AND upper(p.description)  like '%".$description."%'";
	}
	if($_SESSION["company_id"] > 0){
		$and 	.= " and p.company_id = ".$db->qStr($_SESSION["company_id"]);
	}
	
   $sql	=	"select p.id,
				   p.size,
				   p.description,
				   p.pcs_box,
				   p.unit_price_box,
				   p.stock_val, 
				   p.image, 
				   p.status from ".$tblprefix."accessories p  
				   WHERE p.stock_val > 0 and p.status = 'A'  
				   $and order by p.description asc";
	$rs		=	$db->Execute($sql);
	$isrs	=	$rs->RecordCount();
	if($isrs > 0){
		while(!$rs->EOF){ 
			$vat_price = $rs->fields['unit_price_box'] + $rs->fields['unit_price_box'] * VAT_VAL;
		
			// $description 	 		 =$rs->fields['description'].' (Unit Price: '.amount_format($rs->fields['unit_price_box']).', Stock Value: '.$rs->fields['stock_val'].')';

			$description 	 		 = $rs->fields['description']; 
			$a_json_row["id"] 		 = $rs->fields['id'];
			$a_json_row["value"] 	 = $description;
			$a_json_row["label"] 	 = $description;
			$a_json_row["stock_val"] = $rs->fields['stock_val']; 
			$a_json_row["unit_price_box"] = amount_format($rs->fields['unit_price_box']);
			array_push($a_json, $a_json_row); 
			$rs->MoveNext();
		}
	}
	 //return json data
    echo json_encode($a_json);
}

if($_GET['act']=='livesearchservice'){
	
	// prevent direct access
	$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
	if(!$isAjax) {
	$user_error = 'Access denied - not an AJAX request...';
	trigger_error($user_error, E_USER_ERROR);
	}
	
	// get what user typed in autocomplete input
	//$size = sanitize(trim($_GET['term']));
	$size =  sanitize(trim($_GET["term"]));	
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
			$and = " AND (upper(s.name)  like '".strtoupper($size)."%')";
	}
	if($_SESSION["company_id"] > 0){
		//$and 	.= " and s.company_id = ".$db->qStr($_SESSION["company_id"]);
	}
    $sql	=	"select s.id,s.name,s.price from ".$tblprefix."services s where 1=1 $and  order by s.name asc"; 
	
	$rs		=	$db->Execute($sql) or die($db->errorMSg()); 
	$isrs	=	$rs->RecordCount();
	if($isrs > 0){
		while(!$rs->EOF){ 
			$vat_price = $rs->fields['price'] + $rs->fields['price'] * VAT_VAL; 
			$description 	 		 = $rs->fields['name'];
			$a_json_row["id"] 		 = $rs->fields['id'];
			$a_json_row["value"] 	 = $description;
			$a_json_row["label"] 	 = $description; 
			$a_json_row["price"] = amount_format($rs->fields['price']);
			array_push($a_json, $a_json_row); 
			$rs->MoveNext();
		}
	}
	 //return json data
    echo json_encode($a_json);
}

if($_GET['act']=='addProduct'){
 	$productid 	= 	sanitize(trim($_GET["pro_id"]));	
	$qty 		= 	sanitize(trim($_GET["qty"]));

	$price		= 	sanitize(trim($_GET["price"]));

	$stock_value	= 	sanitize(trim($_GET["stock_value"]));	
	$action 	= 	sanitize(trim($_GET["action"]));	
	if($qty > 0 && $productid != "" && $action != "del"){
	    $sql	=	"select * from ".$tblprefix."v_products WHERE product_id = '".$productid."'";
		$rs		=	$db->Execute($sql) or die($db->errorMSg());
		$isrs	=	$rs->RecordCount();
		if($isrs > 0){
			$_SESSION['cart'][$productid]['product_id']			=	$rs->fields['product_id']; 
			$_SESSION['cart'][$productid]['description']		=	$rs->fields['description']; 
			$_SESSION['cart'][$productid]['purchase_price']		=	$rs->fields['purchase_price']; 
			$_SESSION['cart'][$productid]['price']				=	$price;  
			$_SESSION['cart'][$productid]['stock_value']		=	$stock_value;   
			$_SESSION['cart'][$productid]['qty']				=	$qty; 	
		}elseif($qty == 0){
			unset($_SESSION['cart'][$productid]); 
		}
	}else{
		unset($_SESSION['cart'][$productid]); 	
	}
	
	$total_items = count($_SESSION['cart']);
	if($total_items>0)
	{						
	?> 
	<table id="SpecialOffers" class="table table-sm table-hover table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr> 
				<th width="35%">Discription</th> 
				<th width="8%" class="text-right">In Stock</th>  
				<th width="3%" class="text-center">F</th>
				<th width="3%" class="text-center">W</th>
				<th width="3%" class="text-center">Db</th>
				<th width="3%" class="text-center">CI</th>
                <!-- <th width="10%" class="text-right">Plus Vat Price</th> -->
                <th width="10%" class="text-right">Price</th>
				<th width="8%" class="text-center">Quantity</th>  
                <th width="8%" class="text-center">Total</th>  
                <td width="2%" class="text-center">&nbsp;</td>
			</tr>
		</thead>                         
		<tbody>
			<?
			$_SESSION['gtotal_val'] = "";
			foreach($_SESSION['cart'] as $key => $value)
			{ 
				$productid			=	$_SESSION['cart'][$key]['product_id'];
				$qty				=	$_SESSION['cart'][$key]['qty'];
				$price  			=	$_SESSION['cart'][$key]['price'];
				$stock_value  		=	$_SESSION['cart'][$key]['stock_value'];
				$sql = "SELECT p.product_id,
							   p.EAN,
							   p.description,
							   p.category,
							   p.size size_id,
							   p.brand_id, 
							   p.pattern,
							   p.load_speed,
							   p.ply_rating,
							   p.brand_category,
							   p.run_on_flat,
							   p.OE_sidewall,
							   p.fitment_instruction,
							   p.season,
							   p.manufacturers_code,
							   p.rim_size,
							   p.mold_id,
							   p.image,
							   p.tyre_label, 
							   p.F,
							   p.W,
							   p.DB,
							   p.CI
						  FROM ".$tblprefix."v_products p 
						 WHERE  p.product_id = '".$productid."'";
				$rs = $db->Execute($sql) or die($db->errorMSg());
				$vat_price = $price; //+ $price * VAT_VAL;
			 	$totalQtry += $qty;
				$gtotal = $vat_price  * $qty;
				$plusVarTotal +=  $price * $qty;
				$vatTotal +=  $price * $qty * VAT_VAL;
				//$_SESSION['gtotal_val'] = $_SESSION['gtotal_val'] + $gtotal ;
				
			?>                            
			<tr> 
				<td><?=$rs->fields["description"]?></td>  
				<td class="text-right"><?=$stock_value?></td>    
				<td class="text-center"><?=$rs->fields["W"]?></td> 
				<td class="text-center"><?=$rs->fields["F"]?></td> 
				<td class="text-center"><?=$rs->fields["DB"]?></td> 
				<td class="text-center"><?=$rs->fields["CI"]?></td> 
                <!-- <td class="text-right">&pound;<?=amount_format($price)?></td> -->
                <td class="text-right">&pound;<?=amount_format($vat_price)?></td>
				<td class="text-center">
                <?=$qty?>
					 <input type="hidden"  value="<?=$rs->fields["product_id"]?>" name="product_id[]" id="id<?=$rs->fields["product_id"]?>">
					<input type="hidden"  value="<?=$rs->fields["ms_price"]?>" name="ms_price_<?=$rs->fields["product_id"]?>" id="ms_price<?=$rs->fields["product_id"]?>">
					<input type="hidden" class="qtyinput" min="0" value="<?=$qty?>" name="qty_<?=$rs->fields["product_id"]?>" id="qty<?=$rs->fields["product_id"]?>">                                
				</td>
                <td class="text-right">
                	<?
                    	$total = $vat_price * $qty;
						$gTotal += $total; 
						echo "&pound;".amount_format($total);
					?>
                </td>
                <td class="text-center">
                	<a onclick="removeProducts('<?=$rs->fields["product_id"]?>')" href="javascript:;" class="font-red-thunderbird"><i class="fas fa-trash-alt text-red"></i></a>
                </td>
			</tr>
			<? 							 
			}  
			?> 
			 <tr>
				<td colspan="8" class="text-right"><strong>Total Quantity	</strong></td>
                <td class="text-right"><strong> <?=$totalQtry;?></strong>   </td>
                <td>&nbsp;</td>
			</tr> 
			 <!-- <tr>
				<td colspan="9" class="text-right"><strong>Plus VAT Price</strong></td>
                <td class="text-right"><strong>&pound;<?=amount_format($plusVarTotal);?></strong>
				 <input type="hidden" value="<?=$gTotal?>" name="gtotal_val" id="gtotal_val">   </td>
                <td>&nbsp;</td>
			</tr> 
			<tr>
				<td colspan="9" class="text-right"><strong>VAT</strong></td>
                <td class="text-right"><strong>&pound;<?=amount_format($vatTotal);?></strong>
				 <input type="hidden" value="<?=$gTotal?>" name="gtotal_val" id="gtotal_val">   </td>
                <td>&nbsp;</td>
			</tr> -->
            <tr>
				<td colspan="8" class="text-right"><strong>Total</strong></td>
                <td class="text-right"><strong>&pound;<?=amount_format($gTotal);?></strong>
				 <input type="hidden" value="<?=$gTotal?>" name="gtotal_val" id="gtotal_val">   </td>
                <td>&nbsp;</td>
			</tr> 
		</tbody>
	</table> 
 	<?
	}
	else
	{
		$_SESSION['type'] = "warning";	
		$_SESSION['msg']  = 'norecordfound';
		getmsg($tblprefix);  
	}  
}

if($_GET['act']=='addAccessories'){

 	$description_of_work_ids 		= 	sanitize(trim($_GET["description_of_work_ids"]));	
	$dow_price 						= 	sanitize(trim($_GET["dow_price"]));
	$description					= 	sanitize(trim($_GET["description"]));	
	$description_of_work			= 	sanitize(trim($_GET["description_of_work"]));	 
	$action 						= 	sanitize(trim($_GET["action"]));
	$del_id 						= 	sanitize(trim($_GET["del_id"]));
	$indexId 						=	count($_SESSION['acccart']) + 1;
	if($dow_price > 0 && $description_of_work_ids != "" && $action != "del"){
		$_SESSION['acccart'][$indexId]['indexId'] 					=	$indexId ;
		$_SESSION['acccart'][$indexId]['description_of_work_ids'] 	=	$description_of_work_ids ; 
		$_SESSION['acccart'][$indexId]['dow_price']					= 	$dow_price; 
		$_SESSION['acccart'][$indexId]['description']				=	$description;  
		$_SESSION['acccart'][$indexId]['description_of_work']		=	$description_of_work;   


	}else{
		unset($_SESSION['acccart'][$acc_id]); 	
	}
	
	$total_items = count($_SESSION['acccart']);
	if($total_items>0)
	{						
	?> 
	<table id="SpecialOffers" class="table table-sm table-hover table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr> 
				<th width="35%">Description of Work</th> 
				<th width="35%">Discription</th>  
                <th width="10%" class="text-right">Price</th> 
                <td width="2%" class="text-center">&nbsp;</td>
			</tr>
		</thead>                         
		<tbody>
			<?
			$_SESSION['gtotal_val'] = "";
			foreach($_SESSION['acccart'] as $key => $value)
			{ 
				$gTotal += 	 $_SESSION['acccart'][$indexId]['dow_price'];
			?>                            
			<tr> 
				<td><?=$_SESSION['acccart'][$indexId]['description_of_work']?></td> 
				<td><?=$_SESSION['acccart'][$indexId]['description']?></td>   
                <td class="text-right">&pound;<?=amount_format($_SESSION['acccart'][$indexId]['dow_price'])?></td> 
                <td class="text-center">
					<a onclick="removeAccessories('<?=$_SESSION['acccart'][$indexId]['indexId']?>')" href="javascript:;" class="font-red-thunderbird"><i class="fa  fa-trash text-red"></i></a>  
                </td>
			</tr>
			<? 							 
			}  
			?> 
			<tr>
				<td colspan="2" class="text-right"><strong>Total  	</strong></td>
                <td class="text-right"><strong>  &pound;<?=amount_format($gTotal);?></strong>   </td>
                <td>&nbsp;</td>
			</tr>  
		</tbody>
	</table> 
 	<?
	}
	else
	{
	
		$_SESSION['type'] = "warning";	
		$_SESSION['msg']  = 'norecordfound';
		getmsg($tblprefix); 
	} 	  
}
  
if($_GET['act']=='addServices'){
	
 	$service_id 		= 	sanitize(trim($_GET["service_id"]));	
	$qty 				= 	sanitize(trim($_GET["qty"]));
	$service_price		= 	sanitize(trim($_GET["service_price"]));	
	$action 	= 	sanitize(trim($_GET["action"]));	
	if($qty > 0 && $service_id != "" && $action != "del"){
		$sql	=	"select * from ".$tblprefix."services WHERE id = ".$db->qStr($service_id); 
		$rs		=	$db->Execute($sql);
		$isrs	=	$rs->RecordCount();
		if($isrs > 0){
			$_SESSION['sercart'][$service_id]['service_id']			=	$rs->fields['id']; 
			$_SESSION['sercart'][$service_id]['name']				=	$rs->fields['name']; 
			$_SESSION['sercart'][$service_id]['service_price']		=	$service_price; 
			$_SESSION['sercart'][$service_id]['purchase_price']		=	$rs->fields['purchase_price'];  
			$_SESSION['sercart'][$service_id]['qty']				=	$qty; 	
		}elseif($qty == 0){
			unset($_SESSION['sercart'][$service_id]); 
		}
	}else{
		unset($_SESSION['sercart'][$service_id]); 	
	}
	
	$total_items = count($_SESSION['sercart']);
	if($total_items>0)
	{		 
	?> 
	<table id="SpecialOffers" class="table table-sm table-hover table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr> 
				<th width="35%">Discription</th> 
               <!--  <th width="10%" class="text-right">Plus Vat Price</th> -->
                <th width="10%" class="text-right">Price</th>
				<th width="8%" class="text-center">Quantity</th>  
                <th width="8%" class="text-center">Total</th>  
                <td width="2%" class="text-center">&nbsp;</td>
			</tr>
		</thead>                         
		<tbody>
			<?
			$_SESSION['gtotal_val'] = "";
			foreach($_SESSION['sercart'] as $key => $value)
			{ 
				$service_id			=	$_SESSION['sercart'][$key]['service_id'];
				$qty				=	$_SESSION['sercart'][$key]['qty'];
				$service_price  	=	$_SESSION['sercart'][$key]['service_price'];
				$sql = "SELECT *  from ".$tblprefix."services p
						 WHERE  p.status = 'A' 
						   AND p.id = '".$service_id."'";
				$rs = $db->Execute($sql); 
				
				$vat_price = $service_price ;//+ $service_price * VAT_VAL;
		 
				$totalQtry += $qty; 
				$plusVarTotal +=  $service_price  * $qty;
				$vatTotal +=  $vat_price * $qty;
				$_SESSION['ser_gtotal_val'] = $_SESSION['ser_gtotal_val'] + $gtotal ;
				
			?>                            
			<tr> 
				<td><?=$rs->fields["name"]?></td>  
                <!-- <td class="text-right">&pound;<?=amount_format($service_price)?></td> -->
                <td class="text-right">&pound;<?=amount_format($vat_price)?></td>
				<td class="text-center">
                <?=$qty?>
					 <input type="hidden"  value="<?=$rs->fields["id"]?>" name="service_id[]" id="id<?=$rs->fields["id"]?>">
					<input type="hidden"  value="<?=$rs->fields["service_price"]?>" name="service_price<?=$rs->fields["id"]?>" id="service_price<?=$rs->fields["service_price"]?>">
					<input type="hidden" class="qtyinput" min="0" value="<?=$qty?>" name="serqty_<?=$rs->fields["id"]?>" id="serqty<?=$rs->fields["id"]?>">                                
				</td>
                <td class="text-right">
                	<?
                    	$total = $vat_price * $qty;
						$gTotal += $total; 
						echo "&pound;".amount_format($total);
					?>
                </td>
                <td class="text-center">
					<a onclick="removeServices('<?=$rs->fields["id"]?>')" href="javascript:;" class="font-red-thunderbird"><i class="fa fa-trash  text-red"></i></a> 
                </td>
			</tr>
			<? 							 
			}  
			?> 
             <tr>
				<td colspan="3" class="text-right"><strong>Total Quantity	</strong></td>
                <td class="text-right"><strong> <?=$totalQtry;?></strong>   </td>
                <td>&nbsp;</td>
			</tr> 
			<!--  <tr>
				<td colspan="4" class="text-right"><strong>Plus VAT Price</strong></td>
                <td class="text-right"><strong>&pound;<?=amount_format($plusVarTotal);?></strong>
				 <input type="hidden" value="<?=$gTotal?>" name="gtotal_val" id="gtotal_val">   </td>
                <td>&nbsp;</td>
			</tr> 
			<tr>
				<td colspan="4" class="text-right"><strong>VAT</strong></td>
                <td class="text-right"><strong>&pound;<?=amount_format($vatTotal);?></strong>
				 <input type="hidden" value="<?=$gTotal?>" name="gtotal_val" id="gtotal_val">   </td>
                <td>&nbsp;</td>
			</tr> -->
			<tr>
				<td colspan="3" class="text-right"><strong>Total</strong></td>
                <td class="text-right"><strong>&pound;<?=amount_format($gTotal);?></strong></td>
                <td>&nbsp;</td>
			</tr> 
			
		</tbody>
	</table> 
 	<?
	}
	else
	{
	
		$_SESSION['type'] = "warning";	
		$_SESSION['msg']  = 'norecordfound';
		getmsg($tblprefix); 
	} 	  
}
 







if($_POST['act']=='findProduct'){

 	$supplier_id 	= sanitize(trim($_POST["supplier_id_sel"]));
 	$ptype 			= sanitize(trim($_POST["ptype"]));	 
 	$branch_id 		= sanitize(trim($_POST["branch_id"]));	 
	

	if($ptype == "tyres"){
		$size 			= cleanChar(sanitize(trim($_POST["size"]))); 
		$and 	  = "";
		if($size != ""){
			$and .= " AND (uf_only_digits(s.size)  like '%".$size."%')";
		}

		if($_POST["run_on_flat"] != ""){
			$run_on_flat = $_POST["run_on_flat"];
			if($run_on_flat != ""){ 
				$and .= " and run_on_flat = ".$db->qStr($run_on_flat);
			}
		}

		if(is_array($_POST["season"])){
			$season 	= implode(",",$_POST["season"]);
			if($season != ""){
				  $and .= " AND p.season in ('".$season."')"; 
			}	
		}
		if(is_array($_POST["category"])){
			$category 	= implode(",",$_POST["category"]);	
			if($category != ""){
				$and .= " AND p.category in ('".$category."')";
			}
		}
		if(is_array($_POST["brand_cat"])){
			$brand_cat 	= implode(",",$_POST["brand_cat"]);	
			if($brand_cat != ""){
				$and .= " AND p.brand_category in ('".$brand_cat."')";
			}
		}
		$brand_id = sanitize($_POST["brand_id"]);	
		if($brand_id != ""){
			$and .= " AND p.brand_id = '".$brand_id."'";
		}

		if($supplier_id == 1){ 

			$and .= " AND p.status = 'A'  ";

			$tnt_cust_id = $_SESSION["tnt_cust_id"];
			if($tnt_cust_id == 0){
				$_SESSION['type'] = "warning";	
				$_SESSION['msg']  = 'integration_mapping_error';
				getmsg($tblprefix); 
				exit;
			} 

			$rate_variation =  0;
			$sqlc  =	"select p.rate_variation from ".$tblprefix."price_plan p,".$tblprefix."tnt_branch c WHERE c.id = ".$db->qStr($tnt_cust_id)." and c.plan_id = p.id";
			$rsc		=	$db->Execute($sqlc) or die($db->errorMsg());
			$isrsc	=	$rsc->RecordCount();	
			if($isrsc > 0){
				$rate_variation = $rsc->fields['rate_variation'];
			}

		}
		
		
		$sql = "SELECT p.id as product_id,
					   p.EAN,
					   p.description,
					   p.category,
					   p.size,
					   p.brand_id,
					   b.name as brand,
					   p.pattern,
					   p.load_speed,
					   p.ply_rating,
					   p.brand_category,
					   p.run_on_flat,
					   p.OE_sidewall,
					   p.fitment_instruction,
					   p.season,
					   p.manufacturers_code,
					   p.rim_size,
					   p.mold_id,
					   p.image,
					   p.tyre_label,
					   p.tnt_price,
					   p.retail_price,
					   p.local_stk,
					   p.total_stk,
					   p.F,
					   p.W,
					   p.DB,
					   p.CI
				  FROM ".$tblprefix."product p, ".$tblprefix."brands b  , ".$tblprefix."size s 
				 WHERE p.brand_id = b.id
				 	and p.size = s.id
				    $and  "; 
		$rs = $db->Execute($sql) or die($db->errorMsg());
		$isrs = $rs->RecordCount();
	 
	    if($isrs>0){
		?>
	    <form action="<?=MYSURL?>include/plugins/ajax/ajax_respose_files/addtocart.php" enctype="multipart/form-data" method="post" id="frmaddtocart" name="frmaddtocart"> 
	   <table width="100%" class="table table-sm  bg-white table-bordered table-hover">
	        <thead>
	            <tr> 
	                <th width="46%">Discription</th>
	                <? if($supplier_id == 1){  ?>
	                <th width="10%" class="text-right">Plus Vat Price</th>
	                <th width="10%" class="text-right">Inc. VAT Price</th> 
	                <th width="8%" class="text-right">In Stock</th> 
	           		<? } ?>
	                <th width="3%" class="text-center">F</th>
	                <th width="3%" class="text-center">W</th>
	                <th width="3%" class="text-center">Db</th>
	                <th width="3%" class="text-center">CI</th>
	                 <? if($supplier_id != 1){  ?>
	                <th width="8%">Price</th> 
	           	    <? } ?>
	                <th width="8%">Quantity</th> 
	            </tr>
	        </thead>                         
	        <tbody>
	            <? while (!$rs->EOF){
						$tnt_price = $rs->fields["tnt_price"] + $rate_variation;	
						$vat_price = $tnt_price + $tnt_price * 0.2;	
						
						$in_stk = $rs->fields["local_stk"] + $rs->fields["total_stk"];
						if($in_stk > 50){
							$in_stk = 50;
						} 
					 ?>
	            <tr> 
	                <td><?=$rs->fields["description"]?></td> 
	                 <? if($supplier_id == 1){  ?>
	                <td class="text-right">&pound;<?=amount_format($tnt_price)?></td>
	                <td class="text-right">&pound;<?=amount_format($vat_price)?></td>
	                <td class="text-right"><?=$in_stk?></td>
	                <? } ?> 
	                <td class="text-center"><?=$rs->fields["F"]?></td> 
	                <td class="text-center"><?=$rs->fields["W"]?></td> 
	                <td class="text-center"><?=$rs->fields["DB"]?></td> 
	                <td class="text-center"><?=$rs->fields["CI"]?></td> 
	                 <? if($supplier_id != 1){  ?>
	                <td>
	                	 <input type="number" min="0" step="0.01"  value="0" name="tnt_price_<?=$rs->fields["product_id"]?>" class="form-control text-center form-control-sm"  id="tnt_price<?=$rs->fields["product_id"]?>">
	                </td> 
	           	    <? } ?>
	                <td>
	                <? if($supplier_id == 1){  ?>
	                 <input type="hidden"  value="<?=$tnt_price?>" name="tnt_price_<?=$rs->fields["product_id"]?>" id="tnt_price<?=$rs->fields["product_id"]?>"> 
	                	<?
	                    $disabled = "";
						if($in_stk == 0){
							$disabled = "disabled";
						}
						?>
						 <input type="number" <?=$disabled;?> class="form-control text-center form-control-sm" min="0" max="<?=$rs->fields["local_stk"]?>" value="0" name="qty_<?=$rs->fields["product_id"]?>" id="qty<?=$rs->fields["product_id"]?>">

						<? }else{

							?>
							<input type="number" class="form-control text-center form-control-sm" min="0" value="0" name="qty_<?=$rs->fields["product_id"]?>" id="qty<?=$rs->fields["product_id"]?>">
							<?
						} ?>


	                    <input type="hidden"  value="<?=$rs->fields["product_id"]?>" name="product_id[]" id="id<?=$rs->fields["product_id"]?>">
	                   
	                   

	                    <input type="hidden" value="<?=$supplier_id?>" id="supplierid" name="supplierid">
	                </td>
	            </tr>
	            <? 
				$rs->MoveNext(); 
				} 
				?>
	            <tr>
	            	<td colspan="10">
	            		<button class="btn btn-primary btn-sm btn-flat float-right" type="submit" name="addtocart0" id="addtocart">Add & continue</button>
	            		<input type="hidden" name="addtocart" id="addtocart" value="addtocart">
	            	</td>
	            </tr>
	        </tbody>
	    </table>

	    </form>
	    <script type="text/javascript">
	    	$("#frmaddtocart").submit(function(e) { 
			    e.preventDefault(); // avoid to execute the actual submit of the form.

			   $("#eresDiv").html('<div class="padding10px"><img src="'+jsmysurl+'assets/img/ajax-processing.gif" style="padding-right:0px;"  /></div>');  	
		
			    var form = $(this);
			    var url = form.attr('action');

			    $.ajax({
			           type: "POST",
			           url: url,
			           data: form.serialize(), // serializes the form's elements.
			           success: function(data)
			           {
			               $("#cardDiv").html(data);
			               $("#resDiv").html(""); 
						   $("#eresDiv").html(""); 
						   $("#size").val("");	 	 
						   $("#size").focus();
			           }
			    }); 
			}); 
	    </script>
	    <?  
		}
		else
		{
			$_SESSION['type'] = "warning";	
			$_SESSION['msg']  = 'norecordfound';
			getmsg($tblprefix);  
		} 	
	}else{
		$size 			= sanitize(trim($_POST["size"])); 
		$and 	  = "";
		if($size != ""){
			$and .= " AND (upper(a.description)  like upper('%".$size."%'))";
		} 
		$branch_id = sanitize($_POST["branch_id"]);	
		if($branch_id != ""){
			$and .= " AND a.company_id = '".$branch_id."'";
		}
  
		
		$sql = "SELECT a.id as acc_id,
					   a.company_id,
					   a.description,
					   a.purchase_price,
					   a.unit_price_box,
					   a.stock_val 
				  FROM ".$tblprefix."accessories a where 1=1
				    $and  "; 
		$rs = $db->Execute($sql) or die($db->errorMsg());
		$isrs = $rs->RecordCount();
	 
	    if($isrs>0){
		?>
	    <form action="<?=MYSURL?>include/plugins/ajax/ajax_respose_files/addtocart.php" enctype="multipart/form-data" method="post" id="frmaddtocart" name="frmaddtocart"> 
	   <table width="100%" class="table table-sm  bg-white table-bordered table-hover">
	        <thead>
	            <tr> 
					<th width="46%">Discription</th>   
					<th width="8%">Quantity</th> 
					<th width="8%">Price</th> 
	            </tr>
	        </thead>                         
	        <tbody>
	            <? while (!$rs->EOF){ ?>
	            <tr> 
	                <td><?=$rs->fields["description"]?></td> 
	                <td> <input type="number" class="form-control text-center form-control-sm" min="0" value="0" name="qty_<?=$rs->fields["acc_id"]?>" id="qty<?=$rs->fields["acc_id"]?>"> </td>  
	                <td> <input type="number" class="form-control text-center form-control-sm" min="0" step="0.01"  value="0" name="price_<?=$rs->fields["acc_id"]?>" id="price_<?=$rs->fields["acc_id"]?>"> 
	                    <input type="hidden"  value="<?=$rs->fields["acc_id"]?>" name="acc_id[]" id="id<?=$rs->fields["acc_id"]?>">  
	                    <input type="hidden" value="<?=$supplier_id?>" id="supplierid" name="supplierid">
	                </td>
	            </tr>
	            <? 
				$rs->MoveNext(); 
				} 
				?>
	            <tr>
	            	<td colspan="10">
	            		<button class="btn btn-primary btn-sm btn-flat float-right" type="submit" name="addtocart0" id="addtocart">Add & continue</button>
	            		<input type="hidden" name="addtocart" id="addtocart" value="addtocart">
	            	</td>
	            </tr>
	        </tbody>
	    </table>

	    </form>
	    <script type="text/javascript">
	    	$("#frmaddtocart").submit(function(e) { 
			    e.preventDefault(); // avoid to execute the actual submit of the form.

			   $("#eresDiv").html('<div class="padding10px"><img src="'+jsmysurl+'assets/img/ajax-processing.gif" style="padding-right:0px;"  /></div>');  	
		
			    var form = $(this);
			    var url = form.attr('action');

			    $.ajax({
			           type: "POST",
			           url: url,
			           data: form.serialize(), // serializes the form's elements.
			           success: function(data)
			           {
			               $("#cardDiv").html(data);
			               $("#resDiv").html(""); 
						   $("#eresDiv").html(""); 
						   $("#size").val("");	 	 
						   $("#size").focus();
			           }
			    }); 
			}); 
	    </script>
	    <?  
		}
		else
		{
			$_SESSION['type'] = "warning";	
			$_SESSION['msg']  = 'norecordfound';
			getmsg($tblprefix);  
		}

	}

}


?>