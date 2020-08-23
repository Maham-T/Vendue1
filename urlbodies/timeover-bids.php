<div class="content">
    <div class="container-fluid"> 
  <? 
  echo $content;  
  getmsg($tblprefix);     
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
                       <a href="<?=MYSURL.$_GET["page"]?>/add" class="btn float-right btn-flat btn-sm btn-warning"> <i class="fa fa-plus"></i> &nbsp;&nbsp;Add New
                       
                      </a> 
                    <? }elseif($_SESSION["role_id"] == "1"){
                      ?>
                       <a href="<?=MYSURL.$_GET["page"]?>/process" class="btn float-right btn-flat btn-sm btn-success"><i class="fas fa-cogs"></i>&nbsp;&nbsp;Process
                         
                      </a> 
                      <?
                    } ?>
                   </div>
                </div>
              </form>


         
          </div>
    <div class="card-body">
        
        <table class="table bg-white table-striped dataTables table-sm table-bordered table-hover table-checkable order-column" id="sample_1">
        <thead>
                <tr class="info"> 
                    <th class="text-center" width="4%">#</th>
                     <? if($_SESSION["role_id"] == "1"){ ?>
                       <th width="10%">Posted By</th> 
                     <? } ?>
                    <th width="10%">Category</th> 
                    <th width="18%">Title</th>                    
                    <th width="10%">Start Price</th>   
                    <th width="15%">Valid Till</th> 
                </tr>
              </thead>
              <tbody>
                <?php 
            $sn = 1;
            if($isrs > 0){
            while(!$rs->EOF){
            ?>    <!---------------COLOR LOOP STARTS------------> 
            <tr> 
                  <td align="center"><?=$sn++?></td>
                  <? if($_SESSION["role_id"] == "1"){ ?>
                        <td><?php echo stripslashes($rs->fields["posted_by"]);?></td>
                     <? } ?>
                  <td><?php echo stripslashes($rs->fields["cat_name"]);?></td>
                  <td><?php echo stripslashes($rs->fields["title"]);?></td>
                  <td><?php echo amount_format($rs->fields["bid_start_price"]);?></td> 
                  <td><?php echo datetimeformat($rs->fields["valid_till"]);?></td>              
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
  </div>
</div> 