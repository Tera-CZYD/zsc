<!DOCTYPE html>
<html>
<head>
  <title>Learning Resource Center Login >> Zamboanga State College of Marine Sciences and Technology - MCP INC. - Student Management System - Copyright <?php echo date('Y')?></title>
  <link rel="stylesheet" href="<?php echo $base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $base ?>/assets/css/login.css">
  <link rel="stylesheet" href="<?php echo $base ?>/assets/plugins/font-awesome-4.2.0/css/font-awesome.css">
  <script type="text/javascript" src="<?php echo $base ?>/assets/plugins/jquery/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo $base ?>/assets/js/svg-icon.js"></script>
  <link rel="icon" href = "<?php echo $base ?>/assets/img/zam.png">
</head>
<?= $this->fetch('content') ?>
</html>

<script type="text/javascript">
  function showModal(){

    modal.style.display = "block";

  }
</script>

<style type="text/css">
  /* The Modal (background) */
  .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  }

  /* Modal Content */
  .modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 30%;
  }


  /* The Close Button */
  .close {
    color: #aaaaaa;
    float: right;
    font-size: 50px;
    font-weight: bold;
  }

  .close:hover,
  .close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
  }
</style>

<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close" style="margin-top: -5px">&times;</span>
    <p style="font-size: 18px; font-weight: bold; text-align: center; padding-top: 20px">Warning!</p>
    <p style="font-size: 15px; margin-top: 20px; text-align: center;">Incorrect username and password.</p>

  </div>
</div>

<script>
  // Get the modal
  var modal = document.getElementById("myModal");

  // Get the button that opens the modal
  var btn = document.getElementById("myBtn");

  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];

  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
</script>

  
<style type="text/css">

@-webkit-keyframes "pulse" {
  0% {
      -webkit-transform: scale(0);
      opacity: 0.0;
  }
  25% {
      -webkit-transform: scale(0);
      opacity: 0.1;
  }
  50% {
      -webkit-transform: scale(0.1);
      opacity: 0.3;
  }
  75% {
      -webkit-transform: scale(0.5);
      opacity: 0.5;
  }
  100% {
      -webkit-transform: scale(1);
      opacity: 0.0;
  }
}

.login-area {
    background: #F3F8FB;
}

.login-box {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    min-height: 100vh;
}

.login-form-head {
    text-align: center;
    background: #8655FC;
    padding: 50px;
}

.login-form-head h4 {
    letter-spacing: 0;
    text-transform: uppercase;
    font-weight: 600;
    margin-bottom: 7px;
    color: #fff;
}

.login-form-head p {
    color: #fff;
    font-size: 14px;
    line-height: 22px;
}

.login-form-body {
    padding: 50px;
}

.form-gp {
    margin-bottom: 25px;
    position: relative;
}

.form-gp label {
    position: absolute;
    left: 0;
    top: 0;
    color: #b3b2b2;
    -webkit-transition: all 0.3s ease 0s;
    transition: all 0.3s ease 0s;
}

.form-gp.focused label {
    top: -15px;
    color: #7e74ff;
}

.form-gp input {
    width: 100%;
    height: 30px;
    border: none;
    border-bottom: 1px solid #e6e6e6;
}

.form-gp input::-webkit-input-placeholder {
    color: #dad7d7;
}

.form-gp input::-moz-placeholder {
    color: #dad7d7;
}

.form-gp input:-ms-input-placeholder {
    color: #dad7d7;
}

.form-gp input:-moz-placeholder {
    color: #dad7d7;
}

.form-gp i {
    position: absolute;
    right: 5px;
    bottom: 15px;
    color: #7e74ff;
    font-size: 16px;
}

.login-other a {
    display: block;
    width: 100%;
    max-width: 250px;
    height: 43px;
    line-height: 43px;
    border-radius: 40px;
    text-transform: capitalize;
    letter-spacing: 0;
    font-weight: 600;
    font-size: 12px;
    box-shadow: 0 0 22px rgba(0, 0, 0, 0.07);
}

.login-other a i {
    margin-left: 5px;
}

.login-other a.fb-login {
    background: #8655FC;
    color: #fff;
}

.login-other a.fb-login:hover {
    box-shadow: 0 5px 15px rgba(44, 113, 218, 0.38);
}

.login-other a.google-login {
    background: #fb5757;
    color: #fff;
}

.login-other a.google-login:hover {
    box-shadow: 0 5px 15px rgba(251, 87, 87, 0.38);
}

.form-footer a {
    margin-left: 5px;
}

/* login-s2 */

.login-s2 {
    background: #fff;
    position: relative;
    z-index: 1;
    overflow: hidden;
}

.login-s2:before {
    content: '';
    position: absolute;
    height: 206%;
    width: 97%;
    background: #fcfcff;
    border-radius: 50%;
    left: -42%;
    z-index: -1;
    top: -47%;
    box-shadow: inset 0 0 51px rgba(0, 0, 0, 0.1);
}

.login-s2 .login-form-head,
.login-s2 .login-box form,
.login-s2 .login-box form .form-gp input {
    background: transparent;
}

.login-s2 .login-form-head h4,
.login-s2 .login-form-head p {
    color: #444;
}

/* login-s3 */

.login-bg {
    background: url(bg/bg1.png) center/cover no-repeat;
    position: relative;
    z-index: 1;
}

.login-bg:before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    z-index: -1;
    height: 100%;
    width: 100%;
    /*background: #272727;*/
    opacity: 0.7;
}

.login-box-s2 {
    min-height: 100vh;
    background: linear-gradient(to left, #263f6b 10%, #000000);
    width: 100%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}

.login-box-s2 .myContainer {
    margin: auto;
    width: 100%;
}

.myContainer2 {
    margin: auto;
    width: 100%;
    max-width: 500px;
}

</style>