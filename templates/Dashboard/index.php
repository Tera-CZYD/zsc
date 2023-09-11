<?php if($currentUser['role']['code'] == 'Faculty'){ ?>

   <?php echo $this->element('faculty-dashboard') ?>

<?php }elseif($currentUser['role']['code'] == 'Student'){ ?>

   <?php echo $this->element('student-dashboard') ?>

<?php }else if($currentUser['role']['code'] == 'Guidance And Couseling Admin'){ ?>

   <?php echo $this->element('guidance-counselor-dashboard') ?>

<?php }else if($currentUser['role']['code'] == 'Dean'){ ?>

   <?php echo $this->element('dean-dashboard') ?>

<?php }else if($currentUser['role']['code'] == 'Vice President'){ ?>

   <?php echo $this->element('vice-president-dashboard') ?>

<?php }else{ ?>

  <?php echo $this->element('dashboard') ?>

<?php } ?>
