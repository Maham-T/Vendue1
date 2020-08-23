<?php 
include("config/conn.php");  
//calling Base files
if($_GET['page']){
	$filename = $_GET['page'].'.php' ;
	if(file_exists('base/'.$filename.'')){
		include('base/'.$filename.'');
	}else{
		include('base/error.php');
	}
}else{
	
	if(file_exists('base/index.php')){
		include('base/index.php');
	}
} 
?> 
<!DOCTYPE html>
<html lang="en">
<?php
require_once("include/head.php"); 
?>  
  <body class="hold-transition <? if(!$_GET["page"]) { ?> layout-top-nav <? }elseif($_GET["page"] == "login"|| $_GET["page"] == "signup"){  ?> login-page  <? }else { ?>  sidebar-mini layout-fixed <? } ?>">  
	<?php 
		
		if($_GET['page'] == "login"){  
			require_once("urlbodies/login.php");			
		}else if($_GET['page'] == "signup"){  
			require_once("urlbodies/signup.php");	
		}elseif($_GET['page']){
			?>
		 	<div class="wrapper">
		 	<?
			require_once("include/header.php");				 
			require_once("include/sidebar.php");
			?>
			 <div class="content-wrapper"> 
					<?					
					require_once('include/page-bar.php');
					?>
					<section class="content">
					<?
					if(file_exists("urlbodies/".$filename)){
						include("urlbodies/".$filename);
					}else{
						include('urlbodies/error.php');
					}
					?>
					</section>
			</div>
			<?
			require_once("include/footer.php");
			?> 
			</div>
			<?
		}else{
			?>
		 	<div class="wrapper">
		 	<?
			require_once("include/header.php");		 
			?>
			 <div class="content-wrapper"> 
					<?					
					require_once('include/page-bar.php');
					?>
					<section class="content">
					<?
					//Calling Register Main Page
					include('urlbodies/indexbody.php');
					?>
					</section>
			</div>
			<?
			require_once("include/footer.php");
			?> 
			</div>
			<? 
		} 
		require_once("include/script.php");
    ?>   

    <div class="modal fade" id="DailogPan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="headingDialogPan"></h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div id="divDialogPan"></div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-flat btn-sm btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Close</button> 
	    </div>
	  </div>
	</div> 

</body>
</html>
