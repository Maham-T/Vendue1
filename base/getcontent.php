<?
	if($_GET['page'] != ""){
		 $page  = sanitize($_GET['page']);	
	}else{
		$page = "index";	
	}
	$sql_content = "SELECT ".$tblprefix."pagecontent.page_title,
											".$tblprefix."pagecontent.id,
											".$tblprefix."pagecontent.meta_keyword,   
											".$tblprefix."pagecontent.page_heading,
											".$tblprefix."pagecontent.page_subheading,
											".$tblprefix."pagecontent.meta_phrase,  
											".$tblprefix."pagecontent.meta_description FROM 
											".$tblprefix."pagecontent 
											WHERE 
											".$tblprefix."pagecontent.pagename=".$db->qStr($page)." 
											and  ".$tblprefix."pagecontent.status='A'";
	$rs_content = $db->Execute($sql_content) or die($db->errorMSg());
	$isrs_content = $rs_content->RecordCount();
	if($isrs_content > 0){
		$page_id = $rs_content->fields['id'];
		$title = $rs_content->fields['page_title'];
		$meta_keyword = $rs_content->fields['meta_keyword'];   
		$heading = $rs_content->fields['page_heading'];  
		$sub_heading = $rs_content->fields['page_subheading'];  
		$meta_phrase = $rs_content->fields['meta_phrase']; 
		$content = '<p>'.stripslashes($rs_content->fields['meta_description']).'</p>';  
	}else{
		$title = 'Sorry'; 
		$heading = 'Sorry';
		$content = '<p>No content added for this page</p>'; 
	}  
	$datetime = date('Y-m-d H:i:s');    
 

?>