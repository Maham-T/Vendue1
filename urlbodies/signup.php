
<div class="login-box">
 
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <div class="row mb-3 justify-content-center">
        <div class="col-md-10"> 
        <div class="login-logo">
          <a href="<?=MYSURL?>"><img class="img-fluid" src="<?=MYSURL?>assets/img/logo.png" alt="signup" /></a>
        </div>
      </div>
      </div>
       
      <form action="" method="post">
      	<?=getmsg($tblprefix);?>
        <div class="input-group mb-3">
          <input type="text" class="form-control" autocomplete="off" placeholder="Name" name="username" id="username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
		 <div class="input-group mb-3">
          <input type="text" class="form-control" autocomplete="off" placeholder="Email" name="email" id="email	" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
		<div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Confirm password" name="Cpassword" id="Cpassword" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
<div >
<div class="custom-control custom-radio">
  <input type="radio" class="custom-control-input" id="defaultUnchecked" id="userType1" value="2" name="userType">
  <label class="custom-control-label" for="defaultUnchecked">Seller</label>
</div>

<div class="custom-control custom-radio">
  <input type="radio" class="custom-control-input" value="3" id="defaultChecked" id="userType2" name="userType" checked>
  <label class="custom-control-label" for="defaultChecked">Bidder</label>
</div>
</div>
        </div>
        <div style="padding-left:20px;" class="row">
          <div class="col-7">
          
          </div>
          <!-- /.col -->
          <div style="padding:0px 0px 20px 20px;" class="col-4">
            <button type="submit" name="login" id="login"  class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form> 
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box --> 