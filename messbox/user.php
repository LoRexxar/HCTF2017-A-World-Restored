<?php
require('./class/header.php');

if(!isset($_SESSION['user']))
{
  echo "<script nonce='{$random}'>alert('you need login first!')</script>";
  echo "<script nonce='{$random}'>window.location.href='http://auth.2017.hctf.io/login.php?n_url='+document.URL</script>";
  exit; 
}

$user = $_SESSION['user'];

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
            <a class="navbar-item" href="index.php">
              Home
            </a>
            <a class="navbar-item is-active" href="user.php">
              User
            </a>
            <a class="navbar-item">
              Loading
            </a>
            <a class="navbar-item" href="report.php">
              Report Bug
            </a>
            <span class="navbar-item">
              <h3><?=$user?> </h3>
              <a class="button is-success is-outlined" style="margin-left: 10px" href="http://auth.2017.hctf.io/logout.php">  logout</a>
            </span>
          </div>
        </div>
      </div>
    </nav>
  </div>

  <div class="hero-body" style="padding-top: 20px">
    <div class="container has-text-centered">
      <div class="back box is-half is-offset-one-fifth">
        <div class="field">
          <label class="label">Username</label>
          <div class="control">
            <input id="user" class="input" type="text" placeholder="name" name="user" disabled="disabled" >
          </div>
        </div>

        <div class="field">
          <label class="label">Password</label>
          <div class="control">
            <input id="email" class="input" type="text" placeholder="password" name="email" disabled="disabled">
          </div>
        </div>

        <div class="field">
          <label class="label">Message</label>
          <div class="control">
            <textarea id="mess" class="textarea" placeholder="Message" name="message" disabled="disabled"></textarea>
          </div>
        </div>
        </div>
    </div>
  </div>
</section>

<script src="./static/js/LoRexxar.js"></script>
<script src="http://auth.2017.hctf.io/getmessage.php?callback=Update">
</script>


<?php
  require('./class/footer.php');
?>
