<?php
include('root.php');
include($root.'config/conn.php');

    
if($_GET['act']=='addProduct'){

 	$productid 		= 	sanitize(trim($_GET["pro_id"]));	
	$qty 			= 	sanitize(trim($_GET["qty"])); 
	$price			= 	sanitize(trim($_GET["price"])); 
	$stock_value	= 	sanitize(trim($_GET["stock_value"]));	
	$action 		= 	sanitize(trim($_GET["action"]));	
	$stock_product	= 	sanitize(trim($_GET["stock_product"]));	


	if($qty > 0 && $productid != "" && $action != "del"){

		$_SESSION['cart']["product"]["product_id"][] = $productid;
		$_SESSION['cart']["product"][$productid]["qty"] = $qty;
		$_SESSION['cart']["product"][$productid]["price"] = $price;
		$_SESSION['cart']["product"][$productid]["description"] = $stock_product;
 
	}else{
		if (($key = array_search($productid, $_SESSION['cart']["product"]["product_id"])) !== false) {
		    unset($_SESSION['cart']["product"]["product_id"][$key]);
		} 
	}
}


if($_GET['act']=='addServices'){
	
 	$service_id 		= 	sanitize(trim($_GET["service_id"]));	
	$qty 				= 	sanitize(trim($_GET["qty"]));
	$service_price		= 	sanitize(trim($_GET["service_price"]));	
	$action 			= 	sanitize(trim($_GET["action"]));	
	$service 			= 	sanitize(trim($_GET["service"]));


	if($qty > 0 && $productid != "" && $action != "del"){

		$_SESSION['cart']["service"]["service_id"][] = $service_id;
		$_SESSION['cart']["service"][$service_id]["qty"] = $qty;
		$_SESSION['cart']["service"][$service_id]["price"] = $service_price;
		$_SESSION['cart']["service"][$service_id]["description"] = $service;
 
	}else{
		if (($key = array_search($productid, $_SESSION['cart']["service_id"]["service_id"])) !== false) {
		    unset($_SESSION['cart']["service"]["product_id"][$key]);
		} 
	}
}  

	
	 
if($_GET['act']=='addParts'){

 	$description_of_work_ids 		= 	sanitize(trim($_GET["description_of_work_ids"]));	
	$dow_price 						= 	sanitize(trim($_GET["dow_price"]));
	$description					= 	sanitize(trim($_GET["description"]));	
	$description_of_work			= 	sanitize(trim($_GET["description_of_work"]));	 
	$action 						= 	sanitize(trim($_GET["action"]));
	$del_id 						= 	sanitize(trim($_GET["del_id"])); 


	if($qty > 0 && $productid != "" && $action != "del"){

		$_SESSION['cart']["service"]["service_id"][] = $service_id;
		$_SESSION['cart']["service"][$service_id]["qty"] = $qty;
		$_SESSION['cart']["service"][$service_id]["price"] = $service_price;
		$_SESSION['cart']["service"][$service_id]["description"] = $service;
 
	}else{
		if (($key = array_search($productid, $_SESSION['cart']["service_id"]["service_id"])) !== false) {
		    unset($_SESSION['cart']["service"]["product_id"][$key]);
		} 
	}





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
  





 

?>