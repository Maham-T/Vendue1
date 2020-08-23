<? if($_SESSION["login"]  == true) { ?>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?=MYSURL?>dashboard" class="nav-link"><i class="fas fa-house-user"></i>&nbsp;&nbsp;Home</a>
      </li> 
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?=MYSURL?>dashboard" class="nav-link"><i class="fas fa-calendar-day"></i>&nbsp;&nbsp;<?=date('l jS \of F Y')?></a>
      </li> 
    </ul>

 
 
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item">
        <a class="nav-link" href="<?=MYSURL?>my-profile">
         <i class="fas fa-id-badge"></i>&nbsp;&nbsp;<?=$_SESSION["name"]?>/<?=$_SESSION["role"]?>
        </a>
      </li>
       <? if($_SESSION["role_id"] == "2"){ ?>
      <li class="nav-item">
        <a class="nav-link btn btn-success btn-flat text-white" href="<?=MYSURL?>products/add"> 
          <i class="far fa-calendar-check"></i>&nbsp;&nbsp;Sell </a> 
      </li>
      <? } ?>
      <li class="nav-item">
        <a class="nav-link" href="<?=MYSURL?>my-profile">
          <i class="fas fa-user-alt"></i> My Profile </a>
      </li> 
      <li class="nav-item">
        <a class="nav-link" href="<?=MYSURL?>logout">
         <i class="fas fa-sign-out-alt"></i>&nbsp;&nbsp;Logout
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
<? 
}else{
  ?>
 <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="<?=MYSURL?>" class="navbar-brand">
       <img src="<?=MYSURL?>assets/img/ilogo.png" alt="<?=COMPANY_NAME?>" class="brand-image img-circle elevation-3"
           style="opacity: .8"> 
        <span class="brand-text font-weight-light"><?=COMPANY_NAME?></span>
      </a>
   

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">

           <li class="nav-item">
            <a href="<?=MYSURL?>dashboard" class="nav-link"><i class="fas fa-house-user"></i>&nbsp;&nbsp;Home</a>
          </li> 
          <li class="nav-item">
            <a href="<?=MYSURL?>dashboard" class="nav-link"><i class="fas fa-calendar-day"></i>&nbsp;&nbsp;<?=date('l jS \of F Y')?></a>
          </li>    
        </ul>
 
      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <li class="nav-item">
        <a class="nav-link" href="<?=MYSURL?>signup">
         <i class="fas fa-user-plus"></i>&nbsp;&nbsp;Signup
        </a>
      </li>  
        <li class="nav-item">
        <a class="nav-link" href="<?=MYSURL?>login">
         <i class="fas fa-sign-in-alt"></i>&nbsp;&nbsp;Login
        </a>
      </li>   
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->
<?
} 
?>

