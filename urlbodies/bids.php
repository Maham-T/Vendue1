 <!-- Main content -->
    <div class="content">
      <div class="container">
        <? if($isrs > 0){ ?>
         <div class="row">
          <? if($id > 0){  
             $image = getRandProductImg($tblprefix, $rs->fields["id"]); 
           ?>
             <div class="col-md-12">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
                <div class="user-block"> 
                  <span class="username"><a href="<?=MYSURL.$_GET["page"]?>/<?=$rs->fields["id"]?>"><?=$rs->fields["posted_by"]?></a></span>
                  <span class="description">Posted - <?=time_elapsed_string($rs->fields["created_on"])?></span>
                </div>
                <!-- /.user-block --> 
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-toggle="tooltip" title=" <?=$rs->fields["cat_name"]?>">
                    <i class="far fa-circle"></i> <?=$rs->fields["cat_name"]?></button> 
                    <br>
                    <span class="float-right text-muted" id="countDown_<?=$rs->fields["id"]?>"></span>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6"><a href="<?=MYSURL.$_GET["page"]?>/<?=$rs->fields["id"]?>"><img class="img-fluid pad" src="<?=$image?>" alt="<?=$rs->fields["title"]?>"></a></div>
                   <div class="col-md-6"> <h2><?=$rs->fields["title"]?></h2>

                    <table class="table bg-white table-striped table-sm table-bordered table-hover table-checkable order-column" id="sample_1">
                      <thead>
                              <tr class="info"> 
                                  <th class="text-center" width="4%">#</th>  
                                  <th width="10%">Bid By</th> 
                                  <th width="18%">Date/Time</th>                    
                                  <th width="10%">Bid Value</th>   
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
                          $sn = 1;
                          if($isrsbid > 0){
                          while(!$rsbid->EOF){
                          ?>    <!---------------COLOR LOOP STARTS------------> 
                          <tr> 
                                <td align="center"><?=$sn++?></td> 
                                <td><?php echo stripslashes($rsbid->fields["posted_by"]);?></td>
                                <td><?php echo datetimeformat($rsbid->fields["bid_datetime"]);?></td> 
                                <td><?php echo amount_format($rsbid->fields["bid_val"]);?></td>        
                            </tr>
                          <?php
                          $rsbid->MoveNext();
                          }
                          }else{
                            ?>
                             <tr> 
                                <td align="center" colspan="4">No bid found</td>          
                            </tr>
                            <?
                          } 
                          ?>
                            </tbody> 
                    </table> 

                   </div>
                </div> 
                
              </div>
              <!-- /.card-body -->  
            </div>
            <!-- /.card -->
          </div> 
          <!-- /.col --> 
          <script type="text/javascript">  
              var eleId = 'countDown_<?=$rs->fields["id"]?>';
              var dateTime = "<?=datetimeformatforcounter($rs->fields["valid_till"])?>";
              var countDownDate = new Date(dateTime).getTime();

              // Update the count down every 1 second
              var x = setInterval(function() {

                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Display the result in the element with id="demo"
                document.getElementById(eleId).innerHTML = days + "d " + hours + "h "
                + minutes + "m " + seconds + "s ";

                // If the count down is finished, write some text
                if (distance < 0) {
                  clearInterval(x);
                  document.getElementById(eleId).innerHTML = "EXPIRED";
                }
              }, 1000);

          </script>
            <?


           }else{ 
           while(!$rs->EOF){ 
            $image = getRandProductImg($tblprefix, $rs->fields["id"]);            
           ?>
          <div class="col-md-6">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
                <div class="user-block"> 
                  <span class="username"><a href="<?=MYSURL.$_GET["page"]?>/<?=$rs->fields["id"]?>"><?=$rs->fields["posted_by"]?></a></span>
                  <span class="description">Posted - <?=time_elapsed_string($rs->fields["created_on"])?></span>
                </div>
                <!-- /.user-block --> 
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-toggle="tooltip" title=" <?=$rs->fields["cat_name"]?>">
                    <i class="far fa-circle"></i> <?=$rs->fields["cat_name"]?></button> 
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="<?=MYSURL.$_GET["page"]?>/<?=$rs->fields["id"]?>"><img class="img-fluid pad" src="<?=$image?>" alt="<?=$rs->fields["title"]?>"></a>

                <p class="mt-2"><?=$rs->fields["title"]?></p> 
                <a href="<?=MYSURL.$_GET["page"]?>/<?=$rs->fields["id"]?>" class="btn btn-default btn-sm"><i class="far fa-thumbs-up"></i>&nbsp;&nbsp;bids Participation</a>
                <span class="float-right text-muted" id="countDown_<?=$rs->fields["id"]?>"></span>
              </div>
              <!-- /.card-body -->  
            </div>
            <!-- /.card -->
          </div> 
          <!-- /.col --> 
          <script type="text/javascript">  
              var eleId = 'countDown_<?=$rs->fields["id"]?>';
              var dateTime = "<?=datetimeformatforcounter($rs->fields["valid_till"])?>";
              var countDownDate = new Date(dateTime).getTime();

              // Update the count down every 1 second
              var x = setInterval(function() {

                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Display the result in the element with id="demo"
                document.getElementById(eleId).innerHTML = days + "d " + hours + "h "
                + minutes + "m " + seconds + "s ";

                // If the count down is finished, write some text
                if (distance < 0) {
                  clearInterval(x);
                  document.getElementById(eleId).innerHTML = "EXPIRED";
                }
              }, 1000);

          </script>
        <? 
         $rs->MoveNext();
        } 
        }
        ?> 
        </div>
      <? } ?>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->