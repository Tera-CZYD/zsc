<!DOCTYPE html>
<html class="no-js" lang="en">
<?php echo $this->element('header') ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<body ng-app="esmis" class="nav-md footer_fixed">
  <?= $this->fetch('content') ?>
</body>

</html>