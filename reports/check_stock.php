<?php 
	$searchdate = date("Y-m-d");
	include('root.php');
	include($root.'config/conn.php');
	include('../admin_security.php');
	
 
	
	
	if(isset($_GET['size']))
{
	$size = cleanChar(sanitize(trim($_GET["size"])));	
	if($size != ""){
		 $and .= " AND (uf_only_digits(s.size)  like '%".$size."%')";
	}
}
	
	
$sql	=	"select p.id,
				   p.EAN,
				   p.description,
				   p.category,
				   s.size, 
				   s.qty,
				   s.order_qty, 
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
				   p.status,
				   p.F,
				   p.W,
				   p.DB,
				   p.CI,
				   p.purchase_price,
				   p.tnt_price,
				   p.retail_price,
				   p.local_stk,
				   p.total_stk from ".$tblprefix."product p,".$tblprefix."size s WHERE p.size = s.id and s.flag = 1 and s.qty <= p.local_stk  $and order by p.id asc ";
$rs		=	$db->Execute($sql);
$isrs	=	$rs->RecordCount();
	
	 
$vExcelFileName=$date."stockcheck-".date("ymd"). ".xls";
header("Content-type: application/x-ms-download"); 
header("Content-Disposition: attachment; filename=$vExcelFileName");
header('Cache-Control: public');

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sales Report</title> 
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
        	<h1>Top Notch Tyres Wholesale - Stock Check</h1> 
        </td>
    </tr> 
    <tr>
    	<td>&nbsp;</td>
    </tr>
    <tr>
		<td>
        	 <table width="100%" border="1"  class="table table-bordered table-hover">
      <thead>
         <tr class="info">
          <th class="text-center" width="4%">#</th>
          <th width="35%">Description</th>
          <th width="15%">Category</th> 
          <th width="10%">Size</th> 
          <th width="10%">Brand</th> 
          <th width="10%" class="text-center">Stock</th>  
          <th width="10%" class="text-center">Order New</th> 
        </tr>
      </thead>
      <tbody>
      	<?php
		$flg= true; 
		if($isrs > 0){
			$sn = 1;
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
                <td><?php echo stripslashes($rs->fields["description"]);?></td>
                <td><?php echo stripslashes($rs->fields["category"]);?></td>
                <td><?php echo stripslashes($rs->fields["size"]);?></td>
                <td><?php echo getName($tblprefix,"brands","name","id",$rs->fields["brand_id"]);?></td>
                <td class="text-center"><?php echo stripslashes($rs->fields["local_stk"]);?></td>
             	<td class="text-center"><?php echo stripslashes($rs->fields["order_qty"]);?></td>
            </tr>
 		<?php
		$rs->MoveNext();
		}
		}else{
		?>
			<tr class="success">
				<td colspan="8">No product found!</td>
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
 

