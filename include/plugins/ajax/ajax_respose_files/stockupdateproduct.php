<?php
include('root.php');
include($root.'config/conn.php');
   

if($_GET['act']=='addProduct'){
 	$productid 		= 	sanitize(trim($_GET["pro_id"]));	
	$qty 			= 	sanitize(trim($_GET["qty"])); 
	$price			= 	sanitize(trim($_GET["price"])); 
	$stock_value	= 	sanitize(trim($_GET["stock_value"]));	
	$action 		= 	sanitize(trim($_GET["action"]));	
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
 	$acc_id 		= 	sanitize(trim($_GET["acc_id"]));	
	$qty 			= 	sanitize(trim($_GET["qty"]));
	$unit_price_box	= 	sanitize(trim($_GET["unit_price_box"]));	
	$action 	= 	sanitize(trim($_GET["action"]));	
	if($qty > 0 && $acc_id != "" && $action != "del"){
		$sql	=	"select * from ".$tblprefix."accessories WHERE id = '".$acc_id."'";
		$rs		=	$db->Execute($sql);
		$isrs	=	$rs->RecordCount();
		if($isrs > 0){
			$_SESSION['acccart'][$acc_id]['acc_id']				=	$rs->fields['id']; 
			$_SESSION['acccart'][$acc_id]['description']		=	$rs->fields['description']; 
			$_SESSION['acccart'][$acc_id]['unit_price_box']		=	$unit_price_box;  
			$_SESSION['acccart'][$acc_id]['stock_value']		=	$rs->fields['stock_value'];  
			$_SESSION['acccart'][$acc_id]['purchase_price']		=	$rs->fields['purchase_price'];   
			$_SESSION['acccart'][$acc_id]['qty']				=	$qty; 	 

		}elseif($qty == 0){
			unset($_SESSION['acccart'][$acc_id]); 
		}
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
				<th width="35%">Discription</th> 
				<th width="8%" class="text-right">In Stock</th>
				<!-- <th width="9%" class="text-right">Remote Stock</th>  
                <th width="10%" class="text-right">Plus Vat Price</th> -->
                <th width="10%" class="text-right"> Price</th>
				<th width="8%" class="text-center">Quantity</th>  
                <th width="8%" class="text-center">Total</th>  
                <td width="2%" class="text-center">&nbsp;</td>
			</tr>
		</thead>                         
		<tbody>
			<?
			$_SESSION['gtotal_val'] = "";
			foreach($_SESSION['acccart'] as $key => $value)
			{ 
				$acc_id				=	$_SESSION['acccart'][$key]['acc_id'];
				$qty				=	$_SESSION['acccart'][$key]['qty'];
				$unit_price_box  	=	$_SESSION['acccart'][$key]['unit_price_box'];
				$sql = "SELECT p.id acc_id,
							   p.size,
							   p.description,
							   p.pcs_box,
							   p.unit_price_box,
							   p.stock_val, 
							   p.image, 
							   p.status  from ".$tblprefix."accessories p
						 WHERE  p.status = 'A' 
						   AND p.id = '".$acc_id."'";
				$rs = $db->Execute($sql); 
				
				$vat_price = $unit_price_box + $unit_price_box * VAT_VAL; 
				$gtotal = $vat_price  * $qty;
				$totalQtry += $qty;
				$plusVarTotal += $unit_price_box  * $qty;
				$vatTotal += $unit_price_box * VAT_VAL  * $qty;
			?>                            
			<tr> 
				<td><?=$rs->fields["description"]?></td>  
				<td class="text-right"><?=$rs->fields["stock_val"]?></td>  
                <td class="text-right">&pound;<?=amount_format($unit_price_box)?></td>
				<td class="text-center">
                <?=$qty?>
					 <input type="hidden"  value="<?=$rs->fields["acc_id"]?>" name="acc_id[]" id="id<?=$rs->fields["acc_id"]?>">
					<input type="hidden"  value="<?=$rs->fields["unit_price_box"]?>" name="unit_price_box_<?=$rs->fields["acc_id"]?>" id="unit_price_box<?=$rs->fields["unit_price_box"]?>">
					<input type="hidden" class="qtyinput" min="0" value="<?=$qty?>" name="accqty_<?=$rs->fields["acc_id"]?>" id="accqty<?=$rs->fields["acc_id"]?>">                                
				</td>
                <td class="text-right">
                	<?
                    	$total = $unit_price_box * $qty;
						$gTotal += $total; 
						echo "&pound;".amount_format($total);
					?>
                </td>
                <td class="text-center">
					<a onclick="removeAccessories('<?=$rs->fields["acc_id"]?>')" href="javascript:;" class="font-red-thunderbird"><i class="fa fa-fa-trash text-red"></i></a>  
                </td>
			</tr>
			<? 							 
			}  
			?> 
			<tr>
				<td colspan="4" class="text-right"><strong>Total Quantity	</strong></td>
                <td class="text-right"><strong> <?=$totalQtry;?></strong>   </td>
                <td>&nbsp;</td>
			</tr> 
			<!--  <tr>
				<td colspan="5" class="text-right"><strong>Plus VAT Price</strong></td>
                <td class="text-right"><strong>&pound;<?=amount_format($plusVarTotal);?></strong>   </td>
                <td>&nbsp;</td>
			</tr> 
			<tr>
				<td colspan="7" class="text-right"><strong>VAT</strong></td>
                <td class="text-right"><strong>&pound;<?=amount_format($vatTotal);?></strong>   </td>
                <td>&nbsp;</td>
			</tr> -->
            <tr>
				<td colspan="4" class="text-right"><strong>Total</strong></td>
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
				
				$vat_price = $service_price + $service_price * VAT_VAL;
		 
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

 	$supplier_id 	= sanitize(trim($_POST["supplier_id_stock"]));
 	$ptype 			= sanitize(trim($_POST["ptype"]));	 
 	$branch_id 		= sanitize(trim($_POST["branch_id"]));	  

	if($ptype == "tyres"){

		$size 			= cleanChar(sanitize(trim($_POST["psize"]))); 

		$and 	  = "";
		if($size != ""){
			$and .= " AND s.size_num = ".$db->qStr($size);
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

	 	
	 	$sql = "SELECT  p.id,
						p.description,
						p.remarks,
						p.ean,
						p.supplier_code,
						p.brand_id,
						b.name brand,
						p.pattern,
						p.width,
						p.aspect_ratio,
						p.rim,
						p.size_id,
						s.size,
						s.size_num,
						p.load_index,
						p.speed_rating,
						p.reinforced,
						p.runflat,
						p.runflat_desc,
						p.product_type,
						p.vehicle_type,
						p.ec_vehicle_class,
						p.noise_performance,
						p.noise_class_type,
						p.wet_grip,
						p.rolling_resistance,
						p.status
					FROM
						".$tblprefix."product p, ".$tblprefix."brands b , ".$tblprefix."size s 
	 WHERE  p.brand_id = b.id and p.size_id = s.id ".$and;   

		 
		$rs = $db->Execute($sql) or die($db->errorMsg());
		$isrs = $rs->RecordCount();
	 
	    if($isrs>0){
		?>
	    <form action="<?=MYSURL?>include/plugins/ajax/ajax_respose_files/stockupdateaddtocart.php" enctype="multipart/form-data" method="post" id="frmaddtocart" name="frmaddtocart"> 
	   <table width="100%" class="table table-sm  bg-white table-bordered table-hover">
	        <thead>
	            <tr> 
	                <th width="10%">EAN</th>
                    <th width="30%">Description</th>
                    <th width="10%">Pattern</th> 
                    <th width="10%">Size</th> 
                    <th width="10%">Brand</th>  
                    <th width="5%">Width</th>  
                    <th width="10%">Aspect Ratio</th>  
                    <th width="5%">Rim</th>  
	                <th width="5%">Price</th>  
	                <th width="5%">Quantity</th> 
	            </tr>
	        </thead>                         
	        <tbody>
	            <? while (!$rs->EOF){ ?>
	            <tr> 
	                  <td><?php echo stripslashes($rs->fields["ean"]);?></td>
	                  <td><?php echo stripslashes($rs->fields["description"]);?></td>
	                  <td><?php echo stripslashes($rs->fields["pattern"]);?></td>
	                  <td><?php echo stripslashes($rs->fields["size"]);?></td>
	                  <td><?php echo stripslashes($rs->fields["brand"]);?></td>  
	                  <td><?php echo stripslashes($rs->fields["width"]);?></td>
	                  <td><?php echo stripslashes($rs->fields["aspect_ratio"]);?></td>
	                  <td><?php echo stripslashes($rs->fields["rim"]);?></td>
	                 
	                <td>
	                	 <input type="number" min="0" step="0.01"  value="0" name="purchase_price_<?=$rs->fields["id"]?>" class="form-control text-center form-control-sm"  id="purchase_price_<?=$rs->fields["id"]?>">
	                </td> 
	           	  
	                <td>
	               <input type="number" class="form-control text-center form-control-sm" min="0" value="0" name="qty_<?=$rs->fields["id"]?>" id="qty_<?=$rs->fields["id"]?>">  
	                    <input type="hidden"  value="<?=$rs->fields["id"]?>" name="product_id[]" id="product_id_<?=$rs->fields["id"]?>">   
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
						   $("#psize").val("");	 	 
						   $("#psize").focus();
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

		$size 			= sanitize(trim($_POST["psize"])); 
		$and 	  = "";
		if($size != ""){
			$and .= " AND (upper(a.description)  like upper('%".$size."%'))";
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
	 
	    if($isrs>0){
		?>
	    <form action="<?=MYSURL?>include/plugins/ajax/ajax_respose_files/stockupdateaddtocart.php" enctype="multipart/form-data" method="post" id="frmaddtocart" name="frmaddtocart"> 
	   <table width="100%" class="table table-sm  bg-white table-bordered table-hover">
	        <thead>
	            <tr> 
					<th width="90%">Discription</th>   
					<th width="5%">Price</th> 
					<th width="5%">Quantity</th> 
	            </tr>
	        </thead>                         
	        <tbody>
	            <? while (!$rs->EOF){ ?>
	            <tr> 
	                <td><?=$rs->fields["description"]?></td> 
	                <td> <input type="number" class="form-control text-center form-control-sm" min="0" step="0.01"  value="0" name="purchase_price_<?=$rs->fields["id"]?>" id="purchase_price_<?=$rs->fields["id"]?>"> 
	                    <input type="hidden"  value="<?=$rs->fields["id"]?>" name="part_id[]" id="id<?=$rs->fields["id"]?>">  
	                </td>
	                <td> <input type="number" class="form-control text-center form-control-sm" min="0" value="0" name="qty_<?=$rs->fields["id"]?>" id="qty_<?=$rs->fields["id"]?>"> </td>  
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
						   $("#psize").val("");	 	 
						   $("#psize").focus();
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