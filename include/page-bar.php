<? if($_SESSION["login"]  == true) { ?>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
              <?=$heading?> 
             
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=MYSURL?>dashboard">Home</a></li>
              <li class="breadcrumb-item active"><?=$title?></li>
              <li class="breadcrumb-item">
                <? if($back == ""){  ?>
                <a href="#" onclick="history.back(-1)"><i class="fa fa-chevron-left"></i>  Back</a>
              <? 
              }else{
              ?>
              <a href="<?=MYSURL.$back;?>"><i class="fa fa-chevron-left"></i> Back</a>
              <?
              } 
              ?>

                 </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header --> 
    <? }else{
      ?>

        <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark"> <?=$heading?> 
              <small> <?=$sub_heading?></small></h1>
          </div><!-- /.col --> 
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header --><?
    }?>