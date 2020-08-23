<?php 
	$searchdate = date("Y-m-d");
	include('root.php');
	include($root.'config/conn.php');
	include('../admin_security.php');
	
	if(isset($_POST['search']))
	{
  		$and		=	'';
		if($_POST['driver_id'] != ""){
			$and .= " AND o.driver_id = '".$_POST['driver_id']."'";
			$ccand .= " AND o.driver_id = '".$_POST['driver_id']."'";
		}
		 
		if($_POST['date_from'] != "" && $_POST['date_to'] != ""){
			$and .= " AND DATE_FORMAT(o.collection_date, '%Y-%m-%d') BETWEEN '".$_POST['date_from']."' AND '".$_POST['date_to']."'"; 
		}	
	}
	
	$sql = "SELECT  o.id,
					o.order_no,
					o.cust_id,
					c.cust_no,
					c.name cust_name,
					d.name driver_name, 
					o.datetime, 
					o.delivery_date,
					o.collection_date,
					COUNT(i.order_id) NO_OF_ITEMS,
					SUM(i.quantity) ITEM_QTY,
					round(SUM(i.tnt_price * i.quantity),2) ITEM_PRICE 
				FROM
					".$tblprefix."orders o,
					".$tblprefix."customer c,
					".$tblprefix."order_status s,
					".$tblprefix."order_items i,
					".$tblprefix."drivers d
				WHERE
					o.id = i.order_id and o.status_id = s.id and o.cust_id = c.id and is_collected = 1 and d.id= o.driver_id $and  
				GROUP BY o.id,
					o.order_no,
					o.cust_id,
					c.cust_no,
					c.name,
					d.name, 
					o.datetime, 
					o.delivery_date,
					o.collection_date "; 
	 
	$rs=$db->Execute($sql) or die($db->errorMsg());
	$isrs=$rs->RecordCount();
 
	
	 
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
			<h2>Drivers Collection Statement</h2>
            <? if($_POST['driver_id'] != "") { ?>
            <h3><?=getName($tblprefix,"drivers","name","id",$_POST['driver_id'])?></h3> 
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
		<td>
        	<table  class="table table-striped table-bordered table-hover table-condensed" id="table">
              <thead>
                 <tr class="info">
                    <th class="text-center">#</th>
                    <th>Order No</th>
                    <th>Customer Name</th>
                    <th>Driver</th>  
                    <th class="text-center">Datetime</th>
                    <th class="text-center">Delivery Date</th>    
                    <th class="text-center">Collection Date</th> 
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
					 
				 
						$totalItems += $rs->fields["NO_OF_ITEMS"];
						$totalQty += $rs->fields["ITEM_QTY"];
						$total += $rs->fields["ITEM_PRICE"];
						$VATgtotal += $VAT;
						$VGtotal += $VATtotal; 
						
					 
                ?>
                    <tr <?=$class?>>
                        <td align="center"><?=$sn++;?></td>
                        <td><?php echo stripslashes($rs->fields["order_no"]);?></td>  
                        <td><?php echo stripslashes($rs->fields["cust_no"]);?>-<?php echo stripslashes($rs->fields["cust_name"]);?></td>  
                        <td><?php echo stripslashes($rs->fields["driver_name"]);?></td>  
                        <td class="text-center"><?php echo datetimeformat($rs->fields["datetime"]);?></td>  
                        <td class="text-center"><?php echo dateformat($rs->fields["delivery_date"]);?></td>  
                        <td class="text-center"><?php echo dateformat($rs->fields["collection_date"]);?></td>    
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
                    <td colspan="7" class="text-right"><strong>Total</strong></td>
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
		 
</table>
</body>
</html>
 

