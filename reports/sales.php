<?php 
    require_once('root.php'); 
	require_once($root.'config/conn.php'); 
	//require_once($root."base/login_checker.php"); 
	
	if(isset($_POST['search']))
	{
  		$and		=	'';
		if($_POST['cust_id'] != ""){
			$and .= " AND o.cust_id = '".$_POST['cust_id']."'";
			$ccand .= " AND o.cust_id = '".$_POST['cust_id']."'";
		}
		if($_POST['domain_id'] != ""){
			$and .= " AND o.domain_id = '".$_POST['domain_id']."'";
			$ccand .= " AND o.domain_id = '".$_POST['domain_id']."'";
		}
 		if($_POST['search_field'] != "ALL" && $_POST['search_field'] != ""){
			$and .= " AND o.status_id = '".$_POST['search_field']."'";
		}else{
			$and .= " AND o.status_id in (1,2,3,4)";
		}
		if($_POST['order_mode'] == "TNT"){
			$and .= " AND o.user_id <> '0'";
		}elseif($_POST['order_mode'] == "Customer"){
			$and .= " AND o.user_id = '0'";
		}
		if($_POST['date_from'] != "" && $_POST['date_to'] != ""){
			$and .= " AND DATE_FORMAT(o.datetime, '%Y-%m-%d') BETWEEN '".$_POST['date_from']."' AND '".$_POST['date_to']."'";
			$ccand .= " AND DATE_FORMAT(o.datetime, '%Y-%m-%d') BETWEEN '".$_POST['date_from']."' AND '".$_POST['date_to']."'";
		}	
	}
	
	$sql = "SELECT  o.id,
					o.order_no,
					o.cust_id,
					o.reference,
					o.status_id,
					s.status,
					o.datetime,
					o.remarks,
					o.VAT,
					o.user_id,
					COUNT(i.order_id) NO_OF_ITEMS,
					SUM(i.quantity) ITEM_QTY,
					round(SUM(i.tnt_price * i.quantity),2) ITEM_PRICE,
					'OR' rtype
				FROM
					".$tblprefix."orders o,
					".$tblprefix."order_status s,
					".$tblprefix."order_items i
				WHERE
					o.id = i.order_id and o.status_id = s.id $and  
				GROUP BY o.id , o.order_no , o.cust_id , o.reference , o.status , o.datetime , o.remarks , o.VAT , o.user_id "; 
	 
	$rs=$db->Execute($sql) or die($db->errorMsg());
	$isrs=$rs->RecordCount();


	$sqlcn = "SELECT    o.id,
						o.order_no,
						o.cust_id,
						'' reference,
						'CREDIT NOTE' 	status ,
						o.datetime,
						o.remarks,
						'' VAT,
						'' user_id,
						COUNT(i.order_id) NO_OF_ITEMS,
						SUM(i.quantity) ITEM_QTY,
						round(SUM(i.tnt_price * i.quantity),2) ITEM_PRICE,
						'CN' rtype
					FROM
						tnt_credit_note o,
						tnt_credit_note_items i
					WHERE
						o.id = i.cn_id    AND o.status = 'COMPLETED'
							$ccand 
					GROUP BY o.id , o.order_no , o.cust_id ,  o.status , o.datetime , o.remarks   ";  
	$rscn	=	$db->Execute($sqlcn) or die($db->errorMsg());
	$isrscn	=	$rscn->RecordCount();
	
	 
 if($_POST['format'] == 'xls'){
	$vExcelFileName=$date."export". ".xls";
	header("Content-type: application/x-ms-download"); 
	header("Content-Disposition: attachment; filename=$vExcelFileName");
	header('Cache-Control: public');	
	}
	
	if($_POST['format'] == 'doc'){
	$vExcelFileName=$date."export". ".doc";
	header("Content-type: application/x-ms-download"); 
	header("Content-Disposition: attachment; filename=$vExcelFileName");
	header('Cache-Control: public');	
	}


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sales Report</title>
<link href="../css/bootstrap.css" rel="stylesheet">
<link href="../css/style.css" rel="stylesheet">
<style>
	table{
		border-collapse:collapse;	
	}
	table tr td{
		font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size:11px;
		color:#000;
		padding:2px;
	}
	.subheading{ font-weight:bold;}
	h1{
		font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size:18px;
		color:#000;
		margin:0 0 5px 0;
		padding:0;
	}
	h2{
		font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size:14px;
		color:#000;
		margin:0 0 5px 0;
		padding:0;
	}
	h3{
		font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size:12px;
		color:#000;
		margin:0 0 5px 0;
		padding:0;
	}
</style>
</head>

<body>
	<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
    <tr>
    	<td>&nbsp;</td>
    </tr>
    <tr>
    	<td align="center">
        	<h1>Top Notch Tyres Wholesale</h1>
			<h2>Account Statement</h2>
            <? if($_POST['cust_id'] != "") { ?>
            <h3><?=getName($tblprefix,"customer","name","id",$_POST['cust_id'])?></h3> 
            <? } ?>
            <? if($_POST['search_field'] != "" && $_POST['search_field'] != "ALL") { ?>
            <h3>
            	Order Status: <?=getName($tblprefix,"order_status","status","id",$_POST['search_field'])?>           	
            </h3>
            <? } ?> 
        </td>
    </tr>
    <?
    if($_POST['date_from'] != "" && $_POST['date_to'] != ""){
	?>
    <tr>
    	<td align="center"><strong>Date From: <?=dateformat($_POST['date_from'])?> to <?=dateformat($_POST['date_to'])?></strong></td>
    </tr>
    <? } ?>
    <tr>
    	<td>&nbsp;</td>
    </tr>
	<tr>
    	<td><strong>Orders</strong></td>
    </tr>	
    <tr>
		<td>
        	<table  class="table table-striped table-bordered table-hover table-condensed" id="table">
              <thead>
                 <tr class="info">
                    <th class="text-center">#</th>
                    <th>Order No</th>
                    <th>Customer Name</th>
                    <th>Reference</th> 
                    <th>Status</th>  
                    <th>Datetime</th>
                    <th>Remarks</th>    
                    <th>Order Mode</th> 
                    <th class="text-center">Items</th> 
                    <th class="text-center">Items Qty</th> 
                    <th class="text-center">Amount</th>
                    <th class="text-center">VAT</th> 
                    <th class="text-center">Total</th>  
                </tr>
              </thead>
              <tbody>
                <?php
                $flg= true;
                $sn = 1;
				$statusCount = array();
                if($isrs > 0){
                while(!$rs->EOF){
                ?>		<!---------------COLOR LOOP STARTS------------>
                <?php
                    if($flg==true){
                        $class = 'class="warning"';
                        $flg=false;	
                    }else{
                        $class = 'class="active"';
                        $flg=true;			
                    }	
					$VAT 		= amount_format($rs->fields["ITEM_PRICE"] * 0.2);	
					$VATtotal   = $rs->fields["ITEM_PRICE"] + $VAT; 
					 
					if($rs->fields["rtype"] == 'CN'){
						$totalItems -= $rs->fields["NO_OF_ITEMS"];
						$totalQty -= $rs->fields["ITEM_QTY"];
						$total -= $rs->fields["ITEM_PRICE"];
						$VATgtotal -= $VAT;
						$VGtotal -= $VATtotal;
						$class = 'class="danger"';
						
						/*$statusCount[$rs->fields["status"]]["status"] = "CREDIT-NOTE";	
						$statusCount[$rs->fields["status"]]["count"] += 1;	
						$statusCount[$rs->fields["status"]]["NO_OF_ITEMS"] += $rs->fields["NO_OF_ITEMS"];	
						$statusCount[$rs->fields["status"]]["ITEM_QTY"] += $rs->fields["ITEM_QTY"];	
						$statusCount[$rs->fields["status"]]["ITEM_PRICE"] += $rs->fields["ITEM_PRICE"];	
						$statusCount[$rs->fields["status"]]["VAT"] += $VAT;
						$statusCount[$rs->fields["status"]]["VATtotal"] += $VATtotal;*/
						
					}else{
						$totalItems += $rs->fields["NO_OF_ITEMS"];
						$totalQty += $rs->fields["ITEM_QTY"];
						$total += $rs->fields["ITEM_PRICE"];
						$VATgtotal += $VAT;
						$VGtotal += $VATtotal; 
						
					}
					//if($rs->fields["status_id"] != 1 && $rs->fields["status_id"] != 2 ){
						$statusCount[$rs->fields["status"]]["status"] = $rs->fields["status"];	
						$statusCount[$rs->fields["status"]]["count"] += 1;	
						$statusCount[$rs->fields["status"]]["NO_OF_ITEMS"] += $rs->fields["NO_OF_ITEMS"];	
						$statusCount[$rs->fields["status"]]["ITEM_QTY"] += $rs->fields["ITEM_QTY"];	
						$statusCount[$rs->fields["status"]]["ITEM_PRICE"] += $rs->fields["ITEM_PRICE"];	
						$statusCount[$rs->fields["status"]]["VAT"] += $VAT;
						$statusCount[$rs->fields["status"]]["VATtotal"] += $VATtotal;
					//}
					
                ?>
                    <tr <?=$class?>>
                        <td align="center"><?=$sn++;?></td>
                        <td><?php echo stripslashes($rs->fields["order_no"]);?></td>  
                        <td><?php echo getName($tblprefix,"customer","name","id",stripslashes($rs->fields["cust_id"]));?></td>  
                        <td><?php echo stripslashes($rs->fields["reference"]);?></td> 
                        <td><?php echo stripslashes($rs->fields["status"]);?></td>  
                        <td><?php echo datetimeformat($rs->fields["datetime"]);?></td>  
                        <td><?php echo stripslashes($rs->fields["remarks"]);?></td> 
                        <td><?php 
							if($rs->fields["user_id"] != 0){
								echo "TNT";	
							}else{
								echo "Customer";	
							}
						?></td>   
                        <td class="text-center"><?php echo stripslashes($rs->fields["NO_OF_ITEMS"]);?></td> 
                        <td class="text-center"><?php echo stripslashes($rs->fields["ITEM_QTY"]);?></td> 
                        <td class="text-right"><?php echo amount_format($rs->fields["ITEM_PRICE"]);?></td>  
                        <td class="text-right"><?php echo amount_format($VAT);?></td> 
                        <td class="text-right"><?php echo amount_format($VATtotal);?></td> 
                         
                    </tr>
                <?php 
				
                $rs->MoveNext();
                }
				?>
				<tr class="success">
                    <td colspan="8" class="text-right"><strong>Total</strong></td>
                    <td class="text-center"><strong><?php echo stripslashes($totalItems);?></strong></td> 
                    <td class="text-center"><strong><?php echo stripslashes($totalQty);?></strong></td> 
                    <td class="text-right"><strong><?php echo amount_format($total);?></strong></td> 
                    <td class="text-right"><strong><?php echo amount_format($VATgtotal);?></strong></td> 
                    <td class="text-right"><strong><?php echo amount_format($VGtotal);?></strong></td> 
                </tr>
				<?
                } 
                ?>
              </tbody>
            </table>
            
            
        </td>
	</tr>
		<? if($isrscn > 0){ ?>
	<tr>
    	<td><strong>Credit Note</strong></td>
    </tr>	
    <tr>
		<td>
        	<table  class="table table-striped table-bordered table-hover table-condensed" id="table">
              <thead>
                 <tr class="info">
                    <th class="text-center">#</th>
                    <th>Order No</th>
                    <th>Customer Name</th>
                    <th>Reference</th> 
                    <th>Status</th>  
                    <th>Datetime</th>
                    <th>Remarks</th>    
                    <th>Order Mode</th> 
                    <th class="text-center">Items</th> 
                    <th class="text-center">Items Qty</th> 
                    <th class="text-center">Amount</th>
                    <th class="text-center">VAT</th> 
                    <th class="text-center">Total</th>  
                </tr>
              </thead>
              <tbody>
                <?php
                $flg= true;
                $sn = 1;
				//$statusCount = array();
                
                while(!$rscn->EOF){
                ?>		<!---------------COLOR LOOP STARTS------------>
                <?php
                    if($flg==true){
                        $class = 'class="warning"';
                        $flg=false;	
                    }else{
                        $class = 'class="active"';
                        $flg=true;			
                    }	
					$VAT 		= $rscn->fields["ITEM_PRICE"] * 0.2;	
					$VATtotal   = $rscn->fields["ITEM_PRICE"] + $VAT; 
					 
					$totalItemscn 	+= $rscn->fields["NO_OF_ITEMS"];
					$totalQtycn 	+= $rscn->fields["ITEM_QTY"];
					$totalcn 		+= $rscn->fields["ITEM_PRICE"];
					$VATgtotalcn 	+= $VAT;
					$VGtotalcn 		+= $VATtotal; 
					
					
						$statusCount[$rscn->fields["status"]]["status"] = $rscn->fields["status"];	
						$statusCount[$rscn->fields["status"]]["count"] += 1;	
						$statusCount[$rscn->fields["status"]]["NO_OF_ITEMS"] += $rscn->fields["NO_OF_ITEMS"];	
						$statusCount[$rscn->fields["status"]]["ITEM_QTY"] += $rscn->fields["ITEM_QTY"];	
						$statusCount[$rscn->fields["status"]]["ITEM_PRICE"] += $rscn->fields["ITEM_PRICE"];	
						$statusCount[$rscn->fields["status"]]["VAT"] += $VAT;
						$statusCount[$rscn->fields["status"]]["VATtotal"] += $VATtotal;
				 
					
                ?>
                    <tr <?=$class?>>
                        <td align="center"><?=$sn++;?></td>
                        <td><?php echo stripslashes($rscn->fields["order_no"]);?></td>  
                        <td><?php echo getName($tblprefix,"customer","name","id",stripslashes($rscn->fields["cust_id"]));?></td>  
                        <td><?php echo stripslashes($rscn->fields["reference"]);?></td> 
                        <td><?php echo stripslashes($rscn->fields["status"]);?></td>  
                        <td><?php echo datetimeformat($rscn->fields["datetime"]);?></td>  
                        <td><?php echo stripslashes($rscn->fields["remarks"]);?></td> 
                        <td><?php 
							if($rscn->fields["user_id"] != 0){
								echo "TNT";	
							}else{
								echo "Customer";	
							}
						?></td>   
                        <td class="text-center"><?php echo stripslashes($rscn->fields["NO_OF_ITEMS"]);?></td> 
                        <td class="text-center"><?php echo stripslashes($rscn->fields["ITEM_QTY"]);?></td> 
                        <td class="text-right"><?php echo amount_format($rscn->fields["ITEM_PRICE"]);?></td>  
                        <td class="text-right"><?php echo amount_format($VAT);?></td> 
                        <td class="text-right"><?php echo amount_format($VATtotal);?></td> 
                         
                    </tr>
                <?php 
				
                $rscn->MoveNext();
                }
				?>
				<tr class="success">
                    <td colspan="8" class="text-right"><strong>Total</strong></td>
                    <td class="text-center"><strong><?php echo stripslashes($totalItemscn);?></strong></td> 
                    <td class="text-center"><strong><?php echo stripslashes($totalQtycn);?></strong></td> 
                    <td class="text-right"><strong><?php echo amount_format($totalcn);?></strong></td> 
                    <td class="text-right"><strong><?php echo amount_format($VATgtotalcn);?></strong></td> 
                    <td class="text-right"><strong><?php echo amount_format($VGtotalcn);?></strong></td> 
                </tr>
				
              </tbody>
            </table>
			<?
                } 
                ?>
        </td>
	</tr>	
    <?  
	$arrCount = count($statusCount);
	if($arrCount > 0){  ?>
    <tr>
    	<td>
        	<h2>Orders Summery</h2><br> 
            
            <table  class="table table-striped table-bordered table-hover table-condensed" id="table" style="font-weight:bold">
              <tbody>
                <tr style="text-transform:uppercase">
                  <th scope="col"  width="40%">&nbsp;</th>
                  <th scope="col" class="text-center" width="10%">No of Orders</th>
                  <th scope="col" class="text-center" width="10%">No of Items</th>
                  <th scope="col" class="text-center" width="10%">Total Quantity</th>
                  <th scope="col" class="text-center" width="10%">Price</th>
                  <th scope="col" class="text-center" width="10%">VAT</th>
                  <th scope="col" class="text-center" width="10%">Total</th>
                </tr>
                <? 
				$amountDuePrice = 0;
				$amountDueVAT = 0;
				$amountDueTotal = 0; 
				foreach($statusCount as $value) { 
					$ordstatus = $value["status"];
					 
					if($ordstatus == "CREDIT NOTE"){
						$amountDuePrice = $amountDuePrice - $value["ITEM_PRICE"]; 
						$amountDueVAT 	= $amountDueVAT - $value["VAT"]; 
						$amountDueTotal = $amountDueTotal - $value["VATtotal"]; 
					}elseif($value["status"] != "CANCELLED"){						
						$amountDuePrice = $amountDuePrice + $value["ITEM_PRICE"]; 
						$amountDueVAT 	= $amountDueVAT + $value["VAT"]; 
						$amountDueTotal = $amountDueTotal + $value["VATtotal"]; 					 
					}
				?>
                <tr>
                  <td><?=$ordstatus?></td>
                  <td class="text-center"><?=$value["count"]?></td>
                  <td class="text-center"><?=$value["NO_OF_ITEMS"]?></td>
                  <td class="text-center"><?=$value["ITEM_QTY"]?></td>
                  <td class="text-right"><?=amount_format($value["ITEM_PRICE"])?></td>
                  <td class="text-right"><?=amount_format($value["VAT"])?></td>
                  <td class="text-right"><?=amount_format($value["VATtotal"])?></td>
                </tr>
                <? } ?>
				 <tr style="font-weight: bold" class="success">
                  <td colspan="4" class="text-center">AMOUNT DUE</td> 
                  <td class="text-right"><?=amount_format($amountDuePrice)?></td>
                  <td class="text-right"><?=amount_format($amountDueVAT)?></td>
                  <td class="text-right"><?=amount_format($amountDueTotal)?></td>
                </tr>
              </tbody>
            </table>   
        </td>
    </tr>  
    <?  } ?>    
</table>
</body>
</html>
 

