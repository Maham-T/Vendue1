<?	 
	//CHECKING LOGIN STATUS (IF NOT REDIRECTED TO HOME)
	require_once('login_checker.php');
	include("base/getcontent.php");
	$title = $_SESSION["name"];
 	$heading = $_SESSION["name"];  
	 
?>
	