<div class="content">
    <div class="container-fluid"> 
	<? 
	echo $content;	
	getmsg($tblprefix); 	 
	if($action === "update"){
	?> 
	<div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Update Email Template<</h3> 
          </div>
          <!-- /.card-header -->
          <form action="#" method="post" class="horizontal-form">
          <div class="card-body"> 

            <div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label">Subject</label>
							<input class="form-control" required id="subject" type="text" value="<?=$rs->fields['subject'];?>" placeholder="Subject" name="subject" />  							
						</div>
					</div> 
				</div>  
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label">Email Body</label>
				 			<textarea class="textarea form-control" name="email_body" id="email_body" rows="6"><?=$rs->fields['email_body'];?></textarea>
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
		<div class="card-body"> 
			<table class="table bg-white table-striped dataTables table-sm table-bordered table-hover table-checkable order-column" id="sample_1">
				<thead>
					<tr> 
						<th width="7%" class="text-center"> Action </th> 
						<th width="3%" class="text-center"> # </th>	
						<th width="20%"> Type </th>
						<th width="70%"> Subject </th> 						
					</tr>
				</thead>
				<tbody>
					<? 
	  				if($isrs > 0) {
						$count = 1;
						while(!$rs->EOF){ 
					?>
					<tr class="odd gradeX"> 
						<td class="text-center"> <a href="<?=MYSURL.$_GET["page"]?>/update/<?=base64_encode($rs->fields['id']);?>"> <i class="fa fa-edit"></i></a> </td>
						<td class="text-center"> <?=$count++;?> </td>
						<td> <?=$rs->fields['email_type'];?> </td>
						<td>
							<?=$rs->fields['subject'];?>
						</td>  
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


 