<?php
include("base/getcontent.php");   

if(isset($_POST['login'])){
 		sanitize($_POST); 	
		$username	=  strtolower(sanitize($_POST['username']));
		$password	=  password(sanitize($_POST['password']));   
			
 		$sql_user ="SELECT u.id, 
							u.name,
							u.email,
							u.password,
							case when  u.status = 'A' then 'Active' else 'In-active' end status,
							u.role_id,
							u.flag,
							u.role_id, 
							r.role_lable role
					FROM ".$tblprefix."users u
					JOIN ".$tblprefix."roles r ON u.role_id = r.role_id 
					WHERE  lower(u.email) = ".$db->qStr($username)."
					AND u.password = ".$db->qStr($password);  
		$rs_user = $db->Execute($sql_user) or die($db->errorMsg());
		$isrs_user = $rs_user->RecordCount(); 
		if($isrs_user > 0){
			
			if($rs_user->fields['status'] != "Active"){
				$_SESSION['type'] = "danger";	
				$_SESSION['msg'] = 'inactiveuser'; 
				header("Location:".MYSURL."login");
				exit;
			}
			
		    $_SESSION["login"] 			=  	true; 
			$_SESSION["id"] 			=	$rs_user->fields['id'];  
			$_SESSION["name"] 			=	$rs_user->fields['name'];  
			$_SESSION["role_id"] 		=	$rs_user->fields['role_id'];  
			$_SESSION["role"] 			=	$rs_user->fields['role'];  
			$_SESSION["status"] 		=	$rs_user->fields['status']; 
			$_SESSION["email"] 			=	$rs_user->fields['email']; 
			$_SESSION["password"] 		=	$rs_user->fields['password']; 
			$_SESSION["flag"] 			=	$rs_user->fields['flag']; 
			
		 
		 	if($_POST['keep'] == 'yes'){
				 $keep = 'yes';
			}else{
				 $keep = 'no';
			}
			if($keep == 'yes'){
				$fourweeks = 60 * 60 * 24 * 28 + time();
				$cookiedata = '';
				setcookie('loggedin', "$cookiedata", "$fourweeks", "/", ".".MYSURL);
	
				$fourweeks = 60 * 60 * 24 * 28 + time();
				$username = $username;
				$password = sanitize($_POST['password']);
				$keep = sanitize($_POST['keep']);
				setcookie('username', "$username", "$fourweeks", "/", ".".MYSURL);
				setcookie('password', "$password", "$fourweeks", "/", ".".MYSURL);
				setcookie('keep', "$keep", "$fourweeks", "/", ".".MYSURL);
			} 
			header("Location:".MYSURL."dashboard");exit;
		}else{
			$_SESSION['type'] = "danger";	
			$_SESSION['msg'] = 'invalidlogin'; 
			header("Location:".MYSURL."login");exit;
		} 
		
  } 
?>