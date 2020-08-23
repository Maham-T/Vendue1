<div class="login-box">
 
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <div class="row mb-3 justify-content-center">
        <div class="col-md-10"> 
        <div class="signup-logo">
          <a href="<?=MYSURL?>"><img class="img-fluid" src="<?=MYSURL?>assets/img/logo.png" alt="<?=COMPANY_NAME?>" /></a>
        </div>
      </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <h1><?=$heading?></h1>
        <?=$content?>     
        </div>
      </div>
      <form action="" method="post">
      	<? 
	 	getmsg($tblprefix);
		?>
        <div class="input-group mb-3">
          <input type="text" class="form-control" autocomplete="off" placeholder="Username" name="username" id="username" required>
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
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div style="padding-top:20px;" class="col-4">
            <button type="submit" name="login" id="login"  class="btn btn-primary btn-block">Log In</button>
          </div>
		  
          <!-- /.col -->
        </div>
      </form> 
    </div>
	<div style="padding:1px 20px 20px 235px; color:grey;  " >
            <h6 style="text-align: center;">Register Now</h6><a href="signup"><button type="submit" name="signup" id="Signup"  class="btn btn-primary btn-block">Sign Up</button></a>
          </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box --> 