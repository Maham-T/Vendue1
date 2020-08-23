<?php 
	$searchdate = date("Y-m-d");
	include('root.php');
	include($root.'config/conn.php');
	include('../admin_security.php');
	
	if(isset($_POST['search']))
	{
		$size = cleanChar(sanitize(trim($_POST["size"])));	
		if($size != ""){
				$and .= " AND (uf_only_digits(size)  like '%".$size."%')";
		}
		
		$brand_id = sanitize(trim($_POST["brand_id"]));	
		if($brand_id != ""){
				$and .= " AND (brand_id  = '".$brand_id."')";
		}
		
		$category = sanitize(trim($_POST["category"]));	
		if($category != ""){
				$and .= " AND (category  = '".$category."')";
		} 
	}
	
	
	$sql	=	"select * from ".$tblprefix."product WHERE 1=1 $and order by id asc";
	$rs		=	$db->Execute($sql);
	$isrs	=	$rs->RecordCount();
	
	 
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
        	<h1>Top Notch Tyres Wholesale - Stock</h1>
            <? if($brand_id != "") { ?>
            <h3><?php echo getName($tblprefix,"brands","name","id",$brand_id);?></h3> 
            <? } ?>
            <? if($category  != "") { ?>
            <h3><?=$category ?></h3>
            <? } ?>
            
        </td>
    </tr> 
    <tr>
    	<td>&nbsp;</td>
    </tr>
    <tr>
		<td>
        	 <table width="100%" class="table table-bordered table-hover">
      <thead>
         <tr class="info">
          <th class="text-center" width="3%">#</th>
          <th width="52%">Description</th>
          <th width="15%">Category</th> 
          <th width="10%">Size</th> 
          <th width="10%">Brand</th> 
          <th width="10%" class="text-center">Stock</th> 
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
			
			$totalStk += $rs->fields["local_stk"];
		?>
         	<tr <?=$class?>>
              	<td align="center"><?=$sn++?></td>
                <td><?php echo stripslashes($rs->fields["description"]);?></td>
                <td><?php echo stripslashes($rs->fields["category"]);?></td>
                <td><?php echo stripslashes($rs->fields["size"]);?></td>
                <td><?php echo getName($tblprefix,"brands","name","id",$rs->fields["brand_id"]);?></td>
                <td class="text-right"><?php echo stripslashes($rs->fields["local_stk"]);?></td> 
            </tr>
 		<?php
		$rs->MoveNext();
		}
		
		?>
		<tr>
              	<td align="center" colspan="5"><strong>Total</strong></td> 
                <td class="text-right"><strong><?php echo stripslashes($totalStk);?></strong></td> 
            </tr>	
		<?
		}else{
		?>
			<tr class="success">
				<td colspan="6">No product found!</td>
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
 

