<div class="content">
    <div class="container-fluid">
        <?
        echo $content;  
        getmsg($tblprefix);
        ?> 
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Personal Information</h3> 
          </div>
          <!-- /.card-header -->
          <form action="#" method="post" class="horizontal-form">
          <div class="card-body">
            <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Full Name</label>
                            <input class="form-control" required id="name" type="text" value="<?=$_SESSION["name"]?>" placeholder="Full Name" name="name" />  
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input class="form-control" readonly id="email" type="text" value="<?=$_SESSION["email"]?>" placeholder="Email" name="email" />                             
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Status</label>
                            <input class="form-control" readonly id="status" type="text" value="<?=$_SESSION["status"]?>" placeholder="Status" name="status" />  
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Role</label>
                            <input class="form-control" readonly id="role" type="text" value="<?=$_SESSION["role"]?>" placeholder="Role" name="role" />                             
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <div class="row">
                    <div class="col-md-12">  
                        <button type="submit" name="profile_update" id="profile_update" class="btn   btn-success btn-flat">
                            <i class="fa fa-check"></i>  Save Changes </button>
                           <input type="hidden" name="id" value="<?=$_SESSION["id"]?>" /> 
                            <a  href="<?=MYSURL.$_GET['page']?>" class="btn   btn-default btn-flat"><i class="fa fa-window-close"></i> Cancel</a>
                    </div> 
                    </div>
          </div>
          </form> 
        </div>

        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Change password</h3> 
          </div>
          <!-- /.card-header -->
          <form action="#" method="post" class="horizontal-form">
          <div class="card-body">
            <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Old password</label>
                            <input class="form-control" id="cpassword" type="password" placeholder="Old password" name="cpassword" />  
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">New password</label>
                            <input class="form-control" id="password" type="password" placeholder="New password" name="password" />                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Confirm new password</label>
                            <input class="form-control" id="rpassword" type="password" placeholder="Re-type Your New Password" name="rpassword" />  
                        </div>
                    </div>
                    <!--/span-->
                </div> 
                <div class="row">
                    <div class="col-md-12">  
                        <input type="hidden" name="changepassword" value="changepassword" />
                         <input type="hidden" name="id" value="<?=$_SESSION["id"]?>" />
                        <button type="submit" name="ch_update" id="ch_update" class="btn   btn-success btn-flat"> 
                            <i class="fa fa-check"></i>  Save Changes </button> 
                            <a  href="<?=MYSURL.$_GET['page']?>" class="btn   btn-default btn-flat"><i class="fa fa-window-close"></i> Cancel</a>
                    </div> 
                    </div>
          </div>
          </form> 
        </div>
    </div>
</div>
  