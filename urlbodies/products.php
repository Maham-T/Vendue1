<div class="content">
    <div class="container-fluid"> 
	<? 
	echo $content;	
	getmsg($tblprefix); 	 
	if($action === "add"){
	?> 
	<div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Add Product</h3> 
          </div>
          <!-- /.card-header -->
         <form name="frmprofile" role="form" action="" method="post" autocomplete = "off" enctype="multipart/form-data">
          <div class="card-body">  
           <div class="row">
             <div class="col-md-6">
                 <div class="form-group">
                  <label for="title">Title</label>
                  <input type="text" class="form-control" name="title" id="title" value="<?php echo stripslashes($rs->fields['title'])?>"  placeholder="Title"  title="Please enter title">
                 </div>
             </div>
             <div class="col-md-6">
               <div class="form-group">
                <label for="cat_id">Category</label>
                <?=GetSelectDropdownList($tblprefix, "category", "cat_id", "id","name", $rs->fields['cat_id'], "form-control select2bs4", "")?> 
               </div>
             </div> 
           </div> 
            <div class="row">
             <div class="col-md-6">
                <div class="form-group">
                  <label for="bid_start_price">Bid Start Price</label>
                  <input type="number" class="form-control" name="bid_start_price" id="bid_start_price" value="<?php echo stripslashes($rs->fields['bid_start_price'])?>"  placeholder="Bid Start Price"  title="Please enter Bid Start Price">
                 </div>
             </div>
             <div class="col-md-6">
                   <div class="form-group">
                  <label for="valid_till">Valid Till</label>
                  <input type="datetime-local" class="form-control" name="valid_till" id="valid_till" value="<?php echo stripslashes($rs->fields['valid_till'])?>"  placeholder="Valid Till"  title="Please enter valid till">
                 </div>
             </div>
           </div> 

           <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Description</label>
                <textarea class="textarea form-control" name="description" id="description"  rows="6"><?=$rs->fields['description'];?></textarea>
              </div>
            </div>
          </div> 
             

             <div class="form-group">
                  <label for="images">Images</label>
                  <input type="file" class="form-control" multiple  name="files[]" id="files"   placeholder="Title"  title="Please enter images">
                 </div>


            <div class="row">
              <div class="col-md-12">  
                  <button type="submit" name="AddOrUpdate" id="AddOrUpdate" class="btn   btn-success btn-flat">
                      <i class="fa fa-check"></i>  Save Changes </button>
                    <input type="hidden" name="id" value="<?=$id;?>" />
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
		 	 <form action="<?=MYSURL?>products" method="post" class="horizontal-form">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group no_margin"> 
                      <input type="text" class="form-control form-control-sm ui-autocomplete-input" name="keyword" id="keyword" placeholder="Search by keyword" value="<?=$_POST["keyword"]?>"  required autocomplete="off"> 
                    </div>
                  </div>
                  <div class="col-md-3">
                   <button class="btn btn-warning btn-flat btn-sm" name="search" id="search" type="submit"><i class="fa fa-search"></i>  Find</button>
                  </div>

                   <div class="col-md-3">
                     <? if($_SESSION["role_id"] == "2"){ ?>
                   	   <a href="<?=MYSURL.$_GET["page"]?>/add" class="btn float-right btn-flat btn-sm btn-warning"> Add New
          							<i class="fa fa-plus"></i>
          						</a> 
                    <? } ?>
                   </div>
                </div>
              </form>


         
          </div>
		<div class="card-body">
				
				<table class="table bg-white table-striped dataTables table-sm table-bordered table-hover table-checkable order-column" id="sample_1">
				<thead>
                <tr class="info">
                	<th class="text-center" width="8%">Action</th>
                    <th class="text-center" width="4%">#</th>
                     <? if($_SESSION["role_id"] == "1"){ ?>
                       <th width="10%">Posted By</th> 
                     <? } ?>
                    <th width="10%">Category</th> 
                    <th width="18%">Title</th>                    
                    <th width="10%">Start Price</th>  
                    <th width="10%">Winner Price</th>  
                    <th width="10%">Winner</th>
                    <th width="15%">Valid Till</th>
                    <th width="15%">Win Date</th>
                </tr>
              </thead>
              <tbody>
                <?php 
            $sn = 1;
            if($isrs > 0){
            while(!$rs->EOF){
            ?>    <!---------------COLOR LOOP STARTS------------> 
            <tr>
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
						</td> 

                  <td align="center"><?=$sn++?></td>
                  <? if($_SESSION["role_id"] == "1"){ ?>
                        <td><?php echo stripslashes($rs->fields["posted_by"]);?></td>
                     <? } ?>
                  <td><?php echo stripslashes($rs->fields["cat_name"]);?></td>
                  <td><?php echo stripslashes($rs->fields["title"]);?></td>
                  <td><?php echo amount_format($rs->fields["bid_start_price"]);?></td>
                  <td><?php echo amount_format($rs->fields["bid_winner_price"]);?></td>
                  <td><?php echo stripslashes($rs->fields["winner"]);?></td>  
                  <td><?php echo datetimeformat($rs->fields["valid_till"]);?></td>
                  <td><?php echo datetimeformat($rs->fields["win_date"]);?></td>                  
              </tr>
            <?php
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