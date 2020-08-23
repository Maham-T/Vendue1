<?php
include('root.php');
include($root.'config/conn.php');
// if product is requested to add in cart...  

if(isset($_POST["addtocart"])){ 

	$product_id = $_POST["product_id"]; 
	$supplierid = $_POST["supplierid"]; 	
	$part_id	= $_POST["part_id"];  
	$product_id = $_POST["product_id"];   

	for($i = 0; $i < count($product_id); $i++){
		 $productid = $product_id[$i];
		 $qty 		= $_POST["qty_".$productid];	 	
		 $price 	= $_POST["purchase_price_".$productid];	

		 if($qty > 0 && $productid != ""){
		 	$_SESSION['cart']["product"]['product_id'][]		=	$productid; 
		 	$_SESSION['cart']["product"][$productid]['qty']		=	$qty; 	
		 	$_SESSION['cart']["product"][$productid]['price']	=	$price; 	
	 	}elseif($qty == 0){
			unset($_SESSION['cart']["product"][$productid]); 
		} 		
	}  


	for($j = 0; $j < count($part_id); $j++){

		 $partid 	= $part_id[$j];
		 $qty 		= $_POST["qty_".$partid];	 	
		 $price 	= $_POST["purchase_price_".$partid];	

		 if($qty > 0 && $partid != ""){
		 	$_SESSION['cart']["part"]['part_id'][]		=	$partid; 
		 	$_SESSION['cart']["part"][$partid]['qty']	=	$qty; 	
		 	$_SESSION['cart']["part"][$partid]['price']	=	$price; 	
	 	}elseif($qty == 0){
			unset($_SESSION['cart']["part"][$partid]);  
		} 		
	} 
	   
} 



$product_ids = 0;	
if(count($_SESSION['cart']["product"]["product_id"]) > 0){
	$product_ids = implode(",",$_SESSION['cart']["product"]["product_id"]);	
}

$and = " AND p.id in (".$product_ids.")";
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
$rs = $db->Execute($sql) or die($db->errorMSg());
$isrs = $rs->RecordCount();  

$part_ids = 0;	
if(count($_SESSION['cart']["part"]["part_id"]) > 0){
	$part_ids = implode(",",$_SESSION['cart']["part"]["part_id"]);	
}

$andprt = " AND a.id in (".$part_ids.")";
$sqlprt = "SELECT  a.id,
					a.company_id,
					a.branch_id,
					a.description, 
					a.in_stock, 
					a.status
				FROM
					".$tblprefix."parts a
 WHERE  a.company_id = ".$db->qStr($_SESSION["company_id"])." 
 		and a.branch_id= ".$db->qStr($_SESSION["branch_id"]).$andprt; 
$rsprt = $db->Execute($sqlprt) or die($db->errorMSg());
$isrsprt = $rsprt->RecordCount();


?> 
<div class=" bg-white p-3">
<div class="row mt-2">
	<div class="col-md-12">
		 <h5 class="text-dark">
            	Cart Items 
         </h5>
	</div>
</div>
<form action="<?=MYSURL?>stock-update" enctype="multipart/form-data" method="post">



	<table class="table table-striped table-sm table-bordered table-hover table-checkable order-column" id="sample_1">
				<? if($isrs > 0){  ?> 	
				<thead>
					
                <tr class="info"> 
                    <th class="text-center" width="4%">#</th>
                    <th width="10%">EAN</th>
                    <th width="28%">Description</th>
                    <th width="10%">Pattern</th> 
                    <th width="10%">Size</th> 
                    <th width="10%">Brand</th>  
                    <th width="5%">Width</th>  
                    <th width="10%">Aspect Ratio</th>  
                    <th width="5%">Rim</th> 
                    <th width="10%" class="text-right">Price</th>
            		<th width="8%">Quantity</th>   
                </tr>
              </thead>
              <tbody>
                <?php 
            $sn = 1; 
            while(!$rs->EOF){

            	$qty 	= $_SESSION['cart']["product"][$rs->fields["id"]]['qty'];
            	$price 	= $_SESSION['cart']["product"][$rs->fields["id"]]['price'];

            ?>    <!---------------COLOR LOOP STARTS------------> 
            <tr> 
                  <td align="center"><?=$sn++?></td>
                  <td><?php echo stripslashes($rs->fields["ean"]);?></td>
                  <td><?php echo stripslashes($rs->fields["description"]);?></td>
                  <td><?php echo stripslashes($rs->fields["pattern"]);?></td>
                  <td><?php echo stripslashes($rs->fields["size"]);?></td>
                  <td><?php echo stripslashes($rs->fields["brand"]);?></td>  
                  <td><?php echo stripslashes($rs->fields["width"]);?></td>
                  <td><?php echo stripslashes($rs->fields["aspect_ratio"]);?></td>
                  <td><?php echo stripslashes($rs->fields["rim"]);?></td> 
                  <td class="text-right"><?=amount_format($price)?></td> 
                  <td class="text-right"><?php echo stripslashes($qty);?></td>

              </tr>
            <?php
            $rs->MoveNext();
            }
        	}        
            ?>

            <? if($isrsprt > 0){ ?>
            	<tr class="text-bold">
            		 <td class="text-center" width="4%">#</td>
            		 <td colspan="8">Description</td>
            		 <td class="text-right">Price</td>
            		 <td class="text-right">Quantity</td> 
            	</tr>

            <?	$snprt = 1; 
            while(!$rsprt->EOF){

            	$qty 	= $_SESSION['cart']["part"][$rsprt->fields["id"]]['qty'];
            	$price 	= $_SESSION['cart']["part"][$rsprt->fields["id"]]['price'];

            ?>    <!---------------COLOR LOOP STARTS------------> 
            <tr> 
                  <td align="center"><?=$snprt++?></td> 
                  <td colspan="8"><?php echo stripslashes($rsprt->fields["description"]);?></td> 
                  <td class="text-right"><?=amount_format($price)?></td> 
                  <td class="text-right"><?php echo stripslashes($qty);?></td>

              </tr>
            <?php
            $rsprt->MoveNext();
            }
        	}  
            ?>
              </tbody>
			</table> 
 
 
 <? if($isrs > 0 || $isrsprt > 0){  ?> 
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
<? } ?>
</form>
</div>
 
 