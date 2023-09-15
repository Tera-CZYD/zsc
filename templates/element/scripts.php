<!-- jquery latest version -->
<script type="text/javascript" src="<?php echo $base ?>/assets/js/vendor/jquery-2.2.4.min.js"></script>

<!-- bootstrap 4 js -->
<script type="text/javascript" src="<?php echo $base ?>/assets/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/js/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/js/jquery.slicknav.min.js"></script>

<!-- default -->

<script type="text/javascript" src="<?php echo $base ?>/assets/plugins/bootbox/bootbox.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/plugins/scrollbar/jquery.mCustomScrollbar.min.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/js/svg-icon.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/plugins/icheck/icheck.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/plugins/inputmask/jquery.inputmask.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/plugins/gritter/js/jquery.gritter.min.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/plugins/selectize/selectize.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/plugins/timepicker/clockpicker.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/plugins/validation-engine/validate.min.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/plugins/validation-engine/validationEngine.min.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/plugins/summernote/summernote.min.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/plugins/select2/js/select2.min.js"></script>


<!-- Bootstrap -->
<script type="text/javascript" src="<?php echo $base ?>/assets/css/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- FastClick -->
<script type="text/javascript" src="<?php echo $base ?>/assets/css/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script type="text/javascript" src="<?php echo $base ?>/assets/css/nprogress/nprogress.js"></script>
<!-- Chart.js -->
<script type="text/javascript" src="<?php echo $base ?>/assets/css/Chart.js/dist/Chart.min.js"></script>
<!-- gauge.js -->
<script type="text/javascript" src="<?php echo $base ?>/assets/css/gauge.js/dist/gauge.min.js"></script>
<!-- bootstrap-progressbar -->
<script type="text/javascript" src="<?php echo $base ?>/assets/css/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<!-- iCheck -->
<script type="text/javascript" src="<?php echo $base ?>/assets/css/iCheck/icheck.min.js"></script>
<!-- Skycons -->
<script type="text/javascript" src="<?php echo $base ?>/assets/css/skycons/skycons.js"></script>
<!-- Flot -->
<script type="text/javascript" src="<?php echo $base ?>/assets/css/Flot/jquery.flot.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/css/Flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/css/Flot/jquery.flot.time.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/css/Flot/jquery.flot.stack.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/css/Flot/jquery.flot.resize.js"></script>
<!-- Flot plugins -->
<script type="text/javascript" src="<?php echo $base ?>/assets/css/flot.orderbars/js/jquery.flot.orderBars.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/css/flot-spline/js/jquery.flot.spline.min.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/css/flot.curvedlines/curvedLines.js"></script>
<!-- DateJS -->
<script type="text/javascript" src="<?php echo $base ?>/assets/css/DateJS/build/date.js"></script>
<!-- JQVMap -->
<script type="text/javascript" src="<?php echo $base ?>/assets/css/jqvmap/dist/jquery.vmap.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/css/jqvmap/dist/maps/jquery.vmap.world.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/css/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
<!-- bootstrap-daterangepicker -->
<script type="text/javascript" src="<?php echo $base ?>/assets/css/moment/min/moment.min.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/css/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/js/custom.min.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/css/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/js/scripts.js"></script>

<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>


<!--AnyChart-->
<script type="text/javascript" src="<?php echo $base ?>/assets/plugins/anychart/anychart-base.min.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/plugins/anychart/anychart-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/plugins/anychart/anychart-exports.min.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/plugins/anychart/sea.min.js"></script>


<script>
   var currentUser = <?= json_encode($currentUser) ?>;
</script>

<script>
   var base = <?php echo $base; ?>;
</script>

<!-- CHECKING OF USER PERMISSIONS -->

<script type="text/javascript">

   function hasAccess(code, user) {

     let result = false;

     if (user.roleId === 1) {

       result = true;

     }

     if (Array.isArray(user.user_permissions) && user.user_permissions.includes(code)) {

       result = true;

     }

     return result;

   }
  
</script>

<!-- END  -->