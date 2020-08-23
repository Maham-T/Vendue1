
<? 
	$_SESSION["MANU"] = array(); 
	array_push($_SESSION["MANU"],'my-profile');
	array_push($_SESSION["MANU"],'dashboard');

	// if($_SESSION['flag'] == 1){
	// $sqlm = "SELECT * FROM ".$tblprefix."menus 
	// 				WHERE parent_id = 0 and status = 'A' ORDER BY sort ASC ";	
	// }else{
	$sqlm = "SELECT * FROM ".$tblprefix."menus 
					WHERE parent_id = 0 and status = 'A' and menu_id in 
						(SELECT menu_id FROM ".$tblprefix."roles_menus WHERE role_id = ".$_SESSION["role_id"].") 
						ORDER BY sort ASC";
	//}
	$rsm = $db->Execute($sqlm);
	$isrsm = $rsm->RecordCount();
	if($isrsm > 0){ 

		if($_SESSION['role_id'] == 2){
			array_push($_SESSION["MANU"],"company");
      array_push($_SESSION["MANU"],"branch");
		}
		array_push($_SESSION["MANU"],"order");
    array_push($_SESSION["MANU"],"purchase");
?>


  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=MYSURL?>dashboard" class="brand-link">
      <img src="<?=MYSURL?>assets/img/ilogo.png" alt="<?=COMPANY_NAME?>" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light"><?=COMPANY_NAME?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar"> 
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <? 
                while(!$rsm->EOF){ 
                  // if($_SESSION['flag'] == 1){
                  // $sql_sub = "SELECT * FROM ".$tblprefix."menus 
                  //        WHERE parent_id = '".$rsm->fields["menu_id"]."' ORDER BY sort ASC";
                  // }else{
                  $sql_sub = "SELECT * FROM ".$tblprefix."menus 
                          WHERE parent_id = '".$rsm->fields["menu_id"]."' and status = 'A' and menu_id in 
                          (SELECT menu_id FROM ".$tblprefix."roles_menus WHERE role_id = ".$_SESSION["role_id"].") 
                          ORDER BY sort ASC";
                  //}     
                  $rs_sub = $db->Execute($sql_sub);
                  $isrs_sub = $rs_sub->RecordCount();
                  $parentId = getMenuParentIdByPage($tblprefix,$_GET["page"]);
                ?> 

                  <li class="nav-item  <? if(($rsm->fields["menu_id"] == $parentId) or  ($rsm->fields["menu_action"] == $_GET["page"])){?> has-treeview menu-open<? } ?> ">
                      <a href="<?=MYSURL.$rsm->fields["menu_action"]?>" class="nav-link">
                        <i class="nav-icon <?=$rsm->fields["icon"]?>"></i>
                        <p>
                        <?=$rsm->fields["menu_lable"]?>
                        <? 
                        if($rsm->fields["menu_action"] == ""){
                        ?>
                        <i class="right fas fa-angle-left"></i>
                          <span class="arrow <? if($rsm->fields["menu_id"] == $parentId){?> open <? } ?>"></span>
                        <?
                        }else{
                          
                          array_push($_SESSION["MANU"],$rsm->fields["menu_action"]);
                        }
                        ?> 
                        
                        </p>   
                    </a>

                    <?
                    if($isrs_sub>0){
                    ?>   <ul class="nav nav-treeview">
                      <?
                      while(!$rs_sub->EOF){
                        array_push($_SESSION["MANU"],$rs_sub->fields["menu_action"]);
                      ?>
                      <li class="nav-item">
                        <a href="<?=MYSURL.$rs_sub->fields["menu_action"]?>" class="nav-link "> 
                           <i class="<?=$rs_sub->fields["icon"]?> nav-icon"></i>
                          <p><?=$rs_sub->fields["menu_lable"]?></p>
                        </a>
                      </li>
                      <? 
                      $rs_sub->MoveNext();
                      } 
                      ?>  
                    </ul>
                    <?
                    }
                    ?>   
                  </li>  
                <? 
                $rsm->MoveNext();          
                } 
                ?>   
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside> 
 
<? } ?>