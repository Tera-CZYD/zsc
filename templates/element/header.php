<head>
  <meta name="csrf-token" content="<?php echo h($this->request->getAttribute('csrfToken')); ?>">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Zamboanga State College of Marine Sciences and Technology - MCP INC. - Electronic Student Management Information System - Copyright <?php echo date('Y')?></title>
  <link rel="icon" href = "<?php echo $base ?>/assets/img/zam.png">


  <!-- Bootstrap -->
  <link href="<?php echo $base ?>/assets/css/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="<?php echo $base ?>/assets/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  
  <link rel="stylesheet" href="<?php echo $base ?>/assets/css/themify-icons.css">
  <!-- NProgress -->
  <link href="<?php echo $base ?>/assets/css/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="<?php echo $base ?>/assets/css/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="<?php echo $base ?>/assets/css/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>

  <!-- bootstrap-progressbar -->
  <link href="<?php echo $base ?>/assets/css/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
  <!-- JQVMap -->
  <link href="<?php echo $base ?>/assets/css/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
  <!-- bootstrap-daterangepicker -->
  <link href="<?php echo $base ?>/assets/css/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="<?php echo $base ?>/assets/css/custom.min.css" rel="stylesheet">

  <!-- loadingbar -->
  <link rel="stylesheet" href="<?php echo $base ?>/assets/plugins/angular-loading/loading-bar.css">

  <script>
    var base = '<?php echo $base ?>';
    var api  = '<?php echo $api  ?>';
    var tmp  = '<?php echo $tmp  ?>';
    var currentUser = <?= json_encode($currentUser) ?>;
  </script>
</head> 