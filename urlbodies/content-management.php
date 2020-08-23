<div class="content">
    <div class="container-fluid"> 
	<? 
	echo $content;	
	getmsg($tblprefix); 	 
	if($action === "update"){
	?>


	<div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Update Content</h3> 
          </div>
          <!-- /.card-header -->
          <form action="#" method="post" class="horizontal-form">
          <div class="card-body">
            <div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Page Name</label>
							<input class="form-control" readonly id="pagename" type="text" value="<?=$rs->fields['pagename'];?>" placeholder="Page Name" name="pagename" />  							
						</div>
					</div>
					<!--/span-->
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Page Title</label>
							<input class="form-control" id="page_title" type="text" value="<?=$rs->fields['page_title'];?>" placeholder="Page Title" name="page_title" />  							
						</div>
					</div>
					<!--/span-->
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Page Heading</label>
							<input class="form-control" id="page_heading" type="text" value="<?=$rs->fields['page_heading'];?>" placeholder="Page Heading" name="page_heading" />  							
						</div>
					</div>
					<!--/span-->
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Page Sub Heading</label>
							<input class="form-control" id="page_subheading" type="text" value="<?=$rs->fields['page_subheading'];?>" placeholder="Page Sub Heading" name="page_subheading" />  							
						</div>
					</div>
					<!--/span-->
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Keyword</label>
							<textarea class="form-control" id="meta_keyword" placeholder="Page Keyword" name="meta_keyword"><?=$rs->fields['meta_keyword'];?></textarea> 
						</div>
					</div>
					<!--/span-->
					<div class="col-md-6">						
						<div class="form-group">
							<label class="control-label">Meta Phrase</label>
							<textarea class="form-control" id="meta_phrase" placeholder="Meta Phrase" name="meta_phrase"><?=$rs->fields['meta_phrase'];?></textarea> 							
						</div>
					</div>
					<!--/span-->
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label">Page Content</label>
				 			<textarea class="textarea form-control" name="meta_description" id="meta_description" rows="6"><?=$rs->fields['meta_description'];?></textarea>
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
						<th width="20%"> Page Name </th>
						<th width="35%"> Page Title </th>
						<th width="35%"> Heading </th>
						
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
						<td> <?=$rs->fields['pagename'];?> </td>
						<td>
							<?=$rs->fields['page_title'];?>
						</td>
						<td>
							<?=$rs->fields['page_heading'];?>
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


 