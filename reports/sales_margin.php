<?php 
	$searchdate = date("Y-m-d");
	include('root.php');
	include($root.'config/conn.php');
	include('../admin_security.php');
	
	if(isset($_POST['search']))
	{
  		$and		=	'';
		
		$size = cleanChar(sanitize(trim($_POST["size"])));	
		if($size != ""){
				$and .= " AND (uf_only_digits(s.size)  like '%".$size."%')";
		}
		
		if($_POST['cust_id'] != ""){
			$and .= " AND o.cust_id = '".$_POST['cust_id']."'";
		}
		if($_POST['domain_id'] != ""){
			$and .= " AND o.domain_id = '".$_POST['domain_id']."'";
		}
 		if($_POST['search_field'] != "ALL" && $_POST['search_field'] != ""){
			$and .= " AND o.status_id = '".$_POST['search_field']."'";
		}else{
            $and .= " AND o.status_id <> 5 ";
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
	
	$sql="SELECT o.order_no,c.name, p.description,s.size,i.purchase_price,i.tnt_price,i.quantity,o.datetime,o.status_id, os.status, o.user_id FROM ".$tblprefix."orders o, ".$tblprefix."order_items i, ".$tblprefix."order_status os, ".$tblprefix."product p, ".$tblprefix."customer c,".$tblprefix."size s WHERE os.id = o.status_id and p.size = s.id and o.id = i.order_id and p.id = i.product_id and o.cust_id = c.id and i.purchase_price > 0 and o.status <> 'CANCELLED' $and ORDER BY o.id DESC"; 
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
<title>Sales Report - Product Size</title>
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
            <h2>Sales Margin</h2>
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
		<td>
        	<table  class="table table-striped table-bordered table-hover table-condensed" id="table">
              <thead>
                 <tr class="info">
                    <th class="text-center">#</th>
                    <th>Order No</th>
                    <th>Customer Name</th>
                    <th>Product</th> 
                    <th>Size</th>  
                    <th>Datetime</th>
                    <th>Status</th>    
                    <th>Order Mode</th> 
                    <th class="text-center">Purchase Price</th>  
                    <th class="text-center">Qty</th> 
                    <th class="text-center">TNT Price</th>
                    <th class="text-center">VAT</th> 
                    <th class="text-center">Total</th> 
                    <th class="text-center">Margin</th>  
                </tr>
              </thead>
              <tbody>
                <?php
                $flg= true;
                $sn = 1;
				 
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
					$VAT 		= amount_format($rs->fields["tnt_price"] * 0.2);	
					$VATtotal   = ($rs->fields["tnt_price"] * $rs->fields["quantity"]) + ($VAT * $rs->fields["quantity"]);  
					$margin = $VATtotal - ($rs->fields["purchase_price"] * $rs->fields["quantity"]);	
					
					
                ?>
                    <tr <?=$class?>>
                        <td align="center"><?=$sn++?></td>
                        <td><?php echo stripslashes($rs->fields["order_no"]);?></td>  
                        <td><?php echo stripslashes($rs->fields["name"]);?></td>  
                        <td><?php echo stripslashes($rs->fields["description"]);?></td> 
                        <td><?php echo stripslashes($rs->fields["size"]);?></td>  
                        <td><?php echo datetimeformat($rs->fields["datetime"]);?></td>  
                        <td><?php echo stripslashes($rs->fields["status"]);?></td> 
                        <td><?php 
							if($rs->fields["user_id"] != 0){
								echo "TNT";	
							}else{
								echo "Customer";	
							}
						?></td>  
                        <td class="text-right"><?php echo amount_format($rs->fields["purchase_price"]);?></td>    
                        <td class="text-center"><?php echo stripslashes($rs->fields["quantity"]);?></td> 
                        <td class="text-right"><?php echo amount_format($rs->fields["tnt_price"]);?></td>  
                        <td class="text-right"><?php echo amount_format($VAT);?></td> 
                        <td class="text-right"><?php echo amount_format($VATtotal);?></td> 
                        <td class="text-right"><?php echo amount_format($margin);?></td> 
                         
                    </tr>
                <?php 
				$totalPP += $rs->fields["purchase_price"];
				$totalQty += $rs->fields["quantity"];
				$total += $rs->fields["tnt_price"];
				$VATgtotal += $VAT;
				$VGtotal += $VATtotal;
			    $marginTotal += $margin;
                $rs->MoveNext();
                }
				?>
				<tr class="success">
                    <td colspan="8" class="text-right"><strong>Total</strong></td> 
                    <td class="text-right"><strong><?php echo amount_format($totalPP);?></strong></td> 
                    <td class="text-center"><strong><?php echo stripslashes($totalQty);?></strong></td> 
                    <td class="text-right"><strong><?php echo amount_format($total);?></strong></td> 
                    <td class="text-right"><strong><?php echo amount_format($VATgtotal);?></strong></td> 
                    <td class="text-right"><strong><?php echo amount_format($VGtotal);?></strong></td> 
                    <td class="text-right"><strong><?php echo amount_format($marginTotal);?></strong></td> 
                </tr>
				<?
                }else{
                ?>
                    <tr class="success">
                        <td colspan="14">No order found!</td>
                    </tr>
                <?php
                }// Reg Companies List 
                ?>
              </tbody>
            </table>
            
            
        </td>
	</tr>
   
</table>
</body>
</html>
 

