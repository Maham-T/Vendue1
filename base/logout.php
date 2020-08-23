<?
 		unset($_SESSION['login']);
		unset($_SESSION['id']);
		unset($_SESSION['company_id']);
		unset($_SESSION['name']);
		unset($_SESSION['role_id']);
		unset($_SESSION['role']);
		unset($_SESSION['status']);
		unset($_SESSION['email']);
		unset($_SESSION['password']);
		unset($_SESSION['flag']);
		unset($_SESSION['MANU']);
 
 		

		$_SESSION["login"] 			=  	""; 
		$_SESSION["id"] 			=	""; 
		$_SESSION["company_id"] 	=	""; 
		$_SESSION["name"] 			=	""; 
		$_SESSION["role_id"] 		=	""; 
		$_SESSION["role"] 			=	""; 
		$_SESSION["status"] 		=	""; 
		$_SESSION["email"] 			=	""; 
		$_SESSION["password"] 		=	""; 
		$_SESSION["flag"] 			=	""; 
		$_SESSION['MANU']			= 	"";
	
	 	
  	 	session_destroy();
		session_start(); 
		$_SESSION['type'] = "success";	
		$_SESSION['msg'] = 'logout';
		header("Location:".MYSURL."login");
		exit();
?>