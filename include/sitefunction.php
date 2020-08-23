<?php  
use MatthiasMullie\Minify;
function CSS($path, $cssfiles){  
	$files = explode(",",$cssfiles);
	for($i=0;$i<count($files);$i++){  
		$sourcePath = $path.$files[$i];
		$fileContents = file_get_contents($sourcePath);
		$minifier = new Minify\CSS($fileContents);
		$minifiedContents = $minifier->minify();  
		$minPath = $path."minify-".$files[$i];
		$fp = fopen($minPath ,"wb");
		fwrite($fp,$minifiedContents);
		fclose($fp); 
		echo '<link async href="'.MYSURL.$minPath.'" media="screen"  type="text/css" rel="stylesheet">'; 
	} 
}

function JS($path, $jsfiles){  
	$files = explode(",",$jsfiles);
	for($i=0;$i<count($files);$i++){  
		$sourcePath = $path.$files[$i];
		$fileContents = file_get_contents($sourcePath);
		$minifier = new Minify\JS($fileContents);
		$minifiedContents = $minifier->minify();  
		$minPath = $path."minify-".$files[$i];
		$fp = fopen($minPath ,"wb");
		fwrite($fp,$minifiedContents);
		fclose($fp); 
		echo '<script async type="text/javascript" src="'.MYSURL.$minPath.'"></script> '; 
	} 
}

function cleanChar($string) {
   $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^0-9\-]/', '', $string); // Removes special chars.
}
function compressImage($source_url, $destination_url, $quality) {
    $info = getimagesize($source_url);

    if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
    elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
    elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);

    //save file
    imagejpeg($image, $destination_url, $quality);

    //return destination file
    return $destination_url;
}
function urlkeyword($string){ 
	 return strtolower(str_replace("?","",str_replace("&","and",str_replace("/","",str_replace(".","",str_replace(" ","-",trim($string))))))); 
} 

function orderNo($tblprefix){
	global $db;
	$sql = "SELECT LPAD(count(1) + 1,4,'0') cnt FROM ".$tblprefix."orders WHERE date(datetime) = ".$db->qStr(date("Y-m-d"));
	$rs = $db->Execute($sql) or die($db->errorMsg());  
	return ORDER_NO_PREFIX.date('ymd').$rs->fields['cnt'];
	
}
//Slide Show Function 
function getNavWithType($tblprefix,$type, $flag){
	global $db;
	$sql = "SELECT * FROM ".$tblprefix."category WHERE status = 'A' and parent = '".$type."'";
	$rs = $db->Execute($sql) or die($db->errorMsg());
    $isrs = $rs->RecordCount();
	if($isrs > 0){
		if($flag === "header"){
			?>
		<ul class="dropdown-menu mega-dropdown-menu <? if($rs->fields['icon'] == ""){ ?> cdropdown <? }else{ ?> idropdown <? } ?> ">  
					
		<? 
		}else{
			?>
		<ul>  
					
		<? 
		}
		
		while (!$rs->EOF){ 
			?>
			<li <? if($rs->fields['icon'] != ""  && $flag === "header"){ ?> class="col-sm-3" <? } ?> >
			 <a href="<?=MYSURL?>products/type/<?=urlkeyword($rs->fields['parent'])?>/category/<?=urlkeyword($rs->fields['name'])?>/<?=base64_encode($rs->fields['id'])?>"> 
				 <?=$rs->fields['name']?> 
				 <? if($rs->fields['icon'] != "" && $flag === "header"){
				?>
				<img src="<?=MYSURL?>uploads/category/<?=$rs->fields['icon']?>" class="img-responsive" alt="<?=$rs->fields['name']?>" >
				<?
			}?>
				
			
			</a>
			</li> 
			<? 
		$rs->MoveNext();
		} 
	?>
	</ul>
	<?
	}
	
}   
  

 
//Check box list
function GetCheckBoxLists($tblprefix, $tblname , $datatogetid, $datatogetname, $where, $fieldname, $classname, $extrapram, $updateid){
	global $db;
	$editid= 0;
	if($where != '')
	{
		$wherecluase = "WHERE ".$where;	
	}else
	{
		$wherecluase = '';
	}
	$sql_ind = "SELECT  a.".$datatogetid.", a.".$datatogetname." FROM ".$tblprefix.$tblname." a ".$wherecluase;
	$rs_ind = $db->Execute($sql_ind);
	$isrs_ind = $rs_ind->RecordCount();
	if($isrs_ind){
		while (!$rs_ind->EOF){ 
		
		 if($updateid != ''){
		 	$editid = CheckUserRoleID($tblprefix,$updateid,$rs_ind->fields[$datatogetid]);
		 }
		
		if($editid == $rs_ind->fields[$datatogetid]){
		$chk = 'checked="checked"';
		}else{
		$chk = '';
		}
		?>
		 <div class="menuDiv-text">
                    <input type="checkbox" name="<?=$fieldname?>"  id="<?=$rs_ind->fields[$datatogetid];?>" value="<?=$rs_ind->fields[$datatogetid];?>" <?=$chk;?> class="<?=$classname;?>"  <?=$extrapram;?>/> <label for="<?=$rs_ind->fields[$datatogetid];?>"> <?=ucfirst($rs_ind->fields[$datatogetname]);?></label>
         </div>
		<?
		$rs_ind->MoveNext(); 
		} 
		
	}
	//return $List;
}
 
 //GETTING Select Dropdown LIST
function GetSelectDropdownList($tblprefix, $table, $fieldname, $datatoget,$datatodisplay, $updateid, $classname, $extrapram){
	global $db; 
	$sql_ind = "SELECT  ".$tblprefix.$table.".$datatoget, ".$tblprefix.$table.".$datatodisplay from ".$tblprefix.$table." where status = 'A' ";
	$rs_ind = $db->Execute($sql_ind) or die($db->errorMSg());
	$isrs_ind = $rs_ind->RecordCount();
	if($isrs_ind){
	?>
    <select name="<?=$fieldname ?>" id="<?=$fieldname ?>" class="<?=$classname?>" <?=$extrapram?> >
	<option value="">Select</option>
    <?	
		while (!$rs_ind->EOF){ 
		?>
		<option value="<?=$rs_ind->fields[$datatoget]?>" <? if( strtolower($updateid) == strtolower($rs_ind->fields[$datatoget])){ ?> selected <? } ?>><?=ucfirst($rs_ind->fields[$datatodisplay])?></option>
		<?
		$rs_ind->MoveNext(); 
		} 
		?>
		</select>
		<?
	}
}
 
function qPriceRound($val){
	$val = round($val);
	$len = strlen($val);
	$lastdigit = substr($val,$len  - 1,$len);
	if($lastdigit > 5){
		$newval = $val + (10 - $lastdigit);
	}else{
		$newval = $val - $lastdigit ;
	}
	return($newval);
}
 


 function getRunningURL()
 {
    /*** check for https ***/
	 if (array_key_exists('HTTPS', $_SERVER) && $_SERVER["HTTPS"] == "on") {
		 $protocol ='https';
	 }else{
		  $protocol ='http';
	 }
	 
    //$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
    /*** return the full address ***/
    return $protocol.'://'.$_SERVER['HTTP_HOST'].'/';
 }
//HOME SHORT WORDS
function funclongwords_general($text, $limit){
	if (strlen($text) > $limit){
		$text_to_display = substr($text,0,$limit);
		return $text_to_display."...";
	}else{
		return $text;
	}
}
 
#-- SANITIZING VALUES FUNCTION -- STARTS --#
function cleanInput($input) {
	$search = array(
		'@<script[^>]*?>.*?</script>@si',   // Strip out javascript
		/*'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags*/
		'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
		'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
	);
    $output = preg_replace($search, '', $input);
    return $output;
}

function sanitize($input){
    if (is_array($input)){
        foreach($input as $var=>$val) {
            $output[$var] = sanitize($val);
        }
    }else{
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
        $output  = cleanInput($input);
        //$output = mysql_real_escape_string($input);
    }
	$output_final = preg_replace("/<.*?>/", "", $output);
    return trim($output_final);
}
 
 
#-- SANITIZING VALUES FUNCTION -- ENDS --#
function is_email($email){
	$email = strtolower($email);
	return filter_var($email, FILTER_VALIDATE_EMAIL) !== false; 
}
function strToNumber($str){
	return sanitize( str_replace("£","",str_replace('&pound', '',str_replace(',', '', $str))));
} 
function siteRandom($no){
	$totalChar = $no;  //length of random number
	$salt = "abcdefghijklmnpqrstuvwxyz";  // salt to select chars
	srand((double)microtime()*1000000); // start the random generator
	$password=""; // set the inital variable
	for ($i=0;$i<$totalChar;$i++)  // loop and create number
	$randnumber= $randnumber. substr ($salt, rand() % strlen($salt), 1);
	return $randnumber;
}
function siteRandomNum($no){
	$totalChar = $no;  //length of random number
	$salt = "123456789";  // salt to select chars
	srand((double)microtime()*1000000); // start the random generator
	$password=""; // set the inital variable
	for ($i=0;$i<$totalChar;$i++)  // loop and create number
	$randnumber= $randnumber. substr ($salt, rand() % strlen($salt), 1);
	return $randnumber;
}     
function getmsg($tblprefix){
	global $db;
	
	$class = $_SESSION['type'];
	$type = $_SESSION['msg'];
		
	if($class == "" && $type == ""){
		return;
	}   
	$sql = "SELECT * FROM ".$tblprefix."msg_manage WHERE type = ".$db->qStr($type);
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
	if($isrs > 0){ 
		?> 
		<div class="alert  alert-<?=$class?>">
			<button class="close" data-close="alert"></button>
			<span><?=$rs->fields['message'];?></span>
			
		</div>
		<? 
	}else{
		?>
		<div  class="alert alert-<?=$class?>"> 			
			<button class="close" data-close="alert"></button>
			<span>No message found</span>
		</div>
		<? 
	}
	unset($_SESSION['msg']);
	unset($_SESSION['type']);
}
  


/************** Encryption and Decryption *******************/
function password($password) {
	return hashme($password, null, true);
}
function hashme($string, $type = null, $salt = false) {

	if ($salt){
		$string = read().$string;
	}

	$type = strtolower($type);

	if ($type == 'sha1' || $type == null) {
		if (function_exists('sha1')) {
			$return = sha1($string);
			return $return;
		} else {
			$type = 'sha256';
		}
	}

	if ($type == 'sha256') {
		if (function_exists('mhash')) {
			$return = bin2hex(mhash(MHASH_SHA256, $string));
			return $return;
		} else {
			$type = 'md5';
		}
	}

	if ($type == 'md5') {
		$return = md5($string);
		return $return;
	}
}
function read(){
	$name = 'wbctauthkey';
	return $name;
}
 
function strip_slashes($input){
	return stripslashes($input);
}
function get_email_template($tblprefix, $emailtype){
	global $db;
	 $sql_email_contents = "SELECT * FROM ".$tblprefix."email_conf WHERE email_type = '".$emailtype."'";
	$rs_email_contents = $db->Execute($sql_email_contents);
	$isrs_email_contents = $rs_email_contents->RecordCount();
	if($isrs_email_contents > 0){
		$temp_arr = array('subject'=>strip_slashes($rs_email_contents->fields['subject']), 'body'=>strip_slashes($rs_email_contents->fields['email_body']));
		return $temp_arr;
	}else{
		$temp_arr = array('subject'=>'no', 'body'=>'no');
		return $temp_arr;
	}
}

function getCompanyDetails($tblprefix,$company_id){
	global $db; 
	$sql_admin = "SELECT name, email,  contact_no, address, logo  FROM ".$tblprefix."company WHERE id = ".$db->qStr($company_id);
	$rs_admin = $db->Execute($sql_admin);
	$isrs_admin = $rs_admin->RecordCount();
	if($isrs_admin > 0){
		$admin_arr = array('name'=>strip_slashes($rs_admin->fields['name']), 'email'=>strip_slashes($rs_admin->fields['email']), 'contact_no'=>strip_slashes($rs_admin->fields['contact_no']), 'address'=>strip_slashes($rs_admin->fields['address']), 'logo'=>strip_slashes($rs_admin->fields['logo'])); 
	} 
	return $admin_arr;
}

function getMenuParentIdByPage($tblprefix,$page){
	global $db;
	$sql_m = "SELECT parent_id FROM ".$tblprefix."menus WHERE menu_action = ".$db->qStr($page);
	$rs_m = $db->Execute($sql_m);
	$isrs_m = $rs_m->RecordCount(); 
	
	if($isrs_m > 0){ 
		return $rs_m->fields['parent_id'];
	}else{
		return 0;
	} 
}
 
//DATE FORMAT
function dateformat($date){
	$changeddate = date('M d, Y', strtotime($date));
	return $changeddate; 
}

function dateformatInput($date){
	$changeddate = date('Y-m-d', strtotime($date));
	return $changeddate; 
}

//DATE TIME FORMAT
function datetimeformat($date){
	$changeddate = date('F d, Y h:i A', strtotime($date));
	return $changeddate; 
}

//DATE TIME FORMAT
function datetimeformatforcounter($date){
	$changeddate = date('M d, Y h:i:s', strtotime($date));
	return $changeddate; 
}

//DATE FORMAT
function dateformatsmall($date){
	$changeddate = date('M d, Y', strtotime($date));
	return $changeddate; 
}
//TIME FORMAT
function timeformat($time){
	$changedtime = date('h:i A', strtotime($time));
	return $changedtime; 
}
 
//TIME FORMAT
function DateToDb($Date)
{
	return date("Y-m-d", strtotime($Date));
}
 
//DATE TO MONTH FORMAT
function DateToMonth($Date)
 {
	return date("m", strtotime($Date));
 }	
 //DATE TO Day FORMAT
function DateToDay($Date)
 {
	return date("d", strtotime($Date));
 }	

 
 //DATE TO MONTH FORMAT
function DateToYear($Date)
 {
	return date("Y", strtotime($Date));
 }	 

//DATE TO MONTH FORMAT
function ShowMonth($Date)
 {
	return date("M", strtotime($Date));
 }	
 
 //DATE TO Day FORMAT
function ShowDay($Date)
 {
	return date("D", strtotime($Date));
 }	
 
 //DATE TO Day FORMAT
function DatePlusDays($Date,$Days)
{
	return date('Y-m-d', strtotime($Date. ' + '.$Days.' days'));
}

//FUNCTION PRICE FORMAT CHANGE
function amount_format($amount){
	$minus = substr($amount,0,1);
	if($minus == '-'){
		$sign = '-';
		$amount = substr($amount,1);
	}else{
		$sign = '';
	}
	$dot = strpos($amount,'.');
	if($float == ''){
		$float = '.00';
	}
	if($dot != ''){
		$float = substr($amount,$dot);
		$amount = substr($amount,0,$dot);
	} 
	if(strlen($float) <= 2){
		$float = $float.'0';
	}else{
		$float = substr($float,0,3);
	} 

	if($amount){
		$amount_numbers = strlen($amount);
		$tmp = '';
		$c = 0;
		$tmp = strrev($amount);
		$c = 0;
		for($i=0;$i<$amount_numbers;$i++){
			
			if($c%3 == 0){
				$tmp_st.= ','.$tmp{$i};
			}else{
				$tmp_st.= $tmp{$i};
			}
			$c++;
		}
		return $sign.strrev(ltrim($tmp_st,',')).$float;
	}else{
		return '0'.$float;
	}
}


function amountFormat($amount){
	$minus = substr($amount,0,1);
	if($minus == '-'){
		$sign = '-';
		$amount = substr($amount,1);
	}else{
		$sign = '';
	}
	$dot = strpos($amount,'.');
	if($float == ''){
		$float = '.00';
	}
	if($dot != ''){
		$float = substr($amount,$dot);
		$amount = substr($amount,0,$dot);
	} 
	if(strlen($float) <= 2){
		$float = $float.'0';
	}else{
		$float = substr($float,0,3);
	} 

	if($amount){
		$amount_numbers = strlen($amount);
		$tmp = '';
		$c = 0;
		$tmp = strrev($amount);
		$c = 0;
		for($i=0;$i<$amount_numbers;$i++){
			
			if($c%3 == 0){
				$tmp_st.= ','.$tmp{$i};
			}else{
				$tmp_st.= $tmp{$i};
			}
			$c++;
		}
		return  $sign.strrev(ltrim($tmp_st,',')).$float;
	}else{
		return  '0'.$float;
	}
}
 
//DIIFERANCE BETWEEN TWO DAYS
function DateDif($date1,$date2){
	$days = (strtotime($date2) - strtotime($date1)) / (60 * 60 * 24);
	if($days <= 0){
		$days = 1;
	}
	return floor($days);
}
    
//SEO Tags
function GetSEOTags($tblprefix){
	global $db;
	$sql = "SELECT * FROM ".$tblprefix."seometatags WHERE  tag_id = 1 ";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
	if($isrs > 0){
		?>
        <meta name="classification" content="<?=$rs->fields['classification'];?>"/>       
        <?php  if($_SERVER['REQUEST_URI'] == '/terms-and-conditions'  or $_SERVER['REQUEST_URI'] == '/privacy-policy'){ ?>
         <meta name="robots" content="NOINDEX,NOFOLLOW" /> 
        <?php } else { ?>
          <meta name="robots" content="<?=$rs->fields['robots'];?>"/>         
        <?php } ?>
        <meta name="google site verification" content="<?=$rs->fields['google_site_verification'];?>"/> 
        <meta name="language" content="<?=$rs->fields['language'];?>"/> 
        <meta name="resource type" content="<?=$rs->fields['resource_type'];?>"/> 
        <meta name="copyright" content="<?=$rs->fields['copyright'];?>"/> 
        <meta name="author" content="<?=$rs->fields['author'];?>"/> 
        <meta name="PICS Label" content="<?=$rs->fields['PICS_Label'];?>"/> 
        <meta name="distribution" content="<?=$rs->fields['distribution'];?>"/> 
        <meta name="coverage" content="<?=$rs->fields['coverage'];?>"/> 
        <meta name="country" content="<?=$rs->fields['country'];?>"/> 
        <meta name="location" content="<?=$rs->fields['location'];?>"/> 
       <?
	}else{
		return 'No SEO Tag found';

	}
}
//SEO Tags

function GetGoogleAnalytic($tblprefix){
	global $db;
	$sql = "SELECT * FROM ".$tblprefix."google_analytic WHERE  id =1  ";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
	if($isrs > 0){
		$seo_arr = array('analytic_code'=>$rs->fields['analytic_code'], 'seo_code'=>$rs->fields['seo_code'], 'seo_code1'=>$rs->fields['seo_code1'], 'seo_code2'=>$rs->fields['seo_code2'], 'seo_code3'=>$rs->fields['seo_code3']);
	}else{
		$seo_arr = array('analytic_code'=>'', 'seo_code'=>'', 'seo_code1'=>'', 'seo_code2'=>'', 'seo_code3'=>'');
	}
	return $seo_arr;
}
/************** Get Name By table and Id  *******************/
function getName($tblprefix,$table,$field,$id,$idnum){
	if($id){
		global $db;
		$qry = "select $field as field from ".$tblprefix.$table." where $id LIKE '".$idnum."'";
		$rs = $db->Execute($qry);
		$isrs=$rs->RecordCount();
		if($isrs > 0){
				return ucfirst($rs->fields['field']);
		}else{
			return "Unknown";
		}
	}else{
		return "Unknown";
	}
} 

 
 
//GETTING POPULAR  DESTINATION LIST
function GetLendingPagesList($tblprefix){
	global $db;
	$sql_ind = "SELECT * FROM ".$tblprefix."pages
		WHERE status = 'A' 
		ORDER BY id asc LIMIT 0,24";
	$rs_ind = $db->Execute($sql_ind);
	$isrs_ind = $rs_ind->RecordCount();
		if($isrs_ind>0){
			while (!$rs_ind->EOF){
			?>
            <div class="destinationlist"><a href="<?=MYSURL?>page/<?=$rs_ind->fields['urlkeyword']?>/<?=base64_encode($rs_ind->fields['id'])?>"><?=$rs_ind->fields['pagename']?></a></div>
           <?
			$rs_ind->MoveNext(); 
			} 	
		}
} 
function getBlockChainListByTabId($tblprefix,$tabId){
	global $db;
	$sql_ind = "SELECT * FROM ".$tblprefix."blockchain_use
		WHERE status = 'A' and  tab_id=".$db->qStr($tabId);
	$rs_ind = $db->Execute($sql_ind);
	$isrs_ind = $rs_ind->RecordCount();
		if($isrs_ind>0){
			?>
			<ul class="listing">   
			<?
			while (!$rs_ind->EOF){
			?>
            <li><?=$rs_ind->fields['description']?></li>
            <?
			$rs_ind->MoveNext(); 
			} 	
			?>
			</ul>
			<?
		}
} 


function getOurHistory($tblprefix){
	global $db;
	$sql_ind = "SELECT * FROM ".$tblprefix."our_history
		WHERE status = 'A' 
		ORDER BY id asc LIMIT 0,24";
	$rs_ind = $db->Execute($sql_ind);
	$isrs_ind = $rs_ind->RecordCount();
		if($isrs_ind>0){
			while (!$rs_ind->EOF){
			?>
            <li>  
                <span class="text-rotate"><?=$rs_ind->fields['title']?></span>
                <h3 class="blue"><?=$rs_ind->fields['year']?></h3> 
                <p><?=$rs_ind->fields['description']?></p>
             </li> 
           <?
			$rs_ind->MoveNext(); 
			} 	
		}
}
 
  
//GETTING Check box list for project detail page
function GetCheckBoxByType($tblprefix,$type,$selectedVal){
	global $db;
	$sql_ind = "SELECT * FROM ".$tblprefix."pd_checkbox
		WHERE status = 'A' and type = ".$db->qStr($type)." 
		ORDER BY id asc ";
	$rs_ind = $db->Execute($sql_ind);
	$isrs_ind = $rs_ind->RecordCount();
		if($isrs_ind>0){
			$selectedVal = explode(",",$selectedVal); 
			?>
			 <ul class="lp-checks"> 
			<? 
			while (!$rs_ind->EOF){
				$checked = "";
				if (in_array($rs_ind->fields['id'], $selectedVal)) 
				{
					$checked = "checked";
				}
			?>
           <li><label class="custom-control custom-checkbox">
                <input type="checkbox" <?=$checked?> name="<?=$type?>[]" id="<?=$type; ?>_<?=$rs_ind->fields['id']?>" value="<?=$rs_ind->fields['id']?>" class="custom-control-input">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description"><?=$rs_ind->fields['label']?></span>
              </label></li> 
           <?
			$rs_ind->MoveNext(); 
			} 	
			?>
			</ul>
			
			<?
		}
} 
 

function checkPageApplicability($tblprefix,$page_id,$applicable_pages){
	global $db;
	$sql = "SELECT 
					".$tblprefix."pages_applicability.id
				FROM ".$tblprefix."pages_applicability 
				WHERE applicable_pages = '".$applicable_pages."' 
				AND page_id <= '".$page_id."'";
	$rs = $db->Execute($sql);
	$isrs  = $rs->RecordCount();
	if($isrs > 0){
		 return 1;
	}else{
		return 0;
	}
}
 

//Slide Show Function 
function getBanners($tblprefix){
	global $db; 
	$sql = "SELECT * FROM ".$tblprefix."banners WHERE status = 'A' and domain_id =  ".$db->qStr(DID)." order by id asc"; 
	$rs = $db->Execute($sql) or die($db->errorMsg());
    $isrs = $rs->RecordCount(); 
	$c = 0;
	if($isrs > 0){
		?>
		<header>
		  <div id="carouselHeader" class="carousel home-page slide" data-ride="carousel">
		  <? if($isrs > 1){ ?>
			<ol class="carousel-indicators float-xs-right">
			  <? for($i=0; $i< $isrs ; $i ++){
					?>
					<li data-target="#carouselHeader" data-slide-to="<?=$i?>" <? if($i ===0 ){ ?> class="active" <? } ?>></li>
					<?
				}?> 
			</ol>
			<? } ?>
			<div class="carousel-inner" role="listbox">
		  		<? 
		    	while (!$rs->EOF){ 
					$image 			= UPLOADS."banners/".$rs->fields['image'];
					$heading 		= $rs->fields['heading'];
					$sub_heading 	= explode(",",$rs->fields['sub_heading']);
					 
					$text 			= $rs->fields['text'];
					?>
					<div class="carousel-item <? if( $c === 0){ ?> active <? }?>" style="background-image: url(<?=$image?>)">
						<div class="carousel-caption d-md-block">
							<? if($heading != ""){
								?>
								<h3><span><?=$heading?></span></h3>
								<?
							}
							/*for($a=0;$a<count($sub_heading ) ;$a++){
								?>
								<h1 class="fadey"><?=$sub_heading[$a]?></h1>
								<?
							}*/
							?>  
							<? if($text != ""){
								?>
								<p><?=$text?></p>
								<?
							}?>							
						</div>
					  </div>
			   
					<? 
					$c++;
					$rs->MoveNext();
				}
			  ?> 
			</div>
			<? if($isrs > 1){ ?>
			<a class="carousel-control-prev" href="#carouselHeader" role="button" data-slide="prev">
			  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
			  <span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselHeader" role="button" data-slide="next">
			  <span class="carousel-control-next-icon" aria-hidden="true"></span>
			  <span class="sr-only">Next</span>
			</a>
			<? } ?>
		  </div>
		</header> 
		<? 
	} 
}
 
//Slide Show Function 
function getTabs($tblprefix){
	global $db;  
	$sql = "SELECT * FROM ".$tblprefix."tabs WHERE status = 'A' and domain_id =  ".$db->qStr(DID)." order by id asc"; 
	$rs = $db->Execute($sql) or die($db->errorMsg());
    $isrs = $rs->RecordCount();  
	$rs1 = $db->Execute($sql) or die($db->errorMsg()); 
	$rs2 = $db->Execute($sql) or die($db->errorMsg()); 
	
	$a = 0;
	$c = 0;
	$d = 0;
	if($isrs > 0){
		?>
		
		
		<div class="what-to-do">
		    <ul class="nav nav-pills" id="pills-tab" role="tablist">
		    
		    <? 
		    	while (!$rs->EOF){ 
					$icon 			= UPLOADS."tabs/".$rs->fields['icon'];
					$active_icon 	= UPLOADS."tabs/".$rs->fields['active_icon'];   
						
					$name 		= $rs->fields['name'];
					$id 		= $rs->fields['id'];
					
					?>
					<li class="nav-item">
						<a class="nav-link wwd-tab-link <? if( $c === 0){ ?> active <? }?>" data-id="<?=$id?>" id="tab-<?=$id?>" data-toggle="pill" href="#content-<?=$id?>" role="tab" aria-controls="content-<?=$id?>" aria-expanded="true"> 
						<img src="<?=$active_icon?>" id="aicon-<?=$id?>"  class="img-fluid img-active" <? if( $c != 0){ ?>  style="display: none" <? } ?> alt="<?=$name ?>">
						<img src="<?=$icon?>" id="icon-<?=$id?>"  class="img-fluid img-inactive" <? if( $c === 0){ ?>  style="display: none" <? } ?> alt="<?=$name ?>">  
						<br>
						<?=$name ?></a>
					  </li> 
					<? 
					$c++;
					$rs->MoveNext();
				}
			  ?> 
		</ul>
			<div class="tab-content" id="pills-tabContent">
		  
		  	<? 
		    	while (!$rs1->EOF){ 
					$image 		= UPLOADS."tabs/".$rs1->fields['image']; 
					$heading	= $rs1->fields['heading'];
					$text		= $rs1->fields['text'];
					$id 		= $rs1->fields['id'];
					
					?>
					<div class="tab-pane fade show <? if( $a === 0){ ?> active <? }?>" id="content-<?=$id?>" role="tabpanel" aria-labelledby="tab-<?=$id?>">
					  <div class="row">
						  <div class="col-4">
							<img src="<?=$image?>" class="img-fluid">
						  </div>
						  <div class="col-8">
							  <h1><?=$heading?></h1>
							 <?=$text?>
							 <button type="button" data-toggle="modal" data-target="#gFqnModal" class="btn btn-default text-uppercase">get free quote now</button>
						  </div>
					  </div>	
				  </div> 
 
					<? 
					$a++;
					$rs1->MoveNext();
				}
			  ?> 
		   
			</div>
			</div> 
			
			
		<div id="mobileTabs" data-children=".item">
	  		<? 
		    	while (!$rs2->EOF){ 
					$image 		= UPLOADS."tabs/".$rs2->fields['image']; 
					$heading	= $rs2->fields['heading'];
					$text		= $rs2->fields['text'];
					$id 		= $rs2->fields['id'];
					$name 		= $rs2->fields['name'];
					
					?>
					 <div class="item bottom-buffer-10">
						<a data-toggle="collapse" data-parent="#mobileTabs" href="#<?=$id?>" aria-expanded="true" aria-controls="<?=$id?>" class="btn btn-default btn-block">
						  <?=$name?>
						</a>
						<div id="<?=$id?>" class="collapse" role="tabpanel">
						  <div class="row">
							  <div class="col-12">
								<img src="<?=$image?>" class="img-fluid">
							  </div>
							  <div class="col-12">
								  <h1><?=$heading?></h1>
								 <?=$text?>
								 <button type="button" data-toggle="modal" data-target="#gFqnModal" class="btn btn-default btn-block text-uppercase">get free quote now</button>
							  </div>
						  </div>	
						</div>
					  </div> 
 
					<? 
					$d++;
					$rs2->MoveNext();
				}
			  ?>  
		</div>	
		  
		<? 
	} 
}
 

//Slide Show Function 
function getFooterLinks($tblprefix,$page){
	global $db;
	$sql = "SELECT * FROM ".$tblprefix."pages WHERE status = 'A' and domain_id = '".$_SESSION['domain']."'  AND id in (SELECT page_id FROM ".$tblprefix."pages_applicability WHERE applicable_pages = '".$page."')";
	$rs = $db->Execute($sql);
    $isrs = $rs->RecordCount();
	if($isrs > 0){
		$i = 1;
		    while (!$rs->EOF){ 
				?>
				<a href="<?=MYSURL.$rs->fields['urlkeyword']?>"><?=$rs->fields['pagename']?></a>
				<?
				$i++;
			$rs->MoveNext();
            }
			
	}else{
		?>
            <a href="<?=MYSURL?>">Home</a>
            <a href="<?=MYSURL?>how-it-works">How It Works</a>
            <a href="<?=MYSURL?>faq">FAQ</a>
            <a href="<?=MYSURL?>testimonials">Testimonials</a>
            <a href="<?=MYSURL?>contact-us">Contact Us</a>
            <a href="<?=MYSURL?>sitemap">HTML Sitemap</a>
            <a href="<?=MYSURL?>sell-your-car">Sell Your Car</a>
            <a href="<?=MYSURL?>terms-and-conditions">Terms & Conditions</a>
            <a href="<?=MYSURL?>privacy-policy">Privacy Policy</a> 
            <a href="<?=MYSURL?>affiliates">Affiliates</a>            
		<?

	}
}


function dashboardCounter($tblprefix, $cType){
	global $db;
	if($cType == 'new_quotes'){
		//Total Qutations
		$total= "select ifnull(count(*),0) as rows from ".$tblprefix."quote where status = 'New' "; 
		// Count the number of Records query is goes here.$totalRows 
		$totalRows = $db->Execute($total) or die($db-ErrorMsg());
		$totalRows = $totalRows->fields['rows'] ;
		return $totalRows;
	}
	if($cType == 'all_quotes'){
		//Total Qutations
		$total= "select ifnull(count(*),0) as rows from ".$tblprefix."quote ";   
		// Count the number of Records query is goes here.$totalRows 
		$totalRows = $db->Execute($total) or die($db-ErrorMsg());
		$totalRows = $totalRows->fields['rows'] ;
		return $totalRows;
	}
	
	if($cType == 'bin_quotes'){
		//Total Qutations
		$total= "select ifnull(count(*),0) as rows from ".$tblprefix."quote  where status = 'bin' ";   
		// Count the number of Records query is goes here.$totalRows 
		$totalRows = $db->Execute($total) or die($db-ErrorMsg());
		$totalRows = $totalRows->fields['rows'] ;
		return $totalRows;
	}
	
	
	
	if($cType == 'all_projects'){
		//Total Qutations
		$total= "select ifnull(count(*),0) as rows from ".$tblprefix."projects  ";   
		// Count the number of Records query is goes here.$totalRows 
		$totalRows = $db->Execute($total) or die($db-ErrorMsg());
		$totalRows = $totalRows->fields['rows'] ;
		return $totalRows;
	}
	
	if($cType == 'all_projects'){
		//Total Qutations
		$total= "select ifnull(count(*),0) as rows from ".$tblprefix."projects  ";   
		// Count the number of Records query is goes here.$totalRows 
		$totalRows = $db->Execute($total) or die($db-ErrorMsg());
		$totalRows = $totalRows->fields['rows'] ;
		return $totalRows;
	}
	
	if($cType == 'current_projects'){
		//Total Qutations
		$total= "select ifnull(count(*),0) as rows from ".$tblprefix."projects  where status in ('awarded','payment') ";   
		// Count the number of Records query is goes here.$totalRows 
		$totalRows = $db->Execute($total) or die($db-ErrorMsg());
		$totalRows = $totalRows->fields['rows'] ;
		return $totalRows;
	}
	
	if($cType == 'completed_projects'){
		//Total Qutations
		$total= "select ifnull(count(*),0) as rows from ".$tblprefix."projects  where status = 'completed'  ";   
		// Count the number of Records query is goes here.$totalRows 
		$totalRows = $db->Execute($total) or die($db-ErrorMsg());
		$totalRows = $totalRows->fields['rows'] ;
		return $totalRows;
	}
	
	if($cType == 'hold_projects'){
		//Total Qutations
		$total= "select ifnull(count(*),0) as rows from ".$tblprefix."projects  where status = 'hold'  ";   
		// Count the number of Records query is goes here.$totalRows 
		$totalRows = $db->Execute($total) or die($db-ErrorMsg());
		$totalRows = $totalRows->fields['rows'] ;
		return $totalRows;
	}
	
	
	if($cType == 'paid'){
		//Total Qutations
		$total= "select ifnull(count(*),0) as rows from ".$tblprefix."invoices  where status = 'paid'  ";   
		// Count the number of Records query is goes here.$totalRows 
		$totalRows = $db->Execute($total) or die($db-ErrorMsg());
		$totalRows = $totalRows->fields['rows'] ;
		return $totalRows;
	}
	
	if($cType == 'not_paid'){
		//Total Qutations
		$total= "select ifnull(count(*),0) as rows from ".$tblprefix."invoices  where status = 'not_paid'  ";   
		// Count the number of Records query is goes here.$totalRows 
		$totalRows = $db->Execute($total) or die($db-ErrorMsg());
		$totalRows = $totalRows->fields['rows'] ;
		return $totalRows;
	}
	
	if($cType == 'invoices'){
		//Total Qutations
		$total= "select ifnull(count(*),0) as rows from ".$tblprefix."invoices  ";   
		// Count the number of Records query is goes here.$totalRows 
		$totalRows = $db->Execute($total) or die($db-ErrorMsg());
		$totalRows = $totalRows->fields['rows'] ;
		return $totalRows;
	}
	
		if($cType == 'companies'){
		//Total Qutations
		$total= "select ifnull(count(*),0) as rows from ".$tblprefix."companies  ";   
		// Count the number of Records query is goes here.$totalRows 
		$totalRows = $db->Execute($total) or die($db-ErrorMsg());
		$totalRows = $totalRows->fields['rows'] ;
		return $totalRows;
	}
	
	
 
}
//GETTING POPULAR  DESTINATION LIST
function MorrisChartData($tblprefix){
	global $db;
	  $sql_ind = "SELECT count(q.id) AS xitem1, 
						   DATE_FORMAT(q.datetime, '%Y-%m-%d') AS yitem
					  FROM ".$tblprefix."quote q
					 WHERE   q.datetime BETWEEN NOW() - INTERVAL 30 DAY AND NOW() 
					 GROUP BY DATE_FORMAT(q.datetime, '%Y-%m-%d')
					 ORDER BY DATE_FORMAT(q.datetime, '%Y-%m-%d') ASC"; 
	$rs_ind = $db->Execute($sql_ind);
	$isrs_ind = $rs_ind->RecordCount(); 
	$json_data=array();   
	if($isrs_ind>0){
		while (!$rs_ind->EOF){ 
			$json_array['yitem']= $rs_ind->fields['yitem'];  
			$json_array['xitem1']=$rs_ind->fields['xitem1'];  
			array_push($json_data,$json_array);  
			$rs_ind->MoveNext(); 
		} 	
	}
	
	echo json_encode($json_data);
}

 function getPageContent($tblprefix,$feild,$type){
	global $db;
 	$sql = "SELECT $feild FROM ".$tblprefix."pagecontent WHERE pagename = ".$db->qStr($type); 
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
	if($isrs > 0){
		return $rs->fields[$feild];
	}else{
		return 'No record found';
	}
}


function getData($tblprefix,$quote_id,$proposal_id){
	global $db;
	$and = "";
	if($quote_id){
		$and .= " and p.quote_id =".$db->qStr($quote_id);
	} 
	if($proposal_id){
		$and .= " and p.id =".$db->qStr($proposal_id);
	}
	$sqlp = "SELECT 
					q.id quote_id,
					q.cust_id,
					q.quote_no,
					q.category,
					q.launched_by,
					q.budget,
					q.description quote_description,
					q.status,
					q.datetime,
					q.status_updated_on,
					p.id proposal_id,
					p.cost,
					p.file,
					p.status proposal_status,
					c.id comp_id,
					c.cname,
					c.clogo,
					c.cemail,
					c.cphone_no,
					c.curl,
					c.address,
					c.description,
					c.pm_name,
					c.pm_email,
					c.pm_skype,
					c.pm_description,
					c.status comp_status,
					proj.id project_id,
					proj.title,
					proj.description project_description,
					proj.status project_status,
					proj.payment_status,
					proj.datetime project_datetime
				FROM
					".$tblprefix."quote q
						LEFT JOIN
					".$tblprefix."proposal p ON p.quote_id = q.id
						LEFT JOIN
					".$tblprefix."companies c ON c.id = p.comp_id
						LEFT JOIN
					".$tblprefix."projects proj ON proj.proposal_id = p.id 
					where 1=1 $and ";
	/*
				$sqlp="SELECT  p.id,
								p.cost,
								p.file,
								p.status,
								p.user_id,
								u.name user_name,
								p.datetime,
								c.cname,
								c.clogo,
								c.cemail,
								c.cphone_no,
								c.curl,
								c.address,
								c.description, 
								q.id quote_id, 
								q.quote_no,
								q.category,
								q.launched_by,
								q.budget,
								q.description quote_desc,
								q.status quote_status,
								q.datetime 
			  FROM ".$tblprefix."proposal p,".$tblprefix."quote q, ".$tblprefix."companies c, ".$tblprefix."users u
			 WHERE q.id = p.quote_id
			 and c.id = p.comp_id
			 and u.user_id = p.user_id
			 $and "; */
	$rsp=$db->Execute($sqlp);
	$isrsp=$rsp->RecordCount();
	if($isrsp > 0){
		return $rsp;	
	}else{
		return 0;
	}
	
}

function getCompany($tblprefix,$comp_id){
	global $db;
	$and = ""; 
	if($comp_id){
		$and .= " and c.id =".$db->qStr($comp_id);
	} 
 
	$sqlp = "SELECT  c.id comp_id,
					c.cname,
					c.clogo,
					c.cemail,
					c.cphone_no,
					c.curl,
					c.address,
					c.description,
					c.profile,
					c.pm_name,
					c.pm_email,
					c.pm_skype,
					c.pm_description,
					c.status comp_status 
				FROM  ".$tblprefix."companies c where 1=1 $and "; 
	$rsp=$db->Execute($sqlp);
	$isrsp=$rsp->RecordCount();
	if($isrsp > 0){
		return $rsp;	
	}else{
		return 0;
	}
	
}



function getInvoiceByProjectId($tblprefix,$project_id,$payment_status,$limit){
	global $db;
	$and = ""; 
	if($project_id){
		$and .= " and project_id =".$db->qStr($project_id);
	} 
	if($project_id){
		$and .= " and payment_status =".$db->qStr($payment_status);
	} 
  
	$sqlp = "SELECT id,
					project_id,
					inv_no,
					status,
					payment_status,
					description,
					inv_amout,
					due_date,
					vat,
					total,
					datetime,
					status_updated_on,
					TRANSACTIONID
			FROM ".$tblprefix."invoices
			WHERE 1=1 $and  $limit "; 
	$rsp=$db->Execute($sqlp);
	$isrsp=$rsp->RecordCount();
	if($isrsp > 0){
		return $rsp;	
	}else{
		return 0;
	}
	
}




function getProject($tblprefix,$quote_id,$proposal_id,$project_id){
	global $db;
	$and = "";
	if($quote_id){
		$and .= " and q.id =".$db->qStr($quote_id);
	}
	if($proposal_id){
		$and .= " and p.id =".$db->qStr($proposal_id);
	}
	if($project_id){
		$and .= " and proj.id =".$db->qStr($project_id);
	}
	$sqlp = "SELECT 
					q.id quote_id,
					q.cust_id,
					q.quote_no,
					q.category,
					q.launched_by,
					q.budget,
					q.description quote_description,
					q.status,
					q.datetime,
					q.status_updated_on,
					p.id proposal_id,
					p.cost,
					p.file,
					p.status proposal_status,
					c.id comp_id,
					c.cname,
					c.clogo,
					c.cemail,
					c.cphone_no,
					c.curl,
					c.address,
					c.description,
					c.pm_name,
					c.pm_email,
					c.pm_skype,
					c.pm_description,
					c.status comp_status,
					proj.id project_id,
					proj.title,
					proj.description project_description,
					proj.status project_status,
					proj.payment_status,
					proj.completion_date,
					proj.live_link, 
					proj.cost,
					proj.vat,
					proj.total,
					proj.TRANSACTIONID 
					
				FROM
					".$tblprefix."quote q
						 JOIN
					".$tblprefix."proposal p ON p.quote_id = q.id
						 JOIN
					".$tblprefix."companies c ON c.id = p.comp_id
						 JOIN
					".$tblprefix."projects proj ON proj.proposal_id = p.id 
					where 1=1 $and "; 
	$rsp=$db->Execute($sqlp);
	$isrsp=$rsp->RecordCount();
	if($isrsp > 0){
		return $rsp;	
	}else{
		return 0;
	}
	
}



function getInvoiceByProject($tblprefix,$project_id){
	global $db; 
 
	$sqlinv="SELECT * FROM ".$tblprefix."invoices   
					WHERE   project_id =".$db->qStr($project_id)." 
					order by  id asc";
	$rsinv=$db->Execute($sqlinv) or die($db->errorMsg());
	$isrsinv=$rsinv->RecordCount(); 
 
	if($isrsinv > 0){
		return $rsinv;	
	}else{
		return 0;
	}
	
}


function getQuoteNo($tblprefix){
	global $db;  
	$sqlinv="SELECT quote_no  FROM ".$tblprefix."quote    
					order by  id desc limit 0,1";
	$rsinv=$db->Execute($sqlinv) or die($db->errorMsg());
	$isrsinv=$rsinv->RecordCount(); 
 	if($isrsinv > 0){ 
		$nNo = str_replace(quoteprefix,"",$rsinv->fields['quote_no'])  + 1;
		$qno = quoteprefix.$nNo ;
	}else{ 
		$qno = quoteprefix.no_start;
	}
	 return $qno; 
}

function getInvNo($tblprefix){
	global $db;  
	$sqlinv="SELECT inv_no  FROM ".$tblprefix."invoices    
					order by  id desc limit 0,1";
	$rsinv=$db->Execute($sqlinv) or die($db->errorMsg());
	$isrsinv=$rsinv->RecordCount(); 
 	if($isrsinv > 0){
		$ino = invprefix.str_replace(invprefix,"",$rsinv->fields['inv_no'])  + 1 ;
	}else{
		$ino = invprefix.no_start;
	}
	 return $ino; 
}



// Function to convert NTP string to an array
function NVPToArray($NVPString)
{
	$proArray = array();
	while(strlen($NVPString))
	{
		// name
		$keypos= strpos($NVPString,'=');
		$keyval = substr($NVPString,0,$keypos);
		// value
		$valuepos = strpos($NVPString,'&') ? strpos($NVPString,'&'): strlen($NVPString);
		$valval = substr($NVPString,$keypos+1,$valuepos-$keypos-1);
		// decoding the respose
		$proArray[$keyval] = urldecode($valval);
		$NVPString = substr($NVPString,$valuepos+1,strlen($NVPString));
	}
	return $proArray;
}
function is_image($file)
{
	$return  = 0;
	$filename = strtolower(trim($file, '.')); 
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	$image_types = array('gif', 'jpg', 'jpeg', 'png', 'jpe');  
	if (in_array($ext, $image_types)) 
	{
	 	$return  = 1;
	} 
    return  $return;
}

function getCommunicationByQuote($tblprefix,$quoteId, $type){
	global $db;  
	$and = "";

	if( $type === "comminbox"){
		$and = " and from_id = 0";
	}
	if( $type === "communread"){
		$and = " and is_read = 'N'";
	}
	
	$qry_pm = "SELECT * FROM  ".$tblprefix."pm WHERE domain_id = " .$db->qStr($_SESSION['domain']);
	$rspm = $db->Execute($qry_pm);
	$isrspm=$rspm->RecordCount(); 
	if($isrspm>0){
		$pm_name 		= $rspm->fields["pm_name"]; 
		$pm_email 		= $rspm->fields["pm_email"]; 
		$pm_skype 		= $rspm->fields["pm_skype"]; 
		$pm_description = $rspm->fields["pm_description"]; 
		$logo			= $rspm->fields["logo"]; 
	}
	
	 $sqlComm="SELECT * FROM ".$tblprefix."communication 
		 WHERE quote_id = ".$db->qStr($quoteId)."  $and  order by  id asc";
		$rsComm=$db->Execute($sqlComm) or die($db->errorMsg());
		  $isrsComm=$rsComm->RecordCount();  
		if($isrsComm != 0){ 
			while(!$rsComm->EOF){ 
				$is_img = "";
				
				if($type === "commnew"){
					if($rsComm->fields["from_id"] == 0){
					?>
						<div class="sender">
						  <p>

							<?=nl2br($rsComm->fields["message"])?>
							<? if($rsComm->fields["file"] != ""){
								$is_img = is_image($rsComm->fields["file"]);
								?>
								<a href="<?=MYSURL?>uploads/communication/<?=$rsComm->fields["file"]?>" target="_blank">
									<? if($is_img === 1){
											?>
											<img src="<?=MYSURL?>uploads/communication/<?=$rsComm->fields["file"]?>" alt="" class="center-block img-responsive">  
											<?
										}else{
											?>
											<br />
											Download File
											<?
										}?>  
									</a>
								<?
							}?> 
						  </p>
						  <span><?=time_elapsed_string($rsComm->fields["datetime"]);?></span>
						</div>
					<?
				}else{
					?>
						<div class="reciever">
						  <p>

							<?=nl2br($rsComm->fields["message"])?>
							<? if($rsComm->fields["file"] != ""){
								$is_img = is_image($rsComm->fields["file"]);
								?>
								<a href="<?=MYSURL?>uploads/communication/<?=$rsComm->fields["file"]?>" target="_blank">
									<? if($is_img === 1){
											?>
											<img src="<?=MYSURL?>uploads/communication/<?=$rsComm->fields["file"]?>" alt="" class="center-block img-responsive">  
											<?
										}else{
											?>
											<br />
											Download File
											<?
										}?>  
									</a>
								<?
							}?> 
						  </p>
						  <span><?=time_elapsed_string($rsComm->fields["datetime"]);?></span>
						</div>
					<?
				} 
				}elseif($type === "comminbox"){ 
					?> 				  
					<div class="msg-content"> 
						<div class="msg-thumb"> 
					  <?  
					   if($logo != ""){ 
						?>
						 <img src="<?=MYSURL?>uploads/pm/<?=$logo?>" alt="<?php echo $pm_name;?>" class="center-block img-responsive"> 
					   <?	
						}
						?> 
						</div>
						<div class="msg-inbox">
						  <h5><?=$pm_name;?></h5>
						  <p><?=nl2br($rsComm->fields["message"])?>
						  <? if($rsComm->fields["file"] != ""){
								$is_img = is_image($rsComm->fields["file"]);
								?>
								<a href="<?=MYSURL?>uploads/communication/<?=$rsComm->fields["file"]?>" target="_blank">
									<? if($is_img === 1){
											?>
											<img src="<?=MYSURL?>uploads/communication/<?=$rsComm->fields["file"]?>" alt="" class="center-block img-responsive">  
											<?
										}else{
											?>
											<br />
											Download File
											<?
										}?>  
									</a>
								<?
							}?>
							</p>
						</div>
					  </div> 
					<?
				}elseif($type === "communread"){ 
					
					if($rsComm->fields["from_id"] != 0){ 
						$commName  = getName($tblprefix,"customer","fullname","id",$rsComm->fields["from_id"]);
						$commLogo = "";
					}else{
					    $commName  =$pm_name;
						$commLogo = $logo;
					}
					
					?> 		
					
					<div class="unread-sign">
						<i class="fa fa-asterisk" aria-hidden="true"></i>
					</div>
					<div class="unread-msg-box msg-content">
					<div class="msg-thumb">
					 <?  
					   if($commLogo != ""){ 
						?>
						 <img src="<?=MYSURL?>uploads/pm/<?=$commLogo?>" alt="<?php echo $commName;?>" class="center-block img-responsive"> 
					   <?	
						}
						?> 
					</div>
					<div class="msg-inbox">
						  <h5><?=$commName;?></h5>
						  <p><?=nl2br($rsComm->fields["message"])?>
						  <? if($rsComm->fields["file"] != ""){
								$is_img = is_image($rsComm->fields["file"]);
								?>
								<a href="<?=MYSURL?>uploads/communication/<?=$rsComm->fields["file"]?>" target="_blank">
									<? if($is_img === 1){
											?>
											<img src="<?=MYSURL?>uploads/communication/<?=$rsComm->fields["file"]?>" alt="" class="center-block img-responsive">  
											<?
										}else{
											?>
											<br />
											Download File
											<?
										}?>  
									</a>
								<?
							}?>
							</p>
						</div>
					</div> 		  		  		  
					  
					<?
				}elseif($type === "commall"){ 
					
					if($rsComm->fields["from_id"] != 0){ 
						$commName  = getName($tblprefix,"customer","fullname","id",$rsComm->fields["from_id"]);
						$commLogo = "";
					}else{
					    $commName  =$pm_name;
						$commLogo = $logo;
					}
					
					if($rsComm->fields["is_read"] === "N" ){
					?>
					<div class="unread-sign">
						<i class="fa fa-asterisk" aria-hidden="true"></i>
					</div>
					<div class="unread-msg-box msg-content">
					<div class="msg-thumb">
					 <?  
					   if($commLogo != ""){ 
						?>
						 <img src="<?=MYSURL?>uploads/pm/<?=$commLogo?>" alt="<?php echo $commName;?>" class="center-block img-responsive"> 
					   <?	
						}
						?> 
					</div>
					<div class="msg-inbox">
						  <h5><?=$commName;?></h5>
						  <p><?=nl2br($rsComm->fields["message"])?>
						  <? if($rsComm->fields["file"] != ""){
								$is_img = is_image($rsComm->fields["file"]);
								?>
								<a href="<?=MYSURL?>uploads/communication/<?=$rsComm->fields["file"]?>" target="_blank">
									<? if($is_img === 1){
											?>
											<img src="<?=MYSURL?>uploads/communication/<?=$rsComm->fields["file"]?>" alt="" class="center-block img-responsive">  
											<?
										}else{
											?>
											<br />
											Download File
											<?
										}?>  
									</a>
								<?
							}?>
							</p>
						</div>
					</div>
					<?
				}else{
					?>
					<div class="msg-content"> 
						<div class="msg-thumb"> 
					  <?  
					   if($commLogo != ""){ 
						?>
						 <img src="<?=MYSURL?>uploads/pm/<?=$commLogo?>" alt="<?php echo $commName;?>" class="center-block img-responsive"> 
					   <?	
						}
						?> 
						</div>
						<div class="msg-inbox">
						  <h5><?=$commName;?></h5>
						  <p><?=nl2br($rsComm->fields["message"])?>
						  <? if($rsComm->fields["file"] != ""){
								$is_img = is_image($rsComm->fields["file"]);
								?>
								<a href="<?=MYSURL?>uploads/communication/<?=$rsComm->fields["file"]?>" target="_blank">
									<? if($is_img === 1){
											?>
											<img src="<?=MYSURL?>uploads/communication/<?=$rsComm->fields["file"]?>" alt="" class="center-block img-responsive">  
											<?
										}else{
											?>
											<br />
											Download File
											<?
										}?>  
									</a>
								<?
							}?>
							</p>
						</div>
					  </div>
					<?
						
				} 
					?>
			<div class="clearfix"></div>
										<?
											}  
				
				
				
				$rsComm->MoveNext();
				} 
		} 
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}


function welcomeMsg($tblprefix,$quote_id,$cust_id){
	global $db;  
	$sqlinv="SELECT comm_msg  FROM ".$tblprefix."pm where domain_id = ".$db->qStr($_SESSION['domain']);
	$rsinv=$db->Execute($sqlinv) or die($db->errorMsg());
	$isrsinv=$rsinv->RecordCount(); 
 	if($isrsinv > 0){
		$datetime = date('Y-m-d H:i:s');
		$comm_msg = $rsinv->fields['comm_msg']; 
		$sqlinv="INSERT INTO ".$tblprefix."communication set 
		quote_id = ".$db->qStr($quote_id).", 
		from_id=0 , 
		to_id=".$db->qStr($cust_id)."
		,message = ".$db->qStr($comm_msg)."
		,datetime = ".$db->qStr($datetime);
		$rsinv=$db->Execute($sqlinv) or die($db->errorMsg());
		
	} 
}

//GETTING POPULAR  DESTINATION LIST
function Notifications($tblprefix,$cust_id){
	global $db;
    $sql_ind = "SELECT n.id,q.quote_no,n.description,n.type FROM ".$tblprefix."notifications n , ".$tblprefix."quote q 
	  WHERE n.quote_id = q.id and n.status = 'N' and n.cust_id = ".$db->qStr($cust_id); 
	$rs_ind = $db->Execute($sql_ind);
	$isrs_ind = $rs_ind->RecordCount(); 
	$json_data=array();   
	if($isrs_ind>0){
		?>
		<div class="dashboard-notification"> 
		<?
		while (!$rs_ind->EOF){ 
		 		?>
		 		<div class="alert alert-dismissible show custom-alert  <?=$rs_ind->fields["type"];?>-alert" role="alert">
				 <?php /*?> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
				  </button><?php */?>
					<h1>Quote No: <?=$rs_ind->fields["quote_no"];?></h1>
				  <?=$rs_ind->fields["description"];?>
					<div class="clearfix"></div>  
					<a href="" class="pull-right" data-dismiss="alert">close</a><a href="" class="pull-right">&nbsp;&nbsp;|&nbsp;&nbsp;</a>
				  <a href="" data-id="<?=$rs_ind->fields["id"];?>" data-dismiss="alert" class="notification-hide pull-right">hide</a>
				  <div class="clearfix"></div>  
				</div>
		 		<?
			$rs_ind->MoveNext(); 
		} 
		?>
		</div>
		<?
	} 
}




function getOrdersCount($tblprefix){
	global $db; 
	 $sql = "SELECT  count(1) cnt
				FROM
					".$tblprefix."orders  ";  
	$rs = $db->Execute($sql) or die($db->errorMsg());
	$isrs = $rs->RecordCount(); 
	return   $rs->fields["cnt"]; 
}

function getProductById($tblprefix, $prod_id,$size){
	global $db;
	$and = "";
	if($prod_id != ""){
		$and .= " and p.id = ".$db->qStr($prod_id);
	}
	if($size != ""){
		$size = cleanChar(sanitize(trim($size)));
		$and .= " and uf_only_digits(s.size) = ".$db->qStr($size);
	}
	$sql = "SELECT 
					p.id,
					p.EAN,
					p.description,
					p.category,
					s.id size_id,
					s.size,
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
					p.total_stk,
					p.featured,
					p.new_arrivel,
					p.discount,
					b.name brand,
					b.description brand_description,
					b.logo brand_logo
				FROM
					".$tblprefix."product p,
					".$tblprefix."brands b,
					".$tblprefix."size s
				WHERE
					p.brand_id = b.id AND p.size = s.id and p.local_stk > 0 and p.status = 'A' ".$and;  
	$rs = $db->Execute($sql) or die($db->errorMsg());
	$isrs = $rs->RecordCount(); 
	return($rs);  
}



function apiSize($size){
	return str_replace("/","", strtoupper(trim($size)));
}
function apiPostcode($postcode){
	return str_replace(" ","", strtoupper(trim($postcode)));
}

function getGoogleMap($lat,$lng){
	?>
	<div id="map" class="embed-responsive embed-responsive-16by9"></div>
	
    <script>

      function initMap() {
        var myLatLng = {lat: <?=$lat?>, lng: <?=$lng?>};

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
          center: myLatLng
        });

        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: 'Location'
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=<?=GOOGLEMAP?>&callback=initMap">
    </script>
	<?
}

function updatePostCodeAddress($tblprefix,$postcode_id,$postcode){
	global $db;
	$sql = "SELECT s.id FROM  ".$tblprefix."postcode_address s
				WHERE  s.postcode_id = ".$db->qStr(apiPostcode($postcode_id));  
	$rs = $db->Execute($sql) or die($db->errorMsg());
	$isrs = $rs->RecordCount(); 
	if($isrs === 0){ 
	
		$url = "https://uk1.ukvehicledata.co.uk/api/datapackage/PostcodeLookup?v=2&api_nullitems=1&auth_apikey=".VTD."&user_tag=&key_postcode=".$postcode; 
		
		$feed_xml = json_decode(file_get_contents($url));
		/*echo '<pre>';
		print_r($feed_xml->Response->DataItems->AddressDetails->AddressList);
		echo '<pre>';
		exit;*/
		$count = $feed_xml->Response->DataItems->AddressDetails->AddressCount;
		$baseDataArray = $feed_xml->Response->DataItems->AddressDetails->AddressList;
		for($i=0;$i<$count;$i++){
			$summary_address = $baseDataArray[$i]->SummaryAddress;
			$premises = $baseDataArray[$i]->FormattedAddressLines->Premises;
			$street = $baseDataArray[$i]->FormattedAddressLines->Street;
			$locality = $baseDataArray[$i]->FormattedAddressLines->Locality;
			$post_town = $baseDataArray[$i]->FormattedAddressLines->PostTown;
			
			$sqlinv="INSERT  INTO ".$tblprefix."postcode_address set 
											summary_address = ".$db->qStr($summary_address).",
											postcode_id = ".$db->qStr($postcode_id).", 
											premises=".$db->qStr($premises)." , 
											street=".$db->qStr($street)." , 
											locality=".$db->qStr($locality)." , 
											post_town=".$db->qStr($post_town); 
		   $rsinv = $db->Execute($sqlinv) or die($db->errorMsg());
			
		} 
	}
}

function getPostCodeId($tblprefix,$postcode){
	global $db;
	$postcode_id = 0;
	$sql = "SELECT s.id FROM  ".$tblprefix."postcode s
				WHERE  s.postcode = ".$db->qStr(apiPostcode($postcode));  
	$rs = $db->Execute($sql) or die($db->errorMsg());
	$isrs = $rs->RecordCount(); 
	if($isrs>0){ 
		 $postcode_id = $rs->fields["id"];  
	}else{
		
		$url = "https://maps.googleapis.com/maps/api/geocode/json?&address=".apiPostcode($postcode)."&key=".GOOGLEPOSTCODE; 
		$feed_xml = json_decode(file_get_contents($url)); 
 	 
		$status = $feed_xml->status;
		//if($status === "OK"){
		$address = $feed_xml->results[0]->formatted_address;
		$lat = $feed_xml->results[0]->geometry->location->lat;
		$lng = $feed_xml->results[0]->geometry->location->lng;

		$sqlinv="INSERT  INTO ".$tblprefix."postcode set 
													postcode = ".$db->qStr(apiPostcode($postcode)).",
													address = ".$db->qStr($address).",
													lat=".$db->qStr($lat)." , 
													lng=".$db->qStr($lng);
	   $rsinv = $db->Execute($sqlinv) or die($db->errorMsg());
	   $postcode_id = $db->insert_Id();
		//}
		
	}
	updatePostCodeAddress($tblprefix,$postcode_id,apiPostcode($postcode));
	return $postcode_id; 
}

function apiSizeUpdate($tblprefix,$api_size,$SectionWidth,$AspectRatio,$RimDiameter,$LoadIndex, $SpeedIndex, $RunFlat, $rim_size, $rim_offset,$bar, $psi){
	global $db;
	
	$sql = "SELECT s.id,s.is_api_updated FROM  ".$tblprefix."size s
				WHERE  s.size = ".$db->qStr(apiSize($api_size));  
	$rs = $db->Execute($sql) or die($db->errorMsg());
	$isrs = $rs->RecordCount(); 
	if($isrs>0){

		 $size_id 			= $rs->fields["id"];
		 $is_api_updated 	= $rs->fields["is_api_updated"];

		if($is_api_updated == "0"){

			$sqlinv="UPDATE ".$tblprefix."size set 
													api_size = ".$db->qStr($api_size).",  
													SectionWidth=".$db->qStr($SectionWidth)." , 
													AspectRatio=".$db->qStr($AspectRatio)." ,
													RimDiameter=".$db->qStr($RimDiameter)." ,
													LoadIndex=".$db->qStr($LoadIndex)." ,
													SpeedIndex=".$db->qStr($SpeedIndex)." ,
													RunFlat=".$db->qStr($RunFlat)." ,
													is_api_updated=".$db->qStr(1)." , 
													rim_size = ".$db->qStr($rim_size)." , 
													rim_offset = ".$db->qStr($rim_offset)." ,
													bar = ".$db->qStr($bar)." ,
													psi = ".$db->qStr($psi)." 
					where id = ".$db->qStr($size_id);
			$rsinv = $db->Execute($sqlinv) or die($db->errorMsg());
		}

	}else{
		$sqlinv="INSERT  INTO ".$tblprefix."size set 
													size = ".$db->qStr(apiSize($api_size)).",
													api_size = ".$db->qStr($api_size).",
													SectionWidth=".$db->qStr($SectionWidth)." , 
													AspectRatio=".$db->qStr($AspectRatio)." ,
													RimDiameter=".$db->qStr($RimDiameter)." ,
													LoadIndex=".$db->qStr($LoadIndex)." ,
													SpeedIndex=".$db->qStr($SpeedIndex)." ,
													RunFlat=".$db->qStr($RunFlat)." ,
													is_api_updated=".$db->qStr(1)." , 
													rim_size = ".$db->qStr($rim_size)." , 
													rim_offset = ".$db->qStr($rim_offset)." ,
													bar = ".$db->qStr($bar)." ,
													psi = ".$db->qStr($psi);
	   $rsinv = $db->Execute($sqlinv) or die($db->errorMsg());
	   $size_id = $db->insert_Id();
	}
	return $size_id; 
}

function getAPIDataByRegNo($tblprefix, $regNo){
	global $db;  
	$vrm_id  = 0;
	$datetime = date('Y-m-d H:i:s');
	$sql = "SELECT s.vrm_id  FROM  ".$tblprefix."vrm s
				WHERE  s.reg_no = ".$db->qStr(apiSize($regNo));  
	$rs = $db->Execute($sql) or die($db->errorMsg());
	$isrs = $rs->RecordCount(); 
	if($isrs>0){ 
		 $vrm_id 			= $rs->fields["vrm_id"];  
	}else{
		$url = "https://uk1.ukvehicledata.co.uk/api/datapackage/TyreData?v=2&api_nullitems=1&auth_apikey=".VTD."&user_tag=&key_VRM=".$regNo;
		$feed_xml = json_decode(file_get_contents($url));


		$baseDataArray = $feed_xml->Response->DataItems;
		$statusCode = $feed_xml->Response->StatusCode;

		$make = $baseDataArray->VehicleDetails->Make;
		$model = $baseDataArray->VehicleDetails->Model; 
		$buildYear = $baseDataArray->VehicleDetails->BuildYear;
		$tyreDetailsArr = $baseDataArray->TyreDetails->RecordList;


		$sqlinv="INSERT INTO ".$tblprefix."vrm set 
								reg_no = ".$db->qStr($regNo).",  
								make=".$db->qStr($make)." ,
								model = ".$db->qStr($model)." ,
								build_year = ".$db->qStr($buildYear)." ,
								datetime = ".$db->qStr($datetime);
		$rsinv = $db->Execute($sqlinv) or die($db->errorMsg());
		if($rsinv){
			$vrm_id = $db->insert_Id(); 
			if(count($tyreDetailsArr)>0){
				for($i=0;$i<count($tyreDetailsArr);$i++){
					 $tyreDetails = $tyreDetailsArr[$i];	 
					 $model_name = $tyreDetails->Vehicle->ModelName;

					 $CenterBore = $tyreDetails->Hub->CenterBore;
					 $PCD = $tyreDetails->Hub->PCD; 

					 $ThreadType = $tyreDetails->Fixing->ThreadType;
					 $HeadSize = $tyreDetails->Fixing->HeadSize;
					 $BoltLength = $tyreDetails->Fixing->BoltLength;
					 $Torque = $tyreDetails->Fixing->Torque;


					 $fsize = $tyreDetails->Front->Tyre->Size; 
					 $fSectionWidth = $tyreDetails->Front->Tyre->SectionWidth;
					 $fAspectRatio = $tyreDetails->Front->Tyre->AspectRatio;
					 $fRimDiameter = $tyreDetails->Front->Tyre->RimDiameter;
					 $fLoadIndex = $tyreDetails->Front->Tyre->LoadIndex;
					 $fSpeedIndex = $tyreDetails->Front->Tyre->SpeedIndex;
					 $fRunFlat = $tyreDetails->Front->Tyre->RunFlat;

					 $frim_size = $tyreDetails->Front->Rim->Size;
					 $frim_offset = $tyreDetails->Front->Rim->Offset;

					 $fbar = $tyreDetails->Front->Tyre->Pressure->Bar;
					 $fpsi = $tyreDetails->Front->Tyre->Pressure->Psi;



					 $rsize = $tyreDetails->Rear->Tyre->Size;
					 $rSectionWidth = $tyreDetails->Rear->Tyre->SectionWidth;
					 $rAspectRatio = $tyreDetails->Rear->Tyre->AspectRatio;
					 $rRimDiameter = $tyreDetails->Rear->Tyre->RimDiameter;
					 $rLoadIndex = $tyreDetails->Rear->Tyre->LoadIndex;
					 $rSpeedIndex = $tyreDetails->Rear->Tyre->SpeedIndex;
					 $rRunFlat = $tyreDetails->Rear->Tyre->RunFlat;

					 $rrim_size = $tyreDetails->Rear->Rim->Size;
					 $rrim_offset = $tyreDetails->Rear->Rim->Offset;

					 $rbar = $tyreDetails->Rear->Tyre->Pressure->Bar;
					 $rpsi = $tyreDetails->Rear->Tyre->Pressure->Psi;

					 $size_id = apiSizeUpdate($tblprefix,$fsize,$fSectionWidth,$fAspectRatio,$fRimDiameter,$fLoadIndex, $fSpeedIndex, $fRunFlat, $frim_size, $frim_offset,$fbar, $fpsi);

					 $ins="INSERT INTO ".$tblprefix."vrm_size set 
								vrm_id = ".$db->qStr($vrm_id).",  
								size_id=".$db->qStr($size_id)." ,
								model_name = ".$db->qStr($model_name)." ,
								type = ".$db->qStr("front")." , 
								CenterBore = ".$db->qStr($CenterBore)." ,
								PCD = ".$db->qStr($PCD)." ,
								ThreadType = ".$db->qStr($ThreadType)." ,
								HeadSize = ".$db->qStr($HeadSize)." , 
								BoltLength = ".$db->qStr($BoltLength)." ,  
								Torque = ".$db->qStr($Torque);
					 $execute = $db->Execute($ins) or die($db->errorMsg());	

					 if($fsize != $rsize){
						$rsize_id =  apiSizeUpdate($tblprefix,$rsize,$rSectionWidth,$rAspectRatio,$rRimDiameter,$rLoadIndex, $rSpeedIndex, $rRunFlat, $rrim_size, $rrim_offset,$rbar, $rpsi); 
						 
						  $ins="INSERT INTO ".$tblprefix."vrm_size set 
								vrm_id = ".$db->qStr($vrm_id).",  
								size_id=".$db->qStr($rsize_id)." ,
								model_name = ".$db->qStr($model_name)." ,
								type = ".$db->qStr("rear")." , 
								CenterBore = ".$db->qStr($CenterBore)." ,
								PCD = ".$db->qStr($PCD)." ,
								ThreadType = ".$db->qStr($ThreadType)." ,
								HeadSize = ".$db->qStr($HeadSize)." , 
								BoltLength = ".$db->qStr($BoltLength)." ,  
								Torque = ".$db->qStr($Torque);
					 	  $execute = $db->Execute($ins) or die($db->errorMsg());	
					 }  
				}
			} 
		}
	}
	return $vrm_id; 
		
}




if (!function_exists('array_column')) {
    function array_column(array $input, $columnKey, $indexKey = null) {
        $array = array();
        foreach ($input as $value) {
            if ( !array_key_exists($columnKey, $value)) {
                trigger_error("Key \"$columnKey\" does not exist in array");
                return false;
            }
            if (is_null($indexKey)) {
                $array[] = $value[$columnKey];
            }
            else {
                if ( !array_key_exists($indexKey, $value)) {
                    trigger_error("Key \"$indexKey\" does not exist in array");
                    return false;
                }
                if ( ! is_scalar($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not contain scalar value");
                    return false;
                }
                $array[$value[$indexKey]] = $value[$columnKey];
            }
        }
        return $array;
    }
}  
 

 function getRandProductImg($tblprefix, $product_id){
	global $db;
	$sql = "SELECT * FROM ".$tblprefix."product_img WHERE product_id = ".$db->qStr($product_id)." order by rand() limit 0,1";
	$rs = $db->Execute($sql);
	$isrs  = $rs->RecordCount();
	if($isrs > 0){ 
		return MYSURL.$rs->fields['image'];
	}else{ 
		return MYSURL."assets/img/default.jpg";
	}
}
 


?>