<!DOCTYPE html>

<html class="no-js" lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Change Program >> Zamboanga State College of Marine Sciences and Technology - MCP INC. - Electronic Student Management Information System - Copyright <?php echo date('Y')?></title>
      <meta name="csrf-token" content="<?php echo h($this->request->getAttribute('csrfToken')); ?>">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href = "<?php echo $base ?>/assets/img/zam.png">

    
    <link rel="stylesheet" href="<?php echo $base ?>assets/applications/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $base ?>assets/applications/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $base ?>assets/applications/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo $base ?>assets/applications/css/metisMenu.css">
    <link rel="stylesheet" href="<?php echo $base ?>assets/applications/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo $base ?>assets/applications/css/slicknav.min.css">
  
    <!-- others css -->
    <link rel="stylesheet" href="<?php echo $base ?>assets/applications/css/typography.css">
    <link rel="stylesheet" href="<?php echo $base ?>assets/applications/css/default-css.css">
    <link rel="stylesheet" href="<?php echo $base ?>assets/applications/css/styles.css">
    <link rel="stylesheet" href="<?php echo $base ?>assets/applications/css/responsive.css">
    <!-- modernizr css -->
    <script src="<?php echo $base ?>/assets/applications/js/vendor/modernizr-2.8.3.min.js"></script>

    <script>
      var base = '<?php echo $base ?>';
      var api  = '<?php echo $api  ?>';
      var tmp  = '<?php echo $tmp  ?>';
    </script>

  </head>


  <body ng-app="esmis" ng-controller="ApplicationController">
    <div id="preloader">
      <div class="loader"></div>
    </div>
    
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
    <!-- login area end -->

    <!-- jquery latest version -->
    <script src="<?php echo $base ?>assets/applications/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="<?php echo $base ?>assets/applications/js/popper.min.js"></script>
    <script src="<?php echo $base ?>assets/applications/js/bootstrap.min.js"></script>
    <script src="<?php echo $base ?>assets/applications/js/owl.carousel.min.js"></script>
    <script src="<?php echo $base ?>assets/applications/js/metisMenu.min.js"></script>
    <script src="<?php echo $base ?>assets/applications/js/jquery.slimscroll.min.js"></script>
    <script src="<?php echo $base ?>assets/applications/js/jquery.slicknav.min.js"></script>
    
    <!-- others plugins -->
    <script src="<?php echo $base ?>assets/applications/js/plugins.js"></script>
    <script src="<?php echo $base ?>assets/applications/js/scripts.js"></script>

    <?php echo $this->element('scripts') ?>

    <?php echo $this->element('angularjs') ?>

  </body>

  <script type="text/javascript">

    app.controller('ApplicationController', function($scope,$routeParams, $timeout,ChangeProgram,StudentApplication, Select) {
      
      $scope.id = $routeParams.id;

      var completeUrl = window.location.href;

      var application_id = completeUrl.match(/\d+/)[0];

      $('#form').validationEngine('attach');

      $scope.data = {

        StudentApplication: {}

      };

      Select.get({ code: 'student-application-details', id : application_id }, function(e) {

        $scope.data.StudentApplication.id = e.data.StudentApplication.id;

        $scope.data.StudentApplication.student_no = e.data.StudentApplication.student_no;

        $scope.data.StudentApplication.first_name = e.data.StudentApplication.first_name;

        $scope.data.StudentApplication.middle_name = e.data.StudentApplication.middle_name;

        $scope.data.StudentApplication.last_name = e.data.StudentApplication.last_name;

      });

      Select.get({ code: 'application-program-list-offered', id : application_id }, function(e) {

        $scope.programs = e.data;

      });

      $scope.save = function() {

        valid = $("#form").validationEngine('validate');

        if (valid) {

          bootbox.confirm('Are you sure you want to submit changes?', function (c) {

            if (c) {

              ChangeProgram.save({id:$scope.id},$scope.data, function(e) {

                if (e.ok) {

                  $.gritter.add({

                    title: 'Successful!',

                    text:  e.msg,

                  });

                    window.location = '<?php echo $base;?>pages/login';

                }else{

                  $.gritter.add({

                    title: 'Warning!',

                    text:  e.msg,

                  });

                }

              });
              
            }

          });

        }

      }

    });

  </script>

</html>

<style>

 .fileUpload {
  position: relative;
    overflow: hidden;
    margin: 10px 3px;
  }
  .fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    background-color:#fff;
    filter: alpha(opacity=0);
  }

  .filenameupload {
    width:100%;  
    overflow-y:auto;
  }

  #upload_prev {
    font-size: 
    width: 100%;
    padding:0.5em 1em 1.5em 1em;
  }

  #upload_prev span {
    display: flex;
    padding: 0 5px;
    font-size:13px;
  }

  p.close {
    cursor: pointer;
  }

</style>
<!-- 
<script>
  $(document).on('click','#close',function(){
    $(this).parents('span').remove();

  })

  document.getElementById('applicationImage').onchange = uploadOnChange;

  function uploadOnChange() {

    var filename = this.value;

    var lastIndex = filename.lastIndexOf("\\");

    if (lastIndex >= 0) {

      filename = filename.substring(lastIndex + 1);

    }

    var files = $('#applicationImage')[0].files;

    for (var i = 0; i < files.length; i++) {

      $("#upload_prev").append('<span><u>'+'<div class="filenameupload">'+files[i].name+'</u></div>'+'<p id = "close" class="btn btn-danger xbutton fa fa-times" style "background-color :red !important"></p></span>');
    
    }
  }
  
</script> -->