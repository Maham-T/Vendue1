<?php 
	$searchdate = date("Y-m-d");
	include('root.php');
	include($root.'config/conn.php');
	include('../admin_security.php');
	
	if(isset($_POST['search']))
	{
  		$and		=	'';
		
	 
		if($_POST['domain_id'] != ""){
			$and .= " AND o.domain_id = '".$_POST['domain_id']."'";
		}
 		if($_POST['is_order'] == 2){
			$ordercheck .= " NOT  ";
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

	$sql = "SELECT * from ".$tblprefix."customer c where $ordercheck EXISTS (SELECT 1 from ".$tblprefix."orders o where o.cust_id = c.id $and   )";
	 
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
<title>Customer Report</title>
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
			<h2>Customer</h2>
            <? if($_POST['is_order'] == "1") { ?>
            <h3>Have Order</h3> 
            <? }else{
			?>
			<h3>Do not have order</h3> 
			<?
			} ?>
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
                    <th>Customer No</th>
                    <th>Customer Name</th>
                    <th>Contact Person</th> 
                    <th>Phone No</th>  
                    <th>Email</th>
                    <th>Address</th>    
                    <th>Postcode</th>  
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
					   
                ?>
                    <tr <?=$class?>>
                        <td align="center"><?=$sn++;?></td>
							<td><?php echo stripslashes($rs->fields["cust_no"]);?></td>  
							<td><?php echo stripslashes($rs->fields["name"]);?></td> 
							<td><?php echo stripslashes($rs->fields["contact_person"]);?></td>   
							<td><?php echo stripslashes($rs->fields["phone_no"]);?></td>     
							<td><?php echo stripslashes($rs->fields["email"]);?></td> 
							<td><?php echo stripslashes($rs->fields["address"]);?></td>   
							<td><?php echo stripslashes($rs->fields["postcode"]);?></td> 
                    </tr>
                <?php 
				
                $rs->MoveNext();
                }
			 
                } 
                ?>
              </tbody>
            </table>
            
            
        </td> 
	</tr>
   
</table>
</body>
</html>
 

