<div class="content">
    <div class="container-fluid"> 
	<? 
	echo $content;	
	getmsg($tblprefix); 	 
	if($action === "add"){ 
	?> 
	<div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Add/Update User</h3> 
          </div>
          <!-- /.card-header -->
            <form name="frmprofile" role="form" action="" method="post" autocomplete = "off" enctype="multipart/form-data">
          <div class="card-body">  
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="size">Role</label>
							<?=GetSelectDropdownList($tblprefix, "roles", "role_id", "role_id","role_lable", $rs->fields['role_id'], "form-control select2 required_field", "required")?> 
						   </div>
					</div> 
				</div>   
				<div class="row"> 
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Name</label>
							<input class="form-control required_field" required id="name" type="text" value="<?=$rs->fields['name'];?>" placeholder="Name" name="name" />  							
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Username</label>
							<input class="form-control required_field" <?=$readonly?>  required id="email" type="text" value="<?=$rs->fields['email'];?>" placeholder="Username" name="email" />  							
						</div>
					</div>
				</div>  
   
                <div class="row">
                    <div class="col-md-12">  
                        <button type="submit" name="AddOrUpdate" id="AddOrUpdate" class="btn   btn-success btn-flat">
                            <i class="fa fa-check"></i>  Save Changes </button>

                          <input type="hidden" name="id" value="<?=$rs->fields['id'];?>" /> 
                            <a  href="<?=MYSURL.$_GET['page']?>" class="btn btn-default btn-flat"><i class="fa fa-window-close"></i> Cancel</a>
                    </div> 
                    </div>
          </div>
          </form> 
        </div>
 
	<?
	}else{
	?>  
	<div class="card card-default">
		 <div class="card-header">
		 	<span>User Default Password: VS12345</span>
            <a href="<?=MYSURL.$_GET["page"]?>/add" class="btn float-right btn-flat btn-sm btn-warning"> Add New
				<i class="fa fa-plus"></i>
			</a> 
          </div>
		<div class="card-body">

				<table class="table bg-white table-striped dataTables table-sm table-bordered table-hover table-checkable order-column" id="sample_1">
				<thead>
					<tr> 
						<th width="10%" class="text-center"> Action </th> 
						<th width="3%" class="text-center"> # </th>	 
						<th width="55%"> Name </th>
						<th width="15%"> Username </th>
						<th width="17%"> Role </th>  
					</tr>
				</thead>
				<tbody>
					<? 
	  				if($isrs > 0) {
						$count = 1;
						while(!$rs->EOF){ 
					?>
					<tr class="odd gradeX"> 

						<td class="text-center"> 
							<a href="<?=MYSURL.$_GET["page"]?>/delete/<?=base64_encode($rs->fields['id']);?>" onClick="return confirm('Are you sure? You want to delete record.')" class="font-red-thunderbird" title="Delete"> 
								<i class="far fa-trash-alt text-red"></i>
							</a>
							<span class="text-gray">|</span>
							<a href="<?=MYSURL.$_GET["page"]?>/add/<?=base64_encode($rs->fields['id']);?>" class="font-green-jungle" title="Edit"> 
								<i class="fa fa-edit text-info"></i>
							</a> 
							<? 
							if($rs->fields['status'] == "A"){
								$newStatus = "I";
								$statusClass = "text-green";
								$statusTitle = "Active";
							}else{
								$newStatus = "A";
								$statusClass = "text-gray";
								$statusTitle = "In-Active";
							}
							?>
							<span class="text-gray">|</span>
							<a href="<?=MYSURL.$_GET["page"]?>/status/<?=base64_encode($rs->fields['id']);?>/<?=base64_encode($newStatus);?>" onClick="return confirm('Are you sure? You want to change record status.')" class="<?=$statusClass?>" title="<?=$statusTitle?>"> 
								<i class="fa fa-eye bold"></i>
							</a>
							<span class="text-gray">|</span>
							<a href="<?=MYSURL.$_GET["page"]?>/resetpassword/<?=base64_encode($rs->fields['id']);?>/<?=base64_encode($newStatus);?>" onClick="return confirm('Are you sure? You want to reset password.')"  title="Reset password" class="text-warning"> 
								<i class="fas fa-retweet"></i>
							</a>
						</td> 
						<td class="text-center"> <?=$count++;?> </td>  
						<td> <?=$rs->fields['name'];?> </td>
						<td> <?=$rs->fields['email'];?> </td>
						<td> <?=$rs->fields['role_lable'];?> </td> 
					</tr>
					<? 
							$rs->MoveNext();
						}
					}
					?> 
				</tbody>
			</table> 
 </div>
  </div>
	<? } ?> 
	</div>
</div> 