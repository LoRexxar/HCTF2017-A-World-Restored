<?php
require('./class/header.php');
if(!empty($_SESSION['user'])){
  $user = $_SESSION['user'];
}

?>

<section class="hero is-info is-large">
  <div class="hero-head">
    <nav class="navbar">
      <div class="container">
        <div class="navbar-brand">
          <a class="navbar-item">
            <h3>HCTF2017</h3>
          </a>
          <span class="navbar-burger burger" data-target="navbarMenuHeroB">
            <span></span>
            <span></span>
            <span></span>
          </span>
        </div>
        <div id="navbarMenuHeroB" class="navbar-menu">
          <div class="navbar-end">
            <a class="navbar-item is-active" href="index.php">
              Home
            </a>
<?php


if(!empty($user)){

  print <<< EOT
    <a class="navbar-item" href="user.php">
      User
    </a>
    <a class="navbar-item">
      Loading
    </a>
    <a class="navbar-item" href="report.php">
      Report Bug
    </a>
    <span class="navbar-item">
      <h3>$user </h3>
      <a class="button is-success is-outlined" style="margin-left: 10px" href="http://auth.2017.hctf.io/logout.php">  logout</a>
    </span>
EOT;

}else{

  print <<< EOT
            <span class="navbar-item">
              <a class="button is-info is-inverted" href="http://auth.2017.hctf.io/register.php">
                <span class="icon">
                  <i class="fa fa-sign-in"></i>
                </span>
                <span>SignUp</span>
              </a>
            </span>
            <span class="navbar-item">
              <a class="button is-info is-inverted" href="http://auth.2017.hctf.io/login.php">
                <span class="icon">
                  <i class="fa fa-sign-in"></i>
                </span>
                <span>SignIn</span>
              </a>
            </span>
EOT;
}
?>
          </div>
        </div>
      </div>
    </nav>
  </div>

  <div class="hero-body">
    <div class="container has-text-centered">
      <p class="title">
        A World Restored
      </p>
      <p class="subtitle">
        Powered by LoRexxar
      </p>
      <div class="content">
        Welcome to a world restored, Everything is new and without build, and look forward to changing with us here.
      </div>
    </div>
  </div>
</section>

<?php
  require('./class/footer.php');
?>
