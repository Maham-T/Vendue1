<?php 
	$searchdate = date("Y-m-d");
	include('root.php');
	include($root.'config/conn.php');
	include('../admin_security.php');
	
	if(isset($_POST['search']))
	{
  		$and		=	'';
		if($_POST['cust_id'] != ""){
			$and .= " AND o.cust_id = '".$_POST['cust_id']."'";
		}
 		if($_POST['search_field'] != "ALL" && $_POST['search_field'] != ""){
			$and .= " AND o.status = '".$_POST['search_field']."'";
		}
		if($_POST['order_mode'] == "TNT"){
			$and .= " AND o.user_id <> '0'";
		}elseif($_POST['order_mode'] == "Customer"){
			$and .= " AND o.user_id = '0'";
		}
		if($_POST['date_from'] != "" && $_POST['date_to'] != ""){
			$and .= " AND DATE_FORMAT(o.datetime, '%Y-%m-%d') BETWEEN '".$_POST['date_from']."' AND '".$_POST['date_to']."'";
		}	
	}
	$sql = "
		SELECT 
    o.id,
    o.order_no,
    o.cust_id,
    o.reference,
    o.status,
    o.datetime,
    o.remarks,
    o.VAT,
    COUNT(i.order_id) AS NO_OF_ITEMS,
    SUM(i.quantity) AS ITEM_QTY,
    SUM(i.tnt_price * i.quantity) AS ITEM_PRICE
FROM
    tnt_orders o,
    tnt_order_items i
WHERE
    o.id = i.order_id
       $and
GROUP BY o.id , o.order_no , o.cust_id , o.reference , o.status , o.datetime , o.remarks , o.VAT
ORDER BY o.id DESC 	";
	//$sql="select o.id, o.order_no, o.cust_id, o.reference, o.status, o.datetime, o.remarks, o.VAT, o.user_id, (SELECT count(i.order_id) from ".$tblprefix."order_items i WHERE i.order_id = o.id ) as NO_OF_ITEMS, (SELECT SUM(x.quantity) from ".$tblprefix."order_items x WHERE x.order_id = o.id ) as ITEM_QTY , (SELECT SUM(y.tnt_price * y.quantity) from ".$tblprefix."order_items y WHERE y.order_id = o.id ) as ITEM_PRICE from ".$tblprefix."orders o WHERE 1=1  $and ORDER BY o.id DESC"; 
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
<title>Top Notch Tyres Wholesale - Statement</title>
<link href="../css/bootstrap.css" rel="stylesheet">
<link href="../css/style.css" rel="stylesheet">

<link href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">


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
	h2{
		font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size:16px;
		color:#000;
		margin:0;
		padding:0;
	}
	h3{
		font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size:14px;
		color:#000;
		margin:0;
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
        	<h1>Top Notch Tyres Wholesale - Statement</h1>
            <? if($_POST['cust_id'] != "") { ?>
            <h3><?=getName($tblprefix,"customer","name","id",$_POST['cust_id'])?></h3> 
            <? } ?>
            <? if($_POST['search_field'] != "") { ?>
            <h3><?=$_POST['search_field']?></h3>
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
        	<table id="myTable"  class="table table-striped table-bordered table-hover table-condensed" id="table">
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
					$VAT 		= $rs->fields["ITEM_PRICE"] * 0.2;	
					$VATtotal   = $rs->fields["ITEM_PRICE"] + $VAT; 
					$statusCount[$rs->fields["status"]]["status"] = $rs->fields["status"];	
					$statusCount[$rs->fields["status"]]["count"] += 1;	
					$statusCount[$rs->fields["status"]]["NO_OF_ITEMS"] += $rs->fields["NO_OF_ITEMS"];	
					$statusCount[$rs->fields["status"]]["ITEM_QTY"] += $rs->fields["ITEM_QTY"];	
					$statusCount[$rs->fields["status"]]["ITEM_PRICE"] += $rs->fields["ITEM_PRICE"];	
					$statusCount[$rs->fields["status"]]["VAT"] += $VAT;
					$statusCount[$rs->fields["status"]]["VATtotal"] += $VATtotal;
					
                ?>
                    <tr <?=$class?>>
                        <td align="center"><?=$sn++?></td>
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
				$totalItems += $rs->fields["NO_OF_ITEMS"];
				$totalQty += $rs->fields["ITEM_QTY"];
				$total += $rs->fields["ITEM_PRICE"];
				$VATgtotal += $VAT;
				$VGtotal += $VATtotal;
                $rs->MoveNext();
                }
				?>
				<?php /*?><tr class="success">
                    <td colspan="8" class="text-right"><strong>Total</strong></td>
                    <td class="text-center"><strong><?php echo stripslashes($totalItems);?></strong></td> 
                    <td class="text-center"><strong><?php echo stripslashes($totalQty);?></strong></td> 
                    <td class="text-right"><strong><?php echo amount_format($total);?></strong></td> 
                    <td class="text-right"><strong><?php echo amount_format($VATgtotal);?></strong></td> 
                    <td class="text-right"><strong><?php echo amount_format($VGtotal);?></strong></td> 
                </tr><?php */?>
				<?
                }else{
                ?>
                    <tr class="success">
                        <td colspan="13">No order found!</td>
                    </tr>
                <?php
                }// Reg Companies List 
                ?>
              </tbody>
            </table>
            
            
        </td>
	</tr>
    <? 
	$arrCount = count($statusCount);
	if($arrCount > 0){  ?>
    <tr>
    	<td>
        	<h2>Status wise order summery</h2><br>

            
            <table  class="table table-striped table-bordered table-hover table-condensed" id="table" style="font-weight:bold">
              <tbody>
                <tr style="text-transform:uppercase">
                  <th scope="col"  width="40%">Order Status</th>
                  <th scope="col" class="text-center" width="10%">No of Orders</th>
                  <th scope="col" class="text-center" width="10%">No of Items</th>
                  <th scope="col" class="text-center" width="10%">Total Quantity</th>
                  <th scope="col" class="text-center" width="10%">Price</th>
                  <th scope="col" class="text-center" width="10%">VAT</th>
                  <th scope="col" class="text-center" width="10%">Total</th>
                </tr>
                <? 
				foreach($statusCount as $value) { 
				?>
                <tr>
                  <td><?=$value["status"]?></td>
                  <td class="text-center"><?=$value["count"]?></td>
                  <td class="text-center"><?=$value["NO_OF_ITEMS"]?></td>
                  <td class="text-center"><?=$value["ITEM_QTY"]?></td>
                  <td class="text-right"><?=amount_format($value["ITEM_PRICE"])?></td>
                  <td class="text-right"><?=amount_format($value["VAT"])?></td>
                  <td class="text-right"><?=amount_format($value["VATtotal"])?></td>
                </tr>
                <? } ?>
              </tbody>
            </table>   
        </td>
    </tr>  
    <?  } ?>    
</table>

<script src="../js/jquery-3.3.1.min.js"></script>
<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>


<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script> 
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script> 
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script> 
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

<script>
$(document).ready( function () { 
	$('#myTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>

</body>
</html>
 

