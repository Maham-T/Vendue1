<?php
include('root.php');
include($root.'config/conn.php');
// if product is requested to add in cart...  

if(isset($_POST["addtocart"])){ 
	$product_id = $_POST["product_id"]; 
	$supplierid = $_POST["supplierid"]; 	
	$acc_id		= $_POST["acc_id"]; 
	for($i = 0; $i < count($product_id); $i++){

		 $productid = $product_id[$i];
		 $qty 		= $_POST["qty_".$productid];	
		 $offer_id 	= $_POST["offer_id_".$productid];	
		 $price 	= $_POST["tnt_price_".$productid];	
	 
		if($qty > 0 && $productid != ""){
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
						   p.purchase_price,
						   p.tnt_price,
						   p.retail_price,
						   p.local_stk,
						   p.total_stk,
						   p.F,
						   p.W,
						   p.DB,
						   p.CI
					  FROM ".$tblprefix."product p, ".$tblprefix."brands b 
					 WHERE p.brand_id = b.id 
					   AND p.id = '".$productid."'"; 
			$rs = $db->Execute($sql);
			$isrs = $rs->RecordCount();	
			if($isrs>0){				 

				$_SESSION['cart']["prod"][$productid]['product_id']			=	$rs->fields['product_id'];
				$_SESSION['cart']["prod"][$productid]['offer_id']			=	$offer_id;
				$_SESSION['cart']["prod"][$productid]['description']		=	$rs->fields['description']; 
				$_SESSION['cart']["prod"][$productid]['purchase_price']		=	$rs->fields['purchase_price']; 
				$_SESSION['cart']["prod"][$productid]['tnt_price']			=	$price; 
				$_SESSION['cart']["prod"][$productid]['local_stk']			=	$rs->fields['local_stk']; 
				$_SESSION['cart']["prod"][$productid]['qty']				=	$qty; 							
			}
		}elseif($qty == 0){
			unset($_SESSION['cart']["prod"][$productid]); 
		}			
	}  


	for($j = 0; $j < count($acc_id); $j++){

		 $accid 	= $acc_id[$j];
		 $qty 		= $_POST["qty_".$accid];	 
		 $price 	= $_POST["price_".$accid];	
	 
		if($qty > 0 && $accid != ""){
			$sql = "SELECT a.id as acc_id,
					   a.company_id,
					   a.description,
					   a.purchase_price,
					   a.unit_price_box,
					   a.stock_val 
				  FROM ".$tblprefix."accessories a where 1=1
				    AND a.id = '".$accid."'";  
			$rs = $db->Execute($sql);
			$isrs = $rs->RecordCount();	
			if($isrs>0){				 

				$_SESSION['cart']["acc"][$accid]['acc_id']				=	$rs->fields['acc_id']; 
				$_SESSION['cart']["acc"][$accid]['description']			=	$rs->fields['description']; 
				$_SESSION['cart']["acc"][$accid]['purchase_price']		=	$rs->fields['purchase_price']; 
				$_SESSION['cart']["acc"][$accid]['price']				=	$price;  
				$_SESSION['cart']["acc"][$accid]['qty']					=	$qty; 							
			}
		}elseif($qty == 0){
			unset($_SESSION['acccart']["acc"][$accid]); 
		}			
	}   
} 
 
$total_items = count($_SESSION['cart']);
if($total_items>0)
{						
?> 
<div class="row mt-2">
	<div class="col-md-12">
		 <h5 class="text-dark">
            	Cart Items 
         </h5>
	</div>
</div>
<form action="<?=MYSURL?>new-purchase" enctype="multipart/form-data" method="post">

<? if(count($_SESSION['cart']["prod"]) > 0){  ?>
<table id="SpecialOffers" class="table table-sm table-hover table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr> 
            <th width="46%">Discription</th>
            <th width="3%" class="text-center">F</th>
            <th width="3%" class="text-center">W</th>
            <th width="3%" class="text-center">Db</th>
            <th width="3%" class="text-center">CI</th>
            <? if($supplierid == 1) { ?> 
            <th width="8%" class="text-right">In Stock</th> 
        	<? } ?> 
            <th width="10%" class="text-right">Price</th>
            <th width="8%">Quantity</th>  
        </tr>
    </thead>                         
    <tbody>
    	<?
		$_SESSION['gtotal_val'] = "";
		foreach($_SESSION['cart']["prod"] as $key => $value)
		{ 
			$productid			=	$_SESSION['cart']["prod"][$key]['product_id'];
			$qty				=	$_SESSION['cart']["prod"][$key]['qty'];
			$tnt_price  		=	$_SESSION['cart']["prod"][$key]['tnt_price'];

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
					  FROM ".$tblprefix."product p, ".$tblprefix."brands b 
					 WHERE p.brand_id = b.id 
					   AND p.id = '".$productid."'";
			$rs = $db->Execute($sql); 
			
			if($_SESSION['VAT'] == 1){
				$tnt_price = $tnt_price + $tnt_price * 0.2;	
				$retail_price = $rs->fields["retail_price"] + $rs->fields["retail_price"] * 0.2;	
			}else{
				$tnt_price = $tnt_price;	
				$retail_price = $rs->fields["retail_price"];
			}
			
			$in_stk = $rs->fields["local_stk"] + $rs->fields["total_stk"];
			if($in_stk > 50){
				$in_stk = 50;
			}
			
			$gtotal = $tnt_price  * $qty;
			$_SESSION['gtotal_val'] = $_SESSION['gtotal_val'] + $gtotal ;
			
			$totalQty += $qty;
			$totalTNTPrice += $tnt_price;
			
		?>                            
        <tr> 
            <td><?=$rs->fields["description"]?></td> 
            <td class="text-center"><?=$rs->fields["W"]?></td> 
            <td class="text-center"><?=$rs->fields["F"]?></td> 
            <td class="text-center"><?=$rs->fields["DB"]?></td> 
            <td class="text-center"><?=$rs->fields["CI"]?></td> 
            <? if($supplierid == 1) { ?> 
            <td class="text-right"><?=$in_stk?></td>
       		<? } ?>
            <td class="text-right">&pound;<?=amount_format($tnt_price)?></td> 
             
           
            <td class="text-center">
            	 <input type="hidden"  value="<?=$rs->fields["product_id"]?>" name="product_id[]" id="id<?=$rs->fields["product_id"]?>">
                <input type="hidden"  value="<?=$rs->fields["tnt_price"]?>" name="tnt_price_<?=$rs->fields["product_id"]?>" id="tnt_price<?=$rs->fields["product_id"]?>">
                <input type="number" class="form-control text-center form-control-sm" readonly min="0" max="<?=$rs->fields["local_stk"]?>" value="<?=$qty?>" name="qty_<?=$rs->fields["product_id"]?>" id="qty<?=$rs->fields["product_id"]?>">                                
            </td>
        </tr>
        <? 							 
		}  
		?> 
		<tr>
			<td class="text-center"><strong>Totals</strong></td>  
			<td <? if($supplierid == 1) { ?>  colspan="5" <? }else{ ?> colspan="4" <? } ?>>&nbsp;</td> 
			<td class="text-right"><strong>&pound;<?=amount_format($totalTNTPrice)?></strong></td>
        	<td class="text-center"><strong><?=$totalQty?></strong></td>
        </tr> 
    </tbody>
</table> 
<? } ?>

<? if(count($_SESSION['cart']["acc"]) > 0){  ?>
<table id="SpecialOffers" class="table table-sm table-hover table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr> 
            <th width="46%">Discription</th> 
          	<th width="8%">Quantity</th>  
            <th width="10%" class="text-right">Price</th>
          
        </tr>
    </thead>                         
    <tbody>
    	<? 

		foreach($_SESSION['cart']["acc"] as $key1 => $value1)
		{ 
			$acc_id				=	$_SESSION['cart']["acc"][$key1]['acc_id'];
			$accqty				=	$_SESSION['cart']["acc"][$key1]['qty'];
			$description  		=	$_SESSION['cart']["acc"][$key1]['description'];
			$price  			=	$_SESSION['cart']["acc"][$key1]['price']; 
		 
			
			$gtotal = $price  * $accqty;  
			$totalaccQty += $accqty;
			$totalprice += $price;
			
		?>                            
        <tr> 
            <td><?=$description?></td> 
            <td class="text-right"><?=$accqty?></td>  
            <td class="text-right">&pound;<?=amount_format($price)?></td>   
        </tr>
        <? 							 
		}  
		?> 
		<tr>
			<td class="text-center"><strong>Total</strong></td>   
			<td class="text-right"><strong><?=$totalaccQty?></strong></td>
			<td class="text-right"><strong>&pound;<?=amount_format($totalprice)?></strong></td>
        	
        </tr> 
    </tbody>
</table> 
<? } ?>
<div class="row mt-2">
	<div class="col-md-12">
		<div class="float-right">
			 <a  href="<?=MYSURL?>new-purchase" class="btn btn-default btn-flat btn-sm"><i class="fa fa-window-close"></i> Cancel</a> 
			<button type="submit"  name="AddOrUpdate" id="AddOrUpdate" class="btn btn-success btn-flat btn-sm">
				<i class="fa fa-check"></i>  Process Order 
			</button> 
			<input type="hidden" name="supplier_id" id="supplier_id" value="<?=$supplierid?>">
		</div> 
	</div>
</div>
</form>
<?
}
else
{
    if($_SESSION['type'] == 'product_qty_no_available'){
?>
    <div class="col-md-12 ">
    <div class="padding10px " style="background-color:#dff0d8; margin-top:20px;">
    <? echo getmsg($tblprefix, $_SESSION['type']);?> 
    </div>
    </div>
<? 
    $_SESSION['type'] = "";
    }else{ 
	?>
    	<div class="padding10px " style="background-color:#dff0d8; margin-top:20px;">
        	<? echo getmsg($tblprefix,"emptycart");?> 
        </div>
		 
	<?
    }
}


?>