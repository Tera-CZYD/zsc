<!DOCTYPE html>

<html class="no-js" lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admission Portal >> Zamboanga State College of Marine Sciences and Technology - MCP INC. - Electronic Student Management Information System - Copyright <?php echo date('Y')?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href = "<?php echo $base ?>/assets/img/zam.png">
    <link rel="stylesheet" href="<?php echo $base ?>assets/student-portal/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $base ?>assets/student-portal/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $base ?>assets/student-portal/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo $base ?>assets/student-portal/css/metisMenu.css">
    <link rel="stylesheet" href="<?php echo $base ?>assets/student-portal/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo $base ?>assets/student-portal/css/slicknav.min.css">
  
    <!-- others css -->
    <link rel="stylesheet" href="<?php echo $base ?>assets/student-portal/css/typography.css">
    <link rel="stylesheet" href="<?php echo $base ?>assets/student-portal/css/default-css.css">
    <link rel="stylesheet" href="<?php echo $base ?>assets/student-portal/css/styles.css">
    <link rel="stylesheet" href="<?php echo $base ?>assets/student-portal/css/responsive.css">
    <!-- modernizr css -->
    <script src="<?php echo $base ?>/assets/student-portal/js/vendor/modernizr-2.8.3.min.js"></script>

    <!-- date picker css -->
    <link rel="stylesheet" href="<?php echo $base ?>assets/student-portal/css/datepicker.css">

    <script>
      var base = '<?php echo $base ?>';
      var api  = '<?php echo $api  ?>';
      var tmp  = '<?php echo $tmp  ?>';
    </script>


    <style type="text/css">
      .ss{
        box-shadow: 0 6px 10px rgba(0,0,0,.08), 0 0 6px rgba(0,0,0,.05);
      transition: .3s transform cubic-bezier(.155,1.105,.295,1.12),.3s box-shadow,.3s -webkit-transform cubic-bezier(.155,1.105,.295,1.12);
        
      }
      .ss:hover {
        transform:scale(1.1);
          box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
      }
      
      .bg1{
        background-color: linear-gradient(-45deg, #24ff72, #9a4eff);
      }

      .bg2{
        background-color: linear-gradient(-45deg, #f403d1, #64b5f6);
      }

      .bg3{
        background-color: linear-gradient(-45deg, #ffec61, #f321d7);
      }
    </style>


  </head>


  <body>
    <div id="preloader">
      <div class="loader"></div>
    </div>
   <!--  <nav class="navbar navbar-dark bg-dark" style="background-color: #2A3F54 !important; padding-left: 10%;">
      <a class="navbar-brand" href="/login">
        
      </a>
    </nav> -->

    
    
    <div class="login-area login-bg" >
      <div class="d-flex align-items-center justify-content-center">
        <img src="<?php echo $base ?>/assets/img/3dgifmaker69088.gif" width="150" height="150" class="d-inline-block align-top" alt="">
        <h3>ZAMBOANGA STATE COLLEGE OF MARINE AND TECHNOLOGY</h3>
    </div>
      <div class="container-fluid p-0">
        <div style="margin: 0 10% 0 10%;">
          <div class="row d-flex align-items-center justify-content-center">
            <div class="col-md-4" >
              <div class="login-box-s2 ptb--100">
                <a href="<?php echo $base ?>application">
                  <form id = "form" class="ss">
                    <div class="login-form-head">
                      <h4>New Applicants</h4>
                    </div>
                    <div style="border-bottom: 2px solid grey;">
                      <p style="text-align: center; padding: 10px">Content description here</p>
                    </div>
                    <div class="login-form-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <img src="<?php echo $base ?>/assets/img/NewApplicants.png" width="100%">
                          <!-- <span style="display: block; text-align: center; padding: 10px;">Image here</span> -->
                        </div>

                      </div>
                      <div class="submit-btn-area">
                        <a href="<?php echo $base ?>application" id="signup-link"><button>Sign Up <i class="ti-arrow-right"></i></button></a>
                      </div>

                    </div>
                  </form>
                </a>
              </div>
            </div>
            <div class="col-md-4">
              <div class="login-box-s2 ptb--100">
                <a href="<?php echo $base ?>incoming-freshmen-login">
                  <form id = "form" class="ss">
                    <div class="login-form-head">
                      <h4>Incoming Freshmen</h4>
                    </div>
                    <div style="border-bottom: 2px solid grey;">
                      <p style="text-align: center; padding: 10px">Content description here</p>
                    </div>
                    <div class="login-form-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <img src="<?php echo $base ?>/assets/img/IncomingFreshmen.png" width="100%">
                          <!-- <span style="display: block; text-align: center; padding: 10px;">Image here</span> -->
                        </div>

                      </div>
                      <div class="submit-btn-area">
                        <a href="<?php echo $base ?>incoming-freshmen-login" id="incoming-freshmen-link"><button>Login <i class="ti-arrow-right"></i></button></a>
                      </div>
                    </div>
                  </form>
                </a>
              </div>
            </div>
            <div class="col-md-4">
              <div class="login-box-s2 ptb--100">
                <a href="<?php echo $base ?>continuing-student-login">
                  <form id = "form" class="ss">
                    <div class="login-form-head">
                      <h4>Continuing Students</h4>
                    </div>
                    <div style="border-bottom: 2px solid grey;">
                      <p style="text-align: center; padding: 10px">Content description here</p>
                    </div>
                    <div class="login-form-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <img src="<?php echo $base ?>/assets/img/ContinuingStudent.png" width="100%">
                          <!-- <span style="display: block; text-align: center; padding: 10px;">Image here</span> -->
                        </div>

                      </div>
                      <div class="submit-btn-area">
                        <a href="<?php echo $base ?>continuing-student-login" id="continuing-student-link"><button>Login <i class="ti-arrow-right"></i></button></a>
                      </div>
                    </div>
                  </form>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- login area end -->

    <!-- jquery latest version -->
    <script src="<?php echo $base ?>assets/student-portal/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="<?php echo $base ?>assets/student-portal/js/popper.min.js"></script>
    <script src="<?php echo $base ?>assets/student-portal/js/bootstrap.min.js"></script>
    <script src="<?php echo $base ?>assets/student-portal/js/owl.carousel.min.js"></script>
    <script src="<?php echo $base ?>assets/student-portal/js/metisMenu.min.js"></script>
    <script src="<?php echo $base ?>assets/student-portal/js/jquery.slimscroll.min.js"></script>
    <script src="<?php echo $base ?>assets/student-portal/js/jquery.slicknav.min.js"></script>
    
    <!-- others plugins -->
    <script src="<?php echo $base ?>assets/student-portal/js/plugins.js"></script>
    <script src="<?php echo $base ?>assets/student-portal/js/scripts.js"></script>

    <?php echo $this->element('scripts') ?>

    <?php echo $this->element('angularjs') ?>

  </body>

</html>

<script>
  $(document).ready(function() {
    $('#signup-link').on('click', function(e) {
      e.preventDefault();
      window.location.href = $(this).attr('href');
    });
  });

  $(document).ready(function() {
    $('#incoming-freshmen-link').on('click', function(e) {
      e.preventDefault();
      window.location.href = $(this).attr('href');
    });
  });

  $(document).ready(function() {
    $('#continuing-student-link').on('click', function(e) {
      e.preventDefault();
      window.location.href = $(this).attr('href');
    });
  });
</script>